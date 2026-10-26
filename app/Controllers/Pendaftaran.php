<?php

namespace App\Controllers;

use App\Libraries\KodeAntrean;
use App\Models\JadwalDokterModel;
use App\Models\PasienModel;
use App\Models\PendaftaranModel;
use Config\Database;

class Pendaftaran extends BaseController
{
    private function pasienLogin(): ?array
    {
        return (new PasienModel())->where('id_user', session()->get('id_user'))->first();
    }

    public function riwayat()
    {
        $pasien = $this->pasienLogin();
        if (! $pasien) {
            return redirect()->to('/jadwal')->with('error', 'Profil pasien tidak ditemukan.');
        }
        $db = Database::connect();
        $rows = $db->table('pendaftaran pd')
            ->select('pd.*, j.tanggal, j.jam_mulai, j.jam_selesai, d.nama_dokter, p.nama_poli, p.kode_antrean AS kode_antrean_poli')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->where('pd.id_pasien', $pasien['id_pasien'])
            ->orderBy('pd.tanggal_daftar', 'DESC')
            ->get()->getResultArray();
        // v7: baris lama tanpa kode tidak boleh crash — lengkapi kode
        // antrean (turunan) dan kode booking (disimpan saat pertama kali
        // ditampilkan) sebelum dirender.
        $rows = KodeAntrean::pastikanDaftar($rows);
        // Pengingat H-1 (FR-P07): berdasarkan TANGGAL JADWAL besok, bukan
        // tanggal daftar. Hanya pendaftaran aktif (menunggu/dikonfirmasi).
        $besok = $db->table('pendaftaran pd')
            ->select('pd.id_pendaftaran, pd.no_antrean, pd.kode_antrean, pd.kode_booking, j.tanggal, j.jam_mulai, d.nama_dokter, p.nama_poli, p.kode_antrean AS kode_antrean_poli')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->where('pd.id_pasien', $pasien['id_pasien'])
            ->where('j.tanggal', date('Y-m-d', strtotime('+1 day')))
            ->whereIn('pd.status', ['menunggu', 'dikonfirmasi'])
            ->orderBy('j.jam_mulai', 'ASC')
            ->get()->getResultArray();
        $besok = KodeAntrean::pastikanDaftar($besok);
        return view('pendaftaran/riwayat', ['pendaftaran' => $rows, 'pasien' => $pasien, 'pengingat_besok' => $besok]);
    }

    public function buat(int $idJadwal)
    {
        $pasien = $this->pasienLogin();
        if (! $pasien) {
            return redirect()->to('/jadwal')->with('error', 'Profil pasien tidak ditemukan.');
        }
        if ($pasien['jenis_pasien'] === 'bpjs' && $pasien['status_bpjs'] === 'ditolak') {
            return redirect()->to('/jadwal')
                ->with('error', 'Pendaftaran diblokir karena status BPJS ditolak. Hubungi admisi.');
        }
        $jadwal = (new JadwalDokterModel())->find($idJadwal);
        if (! $jadwal || $jadwal['tanggal'] < date('Y-m-d')) {
            return redirect()->to('/jadwal')->with('error', 'Jadwal tidak ditemukan atau sudah lewat.');
        }
        $terisi = (new PendaftaranModel())
            ->where('id_jadwal', $idJadwal)
            ->where('status !=', 'dibatalkan')
            ->countAllResults();
        $sisa = max(0, (int) $jadwal['kuota'] - (int) $terisi);
        return view('pendaftaran/form', ['jadwal' => $jadwal, 'pasien' => $pasien, 'sisa_kuota' => $sisa]);
    }

    public function simpan()
    {
        $pasien = $this->pasienLogin();
        if (! $pasien) {
            return redirect()->to('/jadwal')->with('error', 'Profil pasien tidak ditemukan.');
        }
        $input = [
            'id_jadwal'       => (int) $this->request->getPost('id_jadwal'),
            'jenis_kunjungan' => (string) $this->request->getPost('jenis_kunjungan'),
            'keluhan_awal'    => (string) $this->request->getPost('keluhan_awal'),
            'no_rujukan'      => $this->request->getPost('no_rujukan'),
            'faskes_perujuk'  => $this->request->getPost('faskes_perujuk'),
        ];
        $hasil = $this->prosesSimpan($input, (int) $pasien['id_pasien'], $pasien);
        if (! $hasil['ok']) {
            return redirect()->back()->withInput()->with('error', $hasil['error']);
        }
        return redirect()->to('/pendaftaran')
            ->with('success', 'Pendaftaran berhasil. Kode antrean Anda: ' . $hasil['kode_antrean'] . '. Kode booking Anda: ' . $hasil['kode_booking'] . ' — tunjukkan kode ini (atau QR-nya di Beranda) saat check-in.');
    }

