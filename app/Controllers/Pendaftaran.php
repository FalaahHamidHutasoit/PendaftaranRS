<?php

namespace App\Controllers;

class Pendaftaran extends BaseController
{
    public function index()
    {
        return view('pendaftaran/index');
    }

    
public function simpan()
{
    $aturan = [
        'nama'          => 'required|min_length[3]|max_length[100]',
        'email'         => 'required|valid_email|max_length[100]',
        'password'      => 'required|min_length[8]',
        'nik'           => 'required|exact_length[16]|numeric',
        'tanggal_lahir' => 'required|valid_date[Y-m-d]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'alamat'        => 'required|max_length[255]',
        'jenis_pasien'  => 'required|in_list[umum,bpjs]',
        'no_bpjs'       => 'permit_empty|exact_length[13]|numeric',
        'no_hp'         => 'required|numeric|min_length[9]|max_length[15]',
        'golongan_darah' => 'required|in_list[A+,A-,B+,B-,AB+,AB-,O+,O-,tidak_tahu]',
        'alergi'        => 'permit_empty|max_length[255]',
    ];

    if (!$this->validate($aturan)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $db = \Config\Database::connect();

    $email = strtolower(trim($this->request->getPost('email')));
    $nik = trim($this->request->getPost('nik'));
    $jenisPasien = $this->request->getPost('jenis_pasien');
    $noBpjs = trim((string) $this->request->getPost('no_bpjs'));

    // Periksa email dan NIK agar tidak duplikat.
    if ($db->table('users')->where('email', $email)->countAllResults() > 0) {
        return redirect()->back()->withInput()
            ->with('pesan_error', 'Email sudah terdaftar.');
    }

    if ($db->table('pasien')->where('nik', $nik)->countAllResults() > 0) {
        return redirect()->back()->withInput()
            ->with('pesan_error', 'NIK sudah terdaftar.');
    }

    if ($jenisPasien === 'bpjs' && $noBpjs === '') {
        return redirect()->back()->withInput()
            ->with('pesan_error', 'Nomor BPJS wajib diisi (13 digit) untuk pasien BPJS.');
    }
    if ($jenisPasien === 'bpjs' && $db->table('pasien')->where('no_bpjs', $noBpjs)->countAllResults() > 0) {
        return redirect()->back()->withInput()
            ->with('pesan_error', 'Nomor BPJS sudah terdaftar.');
    }

    $db->transBegin();

    try {
        $db->table('users')->insert([
            'nama'     => trim($this->request->getPost('nama')),
            'email'    => $email,
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role'     => 'pasien',
        ]);

        $idUser = $db->insertID();

        // Nomor rekam medis sementara berdasarkan ID pasien.
        $db->table('pasien')->insert([
            'id_user'       => $idUser,
            'no_rm'         => 'TMP' . bin2hex(random_bytes(8)),
            'nik'           => $nik,
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat'        => trim($this->request->getPost('alamat')),
            'jenis_pasien'  => $jenisPasien,
            'no_bpjs'       => $jenisPasien === 'bpjs' ? $noBpjs : null,
            'status_bpjs'   => $jenisPasien === 'bpjs' ? 'menunggu' : 'tidak_berlaku',
            'no_hp'         => trim($this->request->getPost('no_hp')),
            'golongan_darah' => $this->request->getPost('golongan_darah'),
            'alergi'        => trim((string) $this->request->getPost('alergi')) ?: null,
        ]);

        // Nomor RM dibentuk dari id_pasien (unik per pasien), bukan id_user.
        $idPasien = $db->insertID();
        $noRm     = 'RM' . date('Ymd') . str_pad((string) $idPasien, 4, '0', STR_PAD_LEFT);
        $db->table('pasien')->where('id_pasien', $idPasien)->update(['no_rm' => $noRm]);

        if ($db->transStatus() === false) {
            throw new \RuntimeException('Penyimpanan data gagal.');
        }

        $db->transCommit();

        return redirect()->to(base_url('login'))
            ->with('pesan_sukses', 'Pendaftaran berhasil. Nomor rekam medis kamu: ' . $noRm . '. Silakan login.');

    } catch (\Throwable $e) {
        $db->transRollback();

        log_message('error', 'Pendaftaran pasien gagal: ' . $e->getMessage());

        return redirect()->back()->withInput()
            ->with('pesan_error', 'Pendaftaran gagal diproses. Periksa data dan coba kembali.');
    }
}

}
