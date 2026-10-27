<?php

namespace App\Controllers;

use App\Libraries\AuditTrail;
use App\Models\PasienModel;
use App\Models\UserModel;
use Config\Database;

class PendaftaranPasien extends BaseController
{
    public function index()
    {
        return view('pasien/register');
    }

    public function simpan()
    {
        $rules = [
            'nama'          => 'required|min_length[3]|max_length[100]',
            'email'         => 'required|valid_email|max_length[100]',
            'password'      => 'required|min_length[8]',
            'nik'           => 'required|regex_match[/^[0-9]{16}$/]',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'alamat'        => 'required|max_length[255]',
            'jenis_pasien'  => 'required|in_list[umum,bpjs]',
            'no_hp'         => 'permit_empty|max_length[15]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Periksa kembali isian formulir: ' . implode(' ', $this->validator->getErrors()));
        }
        $jenisPasien = (string) $this->request->getPost('jenis_pasien');
        $noBpjs      = trim((string) $this->request->getPost('no_bpjs'));
        if ($jenisPasien === 'bpjs' && $noBpjs === '') {
            return redirect()->back()->withInput()
                ->with('error', 'Nomor BPJS wajib diisi untuk jalur BPJS.');
        }
        $userModel   = new UserModel();
        $pasienModel = new PasienModel();
        $email = (string) $this->request->getPost('email');
        $nik   = (string) $this->request->getPost('nik');
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }
        if ($pasienModel->where('nik', $nik)->first()) {
            return redirect()->back()->withInput()->with('error', 'NIK sudah terdaftar.');
        }
        if ($jenisPasien === 'bpjs' && $pasienModel->where('no_bpjs', $noBpjs)->first()) {
            return redirect()->back()->withInput()->with('error', 'Nomor BPJS sudah terdaftar.');
        }
        $db = Database::connect();
        $idUser   = 0;
        $idPasien = 0;
        $db->transBegin();
        try {
            $userModel->insert([
                'nama'     => $this->request->getPost('nama'),
                'email'    => $email,
                'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'     => 'pasien',
            ]);
            $idUser = (int) $userModel->getInsertID();
            // v8 (P1.9): no_rm TIDAK LAGI dari COUNT pasien hari itu + 1.
            // Dua registrasi bersamaan bisa menghitung nomor yang sama,
            // sehingga salah satunya gagal walau datanya valid. Cara baru
            // (dalam transaksi yang sama): pasien dibuat dulu dengan
            // no_rm sementara yang unik per user, lalu no_rm final
            // diturunkan dari id_pasien (unik, jadi tidak bisa bentrok).
            // Makna format berubah: bukan lagi "urutan hari itu",
            // melainkan RM + tanggal + id_pasien (mis. RM202610260001
            // untuk id_pasien 1 pada 26 Okt 2026).
            $pasienModel->insert([
                'id_user'       => $idUser,
                'no_rm'         => 'RM-TMP-' . $idUser,
                'nik'           => $nik,
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat'        => $this->request->getPost('alamat'),
                'jenis_pasien'  => $jenisPasien,
                'no_bpjs'       => $jenisPasien === 'bpjs' ? $noBpjs : null,
                'status_bpjs'   => $jenisPasien === 'bpjs' ? 'menunggu' : 'tidak_berlaku',
                'no_hp'         => $this->request->getPost('no_hp') ?? '',
                'golongan_darah' => $this->request->getPost('golongan_darah') ?: 'tidak_tahu',
                'alergi'        => $this->request->getPost('alergi') ?: null,
            ]);
            $idPasien = (int) $pasienModel->getInsertID();
            $pasienModel->update($idPasien, [
                // STR_PAD_LEFT wajib: str_pad tanpa arah mengisi nol di
                // KANAN ('2' -> '2000'), sehingga id_pasien 2 dan 20
                // akan bentrok di UNIQUE no_rm. Nol di kiri ('0002')
                // menjamin keunikan turunan id_pasien.
                'no_rm' => 'RM' . date('Ymd') . str_pad((string) $idPasien, 4, '0', STR_PAD_LEFT),
            ]);
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Registrasi pasien gagal: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Pendaftaran gagal disimpan. Silakan coba lagi.');
        }
        // v8: audit registrasi (best-effort, tidak menggagalkan registrasi).
        if ($idPasien > 0) {
            AuditTrail::catat($idUser, 'registrasi', null, 'Pasien mendaftar akun baru id ' . $idPasien . '.');
        }
        return redirect()->to('/login')
            ->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function profil()
    {
        $pasien = (new PasienModel())->where('id_user', session()->get('id_user'))->first();
        if (! $pasien) {
            return redirect()->to('/jadwal')->with('error', 'Profil pasien tidak ditemukan.');
        }
        return view('pasien/profil', ['pasien' => $pasien]);
    }

    public function simpanProfil()
    {
        $pasienModel = new PasienModel();
        $pasien = $pasienModel->where('id_user', session()->get('id_user'))->first();
        if (! $pasien) {
            return redirect()->to('/jadwal')->with('error', 'Profil pasien tidak ditemukan.');
        }
        // v2: profil sebelumnya disimpan tanpa validasi sama sekali, sehingga
        // nilai enum yang tidak valid bisa memicu error database.
        if (! $this->validate([
            'alamat'         => 'required|max_length[255]',
            'no_hp'          => 'permit_empty|max_length[15]',
            'golongan_darah' => 'required|in_list[A+,A-,B+,B-,AB+,AB-,O+,O-,tidak_tahu]',
            'alergi'         => 'permit_empty|max_length[255]',
        ])) {
            return redirect()->back()->withInput()
                ->with('error', 'Periksa kembali isian profil: ' . implode(' ', $this->validator->getErrors()));
        }
        $pasienModel->update((int) $pasien['id_pasien'], [
            'alamat'         => $this->request->getPost('alamat'),
            'no_hp'          => $this->request->getPost('no_hp') ?? '',
            'golongan_darah' => $this->request->getPost('golongan_darah') ?: 'tidak_tahu',
            'alergi'         => $this->request->getPost('alergi') ?: null,
        ]);
        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