    public function apiSimpan()
    {
        $pasien = $this->pasienLogin();
        if (! $pasien) {
            return $this->response->setJSON(['ok' => false, 'error' => 'Login pasien diperlukan.'])->setStatusCode(401);
        }
        $json = $this->request->getJSON(true);
        if (! is_array($json)) {
            $json = [];
        }
        $input = [
            'id_jadwal'       => (int) ($json['id_jadwal'] ?? $this->request->getPost('id_jadwal')),
            'jenis_kunjungan' => (string) ($json['jenis_kunjungan'] ?? $this->request->getPost('jenis_kunjungan')),
            'keluhan_awal'    => (string) ($json['keluhan_awal'] ?? $this->request->getPost('keluhan_awal')),
            'no_rujukan'      => $json['no_rujukan'] ?? $this->request->getPost('no_rujukan'),
            'faskes_perujuk'  => $json['faskes_perujuk'] ?? $this->request->getPost('faskes_perujuk'),
        ];
        $hasil = $this->prosesSimpan($input, (int) $pasien['id_pasien'], $pasien);
        if (! $hasil['ok']) {
            return $this->response->setJSON(['ok' => false, 'error' => $hasil['error']])
                ->setStatusCode($hasil['code'] ?? 422);
        }
        return $this->response->setJSON([
            'ok'              => true,
            'id_pendaftaran'  => $hasil['id_pendaftaran'],
            'no_antrean'      => $hasil['no_antrean'],
            'kode_antrean'    => $hasil['kode_antrean'],
            'kode_booking'    => $hasil['kode_booking'],
            'status'          => 'menunggu',
        ])->setStatusCode(201);
    }

    public function batal(int $idPendaftaran)
    {
        $pasien = $this->pasienLogin();
        if (! $pasien) {
            return redirect()->to('/jadwal')->with('error', 'Profil pasien tidak ditemukan.');
        }
        $model = new PendaftaranModel();
        $row = $model->find($idPendaftaran);
        if (! $row || (int) $row['id_pasien'] !== (int) $pasien['id_pasien']) {
            return redirect()->to('/pendaftaran')->with('error', 'Pendaftaran tidak ditemukan.');
        }
        if (! in_array($row['status'], ['menunggu', 'dikonfirmasi'], true)) {
            return redirect()->to('/pendaftaran')->with('error', 'Hanya pendaftaran menunggu/dikonfirmasi yang dapat dibatalkan.');
        }
        $jadwal = (new JadwalDokterModel())->find((int) $row['id_jadwal']);
        if ($jadwal && $jadwal['tanggal'] <= date('Y-m-d')) {
            return redirect()->to('/pendaftaran')
                ->with('error', 'Pembatalan hanya dapat dilakukan sebelum hari praktik.');
        }
        $model->update($idPendaftaran, ['status' => 'dibatalkan']);
        return redirect()->to('/pendaftaran')->with('success', 'Pendaftaran berhasil dibatalkan. Kuota kembali tersedia.');
    }

