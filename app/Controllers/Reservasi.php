<?php

namespace App\Controllers;

class Reservasi extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data['jadwal'] = $db->table('jadwal_dokter')
            ->select("
                jadwal_dokter.id_jadwal,
                jadwal_dokter.tanggal,
                jadwal_dokter.jam_mulai,
                jadwal_dokter.jam_selesai,
                jadwal_dokter.kuota,
                dokter.nama_dokter,
                poli.nama_poli,
                (
                    SELECT COUNT(*)
                    FROM reservasi
                    WHERE reservasi.id_jadwal = jadwal_dokter.id_jadwal
                    AND reservasi.status != 'dibatalkan'
                ) AS terisi
            ")
            ->join(
                'dokter',
                'dokter.id_dokter = jadwal_dokter.id_dokter'
            )
            ->join(
                'poli',
                'poli.id_poli = dokter.id_poli'
            )
            ->where('jadwal_dokter.tanggal >=', date('Y-m-d'))
            ->orderBy('jadwal_dokter.tanggal', 'ASC')
            ->orderBy('jadwal_dokter.jam_mulai', 'ASC')
            ->get()
            ->getResultArray();

        return view('reservasi/index', $data);
    }

    
public function form($idJadwal)
{
    $db = \Config\Database::connect();

    $jadwal = $db->table('jadwal_dokter')
        ->select("
            jadwal_dokter.id_jadwal,
            jadwal_dokter.tanggal,
            jadwal_dokter.jam_mulai,
            jadwal_dokter.jam_selesai,
            jadwal_dokter.kuota,
            dokter.nama_dokter,
            poli.nama_poli,
            (
                SELECT COUNT(*)
                FROM reservasi
                WHERE reservasi.id_jadwal = jadwal_dokter.id_jadwal
                AND reservasi.status != 'dibatalkan'
            ) AS terisi
        ")
        ->join(
            'dokter',
            'dokter.id_dokter = jadwal_dokter.id_dokter'
        )
        ->join(
            'poli',
            'poli.id_poli = dokter.id_poli'
        )
        ->where('jadwal_dokter.id_jadwal', $idJadwal)
        ->where('jadwal_dokter.tanggal >=', date('Y-m-d'))
        ->get()
        ->getRowArray();

    if (!$jadwal) {
        return redirect()->to(base_url('reservasi'))
            ->with('pesan_error', 'Jadwal dokter tidak ditemukan.');
    }

    $sisa = max(
        0,
        (int) $jadwal['kuota'] - (int) $jadwal['terisi']
    );

    if ($sisa <= 0) {
        return redirect()->to(base_url('reservasi'))
            ->with('pesan_error', 'Maaf, kuota jadwal ini sudah penuh.');
    }

    $pasien = $db->table('pasien')
        ->where('id_user', session()->get('id_user'))
        ->get()
        ->getRowArray();

    if (!$pasien) {
        return redirect()->to(base_url('reservasi'))
            ->with('pesan_error', 'Data pasien belum ditemukan. Silakan lengkapi data pasien.');
    }
    if ($pasien['jenis_pasien'] === 'bpjs' && $pasien['status_bpjs'] === 'ditolak') {
        return redirect()->to(base_url('profil'))
            ->with('pesan_error', 'Verifikasi BPJS kamu ditolak. Perbarui nomor BPJS di profil atau hubungi petugas.');
    }

    $data = [
        'jadwal' => $jadwal,
        'sisa'   => $sisa,
        'pasien' => $pasien,
    ];

    return view('reservasi/form', $data);
}

public function simpan()
{
    $db = \Config\Database::connect();

    // 1. Validasi input dari form
    $aturan = [
        'id_jadwal' => 'required|integer',
        'jenis_kunjungan' => 'required|in_list[baru,kontrol]',
        'keluhan_awal' => 'required|max_length[1000]'
    ];

    if (!$this->validate($aturan)) {
        return redirect()->back()
            ->withInput()
            ->with('pesan_error', 'Periksa kembali data pendaftaran kamu.');
    }

    $idJadwal = (int) $this->request->getPost('id_jadwal');
    $jenisKunjungan = $this->request->getPost('jenis_kunjungan');
    $keluhanAwal = trim($this->request->getPost('keluhan_awal'));

    // 2. Cari data pasien berdasarkan user yang sedang login
    $pasien = $db->table('pasien')
        ->where('id_user', session()->get('id_user'))
        ->get()
        ->getRowArray();

    if (!$pasien) {
        return redirect()->to(base_url('reservasi'))
            ->with('pesan_error', 'Data pasien belum ditemukan. Silakan lengkapi data pasien.');
    }

    $idPasien = (int) $pasien['id_pasien'];

    // ---- Aturan khusus pasien BPJS: wajib rujukan & BPJS tidak ditolak ----
    $noRujukan   = null;
    $faskesPerujuk = null;
    if ($pasien['jenis_pasien'] === 'bpjs') {
        if ($pasien['status_bpjs'] === 'ditolak') {
            return redirect()->to(base_url('profil'))
                ->with('pesan_error', 'Verifikasi BPJS kamu ditolak. Perbarui nomor BPJS di profil.');
        }

        $noRujukan     = strtoupper(trim((string) $this->request->getPost('no_rujukan')));
        $faskesPerujuk = trim((string) $this->request->getPost('faskes_perujuk'));

        if (!preg_match('/^[A-Z0-9\/\-]{6,30}$/', $noRujukan)) {
            return redirect()->back()->withInput()
                ->with('pesan_error', 'Nomor rujukan / surat kontrol wajib diisi (6–30 karakter huruf, angka, / atau -).');
        }
        if ($jenisKunjungan === 'baru' && ($faskesPerujuk === '' || mb_strlen($faskesPerujuk) > 100)) {
            return redirect()->back()->withInput()
                ->with('pesan_error', 'Faskes perujuk wajib diisi untuk kunjungan pasien baru (maks. 100 karakter).');
        }
        $faskesPerujuk = $faskesPerujuk !== '' ? $faskesPerujuk : null;
    }

    // 3. Mulai transaksi database
    $db->transBegin();

    try {
        // Kunci baris jadwal agar proses pendaftaran pada
        // jadwal yang sama tidak saling mendahului.
        $jadwal = $db->query(
            'SELECT id_jadwal, tanggal, kuota
             FROM jadwal_dokter
             WHERE id_jadwal = ?
             FOR UPDATE',
            [$idJadwal]
        )->getRowArray();

        if (!$jadwal || $jadwal['tanggal'] < date('Y-m-d')) {
            $db->transRollback();

            return redirect()->to(base_url('reservasi'))
                ->with('pesan_error', 'Jadwal tidak ditemukan atau sudah lewat.');
        }

        // 4. Cegah pasien mendaftar dua kali pada jadwal yang sama
        // Reservasi yang sudah dibatalkan tidak menghalangi daftar ulang.
        $duplikat = $db->table('reservasi')
            ->where('id_pasien', $idPasien)
            ->where('id_jadwal', $idJadwal)
            ->where('status !=', 'dibatalkan')
            ->countAllResults();

        if ($duplikat > 0) {
            $db->transRollback();

            return redirect()->to(base_url('reservasi'))
                ->with('pesan_error', 'Kamu sudah terdaftar pada jadwal dokter ini.');
        }

        // 5. Hitung jumlah reservasi yang masih aktif
        $terisi = $db->table('reservasi')
            ->where('id_jadwal', $idJadwal)
            ->where('status !=', 'dibatalkan')
            ->countAllResults();

        if ($terisi >= (int) $jadwal['kuota']) {
            $db->transRollback();

            return redirect()->to(base_url('reservasi'))
                ->with('pesan_error', 'Maaf, kuota jadwal ini sudah penuh.');
        }

        // 6. Tentukan nomor antrean berikutnya
        $hasilAntrean = $db->query(
            'SELECT COALESCE(MAX(CAST(no_antrean AS UNSIGNED)), 0) + 1
             AS nomor_berikutnya
             FROM reservasi
             WHERE id_jadwal = ?',
            [$idJadwal]
        )->getRowArray();

        $nomorAntrean = (int) $hasilAntrean['nomor_berikutnya'];

        // 7. Simpan pendaftaran
        $db->table('reservasi')->insert([
            'id_pasien'       => $idPasien,
            'id_jadwal'       => $idJadwal,
            'jenis_kunjungan' => $jenisKunjungan,
            'no_antrean'      => $nomorAntrean,
            'no_rujukan'      => $noRujukan,
            'faskes_perujuk'  => $faskesPerujuk,
            'keluhan_awal'    => $keluhanAwal,
            'status'          => 'menunggu'
        ]);

        if ($db->transStatus() === false) {
            throw new \RuntimeException('Gagal menyimpan reservasi.');
        }

        $db->transCommit();

        return redirect()->to(base_url('reservasi'))
            ->with(
                'pesan_sukses',
                'Pendaftaran berhasil! Nomor antrean kamu: ' . $nomorAntrean
            );

    } catch (\Throwable $e) {
        $db->transRollback();

        log_message('error', 'Gagal menyimpan reservasi: ' . $e->getMessage());

        return redirect()->back()
            ->withInput()
            ->with('pesan_error', 'Pendaftaran gagal disimpan. Silakan coba lagi.');
    }
}



public function batal($idReservasi)
{
    $db = \Config\Database::connect();

    $pasien = $db->table('pasien')
        ->where('id_user', session()->get('id_user'))
        ->get()
        ->getRowArray();

    // Hanya pemilik reservasi yang boleh membatalkan, dan hanya sebelum hari praktik.
    $row = $pasien ? $db->table('reservasi')
        ->select('reservasi.id_reservasi, reservasi.status, jadwal_dokter.tanggal')
        ->join('jadwal_dokter', 'jadwal_dokter.id_jadwal = reservasi.id_jadwal')
        ->where('reservasi.id_reservasi', $idReservasi)
        ->where('reservasi.id_pasien', $pasien['id_pasien'])
        ->get()
        ->getRowArray() : null;

    if (!$row) {
        return redirect()->to(base_url('riwayat-reservasi'))
            ->with('pesan_error', 'Reservasi tidak ditemukan.');
    }
    if (!in_array($row['status'], ['menunggu', 'dikonfirmasi'], true) || $row['tanggal'] <= date('Y-m-d')) {
        return redirect()->to(base_url('riwayat-reservasi'))
            ->with('pesan_error', 'Reservasi ini tidak dapat dibatalkan. Pembatalan maksimal H-1 sebelum jadwal praktik.');
    }

    $db->table('reservasi')
        ->where('id_reservasi', $idReservasi)
        ->update(['status' => 'dibatalkan']);

    return redirect()->to(base_url('riwayat-reservasi'))
        ->with('pesan_sukses', 'Reservasi berhasil dibatalkan.');
}

public function riwayat()
{
    $db = \Config\Database::connect();

    $pasien = $db->table('pasien')
        ->where('id_user', session()->get('id_user'))
        ->get()
        ->getRowArray();

    if (!$pasien) {
        return redirect()->to(base_url('reservasi'))
            ->with('pesan_error', 'Data pasien tidak ditemukan.');
    }

    $data['riwayat'] = $db->table('reservasi')
        ->select('
            reservasi.*,
            jadwal_dokter.tanggal,
            jadwal_dokter.jam_mulai,
            jadwal_dokter.jam_selesai,
            dokter.nama_dokter,
            poli.nama_poli
        ')
        ->join(
            'jadwal_dokter',
            'jadwal_dokter.id_jadwal = reservasi.id_jadwal'
        )
        ->join(
            'dokter',
            'dokter.id_dokter = jadwal_dokter.id_dokter'
        )
        ->join(
            'poli',
            'poli.id_poli = dokter.id_poli'
        )
        ->where('reservasi.id_pasien', $pasien['id_pasien'])
        ->orderBy('reservasi.tanggal_daftar', 'DESC')
        ->get()
        ->getResultArray();

    return view('reservasi/riwayat', $data);
}


}
