<?php

namespace App\Controllers;

use App\Models\PasienModel;

/**
 * Profil pasien: melihat data rekam medis awal, memperbarui kontak/golongan darah/alergi,
 * dan mengajukan ulang verifikasi BPJS.
 */
class Profil extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $pasien = $db->table('pasien')
            ->select('pasien.*, users.nama, users.email')
            ->join('users', 'users.id_user = pasien.id_user')
            ->where('pasien.id_user', session()->get('id_user'))
            ->get()
            ->getRowArray();

        if (!$pasien) {
            return redirect()->to(base_url('reservasi'))
                ->with('pesan_error', 'Data pasien tidak ditemukan.');
        }

        return view('pasien/profil', ['pasien' => $pasien]);
    }

    public function simpan()
    {
        $aturan = [
            'no_hp'          => 'required|numeric|min_length[9]|max_length[15]',
            'golongan_darah' => 'required|in_list[A+,A-,B+,B-,AB+,AB-,O+,O-,tidak_tahu]',
            'alergi'         => 'permit_empty|max_length[255]',
            'alamat'         => 'required|max_length[255]',
            'no_bpjs'        => 'permit_empty|exact_length[13]|numeric',
        ];
        if (!$this->validate($aturan)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model  = new PasienModel();
        $pasien = $model->where('id_user', session()->get('id_user'))->first();
        if (!$pasien) {
            return redirect()->to(base_url('reservasi'))
                ->with('pesan_error', 'Data pasien tidak ditemukan.');
        }

        $data = [
            'no_hp'          => trim($this->request->getPost('no_hp')),
            'golongan_darah' => $this->request->getPost('golongan_darah'),
            'alergi'         => trim((string) $this->request->getPost('alergi')) ?: null,
            'alamat'         => trim($this->request->getPost('alamat')),
        ];

        // Pasien BPJS boleh memperbaiki nomor BPJS selama belum terverifikasi.
        $pesan = 'Profil berhasil diperbarui.';
        if ($pasien['jenis_pasien'] === 'bpjs') {
            $noBpjs = trim((string) $this->request->getPost('no_bpjs'));
            if ($noBpjs !== '' && $noBpjs !== $pasien['no_bpjs']) {
                if ($pasien['status_bpjs'] === 'terverifikasi') {
                    return redirect()->back()->withInput()
                        ->with('pesan_error', 'Nomor BPJS yang sudah terverifikasi hanya bisa diubah oleh petugas.');
                }
                if ($model->where('no_bpjs', $noBpjs)->where('id_pasien !=', $pasien['id_pasien'])->countAllResults() > 0) {
                    return redirect()->back()->withInput()
                        ->with('pesan_error', 'Nomor BPJS sudah digunakan pasien lain.');
                }
                $data['no_bpjs']      = $noBpjs;
                $data['status_bpjs']  = 'menunggu';
                $data['catatan_bpjs'] = null;
                $pesan = 'Profil diperbarui. Nomor BPJS baru menunggu verifikasi petugas.';
            }
        }

        $model->update($pasien['id_pasien'], $data);

        return redirect()->to(base_url('profil'))->with('pesan_sukses', $pesan);
    }
}