    /**
     * Logika inti pendaftaran, dipakai bersama oleh form web dan endpoint API.
     * Aturan: kuota dihitung tanpa status dibatalkan, jadwal dikunci dalam
     * transaksi, booking aktif ganda ditolak, nomor antrean = MAX + 1 per jadwal.
     */
    private function prosesSimpan(array $input, int $idPasien, array $pasien): array
    {
        $gagal = static fn (string $msg, int $code = 422) => ['ok' => false, 'error' => $msg, 'code' => $code];
        if (empty($input['id_jadwal']) || ! in_array($input['jenis_kunjungan'] ?? '', ['baru', 'kontrol'], true)) {
            return $gagal('Jadwal dan jenis kunjungan wajib diisi dengan benar.');
        }
        if (trim((string) ($input['keluhan_awal'] ?? '')) === '') {
            return $gagal('Keluhan awal wajib diisi.');
        }
        if ($pasien['jenis_pasien'] === 'bpjs' && $pasien['status_bpjs'] === 'ditolak') {
            return $gagal('Pendaftaran diblokir karena status BPJS ditolak.', 403);
        }
        if ($pasien['jenis_pasien'] === 'bpjs' && $input['jenis_kunjungan'] === 'baru') {
            if (trim((string) ($input['no_rujukan'] ?? '')) === '' || trim((string) ($input['faskes_perujuk'] ?? '')) === '') {
                return $gagal('Pasien BPJS baru wajib mengisi nomor rujukan dan faskes perujuk.');
            }
        }
        $db = Database::connect();
        $db->transBegin();
        try {
            $jadwal = $db->query(
                'SELECT * FROM jadwal_dokter WHERE id_jadwal = ? FOR UPDATE',
                [(int) $input['id_jadwal']]
            )->getRowArray();
            if (! $jadwal) {
                throw new \RuntimeException('Jadwal tidak ditemukan.');
            }
            if ($jadwal['tanggal'] < date('Y-m-d')) {
                throw new \RuntimeException('Jadwal sudah lewat.');
            }
            $aktif = $db->table('pendaftaran')
                ->where('id_pasien', $idPasien)
                ->where('id_jadwal', (int) $input['id_jadwal'])
                ->whereIn('status', ['menunggu', 'dikonfirmasi'])
                ->countAllResults();
            if ($aktif > 0) {
                throw new \RuntimeException('Anda sudah memiliki booking aktif pada jadwal ini.', 409);
            }
            $terisi = $db->table('pendaftaran')
                ->where('id_jadwal', (int) $input['id_jadwal'])
                ->where('status !=', 'dibatalkan')
                ->countAllResults();
            if ($terisi >= (int) $jadwal['kuota']) {
                throw new \RuntimeException('Kuota jadwal sudah habis.', 409);
            }
            $maxAntrean = $db->table('pendaftaran')
                ->selectMax('no_antrean', 'maks')
                ->where('id_jadwal', (int) $input['id_jadwal'])
                ->get()->getRowArray();
            $noAntrean = ((int) ($maxAntrean['maks'] ?? 0)) + 1;
            // v7: kedua kode dihasilkan DALAM transaksi yang sama dengan
            // booking (jadwal sudah di-FOR UPDATE di atas, jadi tidak ada
            // nomor ganda). Huruf poli diambil dari jadwal -> dokter -> poli.
            $poliRow = $db->table('jadwal_dokter j')
                ->select('p.kode_antrean, p.nama_poli')
                ->join('dokter d', 'd.id_dokter = j.id_dokter')
                ->join('poli p', 'p.id_poli = d.id_poli')
                ->where('j.id_jadwal', (int) $input['id_jadwal'])
                ->get()->getRowArray();
            $huruf       = KodeAntrean::hurufPoli($poliRow ?: []);
            $kodeAntrean = KodeAntrean::format($noAntrean, $huruf);
            $kodeBooking = KodeAntrean::bookingUnik();
            $model = new PendaftaranModel();
            $model->insert([
                'id_pasien'       => $idPasien,
                'id_jadwal'       => (int) $input['id_jadwal'],
                'jenis_kunjungan' => $input['jenis_kunjungan'],
                'no_antrean'      => $noAntrean,
                'kode_antrean'    => $kodeAntrean,
                'kode_booking'    => $kodeBooking,
                'no_rujukan'      => $input['no_rujukan'] ?: null,
                'faskes_perujuk'  => $input['faskes_perujuk'] ?: null,
                'keluhan_awal'    => $input['keluhan_awal'],
                'status'          => 'menunggu',
            ]);
            $idPendaftaran = (int) $model->getInsertID();
            $db->transCommit();
            return ['ok' => true, 'id_pendaftaran' => $idPendaftaran, 'no_antrean' => $noAntrean, 'kode_antrean' => $kodeAntrean, 'kode_booking' => $kodeBooking];
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Simpan pendaftaran gagal: ' . $e->getMessage());
            $code = $e->getCode() === 409 ? 409 : 422;
            $pesan = in_array($e->getMessage(), [
                'Jadwal tidak ditemukan.', 'Jadwal sudah lewat.',
                'Anda sudah memiliki booking aktif pada jadwal ini.',
                'Kuota jadwal sudah habis.',
            ], true) ? $e->getMessage() : 'Pendaftaran gagal disimpan. Silakan coba lagi.';
            return $gagal($pesan, $code);
        }
    }
}
