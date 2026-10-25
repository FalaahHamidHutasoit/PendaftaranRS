<?php

namespace App\Controllers;

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
        $db->transBegin();
        try {
            $userModel->insert([
                'nama'     => $this->request->getPost('nama'),
                'email'    => $email,
                'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'     => 'pasien',
            ]);
            $idUser = (int) $userModel->getInsertID();
            $today  = date('Y-m-d');
            $countToday = $pasienModel
                ->where('created_at >=', $today . ' 00:00:00')
                ->where('created_at <', date('Y-m-d', strtotime('+1 day')) . ' 00:00:00')
                ->countAllResults();
            $noRm = 'RM' . date('Ymd') . str_pad((string) ($countToday + 1), 4, '0', STR_PAD_LEFT);
            $pasienModel->insert([
                'id_user'       => $idUser,
                'no_rm'         => $noRm,
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
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Registrasi pasien gagal: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Pendaftaran gagal disimpan. Silakan coba lagi.');
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
