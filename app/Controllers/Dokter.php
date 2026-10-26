<?php

namespace App\Controllers;

use App\Libraries\KodeAntrean;
use App\Libraries\RekamMedisReferensi;
use App\Models\AuditLogModel;
use App\Models\DokterModel;
use App\Models\JadwalDokterModel;
use App\Models\PendaftaranModel;
use App\Models\RekamMedisModel;
use App\Models\RekamMedisRevisiModel;
use Config\Database;

class Dokter extends BaseController
{
    private function profilDokter(): ?array
    {
        return (new DokterModel())->where('id_user', session()->get('id_user'))->first();
    }

    private function wajibProfil(): array
    {
        $profil = $this->profilDokter();
        if (! $profil) {
            throw new \RuntimeException('Akun dokter belum terhubung ke data dokter. Hubungi admisi.');
        }
        return $profil;
    }

    public function index()
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $jadwal = (new JadwalDokterModel())
            ->where('id_dokter', $profil['id_dokter'])
            ->where('tanggal >=', date('Y-m-d'))
            ->orderBy('tanggal', 'ASC')->findAll();
        return view('dokter/index', ['dokter' => $profil, 'jadwal' => $jadwal]);
    }

    public function pasienTerjadwal()
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $db = Database::connect();
        $rows = $db->table('pendaftaran pd')
            ->select('pd.*, ps.no_rm, u.nama AS nama_pasien, j.tanggal, j.jam_mulai, p.nama_poli, p.kode_antrean AS kode_antrean_poli')
            ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->where('j.id_dokter', $profil['id_dokter'])
            ->where('pd.status !=', 'dibatalkan')
            ->orderBy('j.tanggal', 'ASC')->orderBy('pd.no_antrean', 'ASC')
            ->get()->getResultArray();
        $rows = KodeAntrean::pastikanDaftar($rows);
        return view('dokter/pasien', ['pendaftaran' => $rows, 'dokter' => $profil]);
    }

    public function jadwalForm(int $id)
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $jadwal = (new JadwalDokterModel())->find($id);
        if (! $jadwal || (int) $jadwal['id_dokter'] !== (int) $profil['id_dokter']) {
            return redirect()->to('/dokter')->with('error', 'Jadwal bukan milik Anda.');
        }
        return view('dokter/jadwal_form', ['jadwal' => $jadwal]);
    }

    public function jadwalSimpan()
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $id = (int) $this->request->getPost('id_jadwal');
        $jadwal = (new JadwalDokterModel())->find($id);
        if (! $jadwal || (int) $jadwal['id_dokter'] !== (int) $profil['id_dokter']) {
            return redirect()->to('/dokter')->with('error', 'Jadwal bukan milik Anda.');
        }
        if (! $this->validate([
            'tanggal'     => 'required|valid_date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'kuota'       => 'required|integer|greater_than[0]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali isian jadwal.');
        }
        // v2: v1 versi dokter tidak memeriksa urutan jam (versi admisi sudah).
        if ((string) $this->request->getPost('jam_mulai') >= (string) $this->request->getPost('jam_selesai')) {
            return redirect()->back()->withInput()->with('error', 'Jam selesai harus setelah jam mulai.');
        }
        (new JadwalDokterModel())->update($id, [
            'tanggal'     => $this->request->getPost('tanggal'),
            'jam_mulai'   => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'kuota'       => (int) $this->request->getPost('kuota'),
        ]);
        return redirect()->to('/dokter')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function rekamMedis()
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $db = Database::connect();
        $rows = $db->table('rekam_medis rm')
            ->select('rm.*, ps.no_rm, u.nama AS nama_pasien, pd.no_antrean, pd.kode_antrean, pd.kode_booking, j.tanggal')
            ->join('pasien ps', 'ps.id_pasien = rm.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->join('pendaftaran pd', 'pd.id_pendaftaran = rm.id_pendaftaran')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->where('rm.id_dokter', $profil['id_dokter'])
            ->orderBy('rm.tanggal_periksa', 'DESC')->get()->getResultArray();
        return view('dokter/rekam_medis', ['rekam_medis' => $rows]);
    }

    /**
     * Detail satu rekam medis milik dokter ini. Akses dicatat ke audit_log
     * (aksi "lihat") — ini yang dimaksud jejak akses rekam medis (NFR-K02).
     * v7: detail juga menampilkan riwayat revisi (koreksi beraudit).
     */
    public function rekamMedisLihat(int $idRekamMedis)
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $db  = Database::connect();
        $row = $db->table('rekam_medis rm')
            ->select('rm.*, ps.no_rm, u.nama AS nama_pasien, pd.no_antrean, pd.kode_antrean, pd.kode_booking, j.tanggal')
            ->join('pasien ps', 'ps.id_pasien = rm.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->join('pendaftaran pd', 'pd.id_pendaftaran = rm.id_pendaftaran')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->where('rm.id_rekam_medis', $idRekamMedis)
            ->where('rm.id_dokter', $profil['id_dokter'])
            ->get()->getRowArray();
        if (! $row) {
            return redirect()->to('/dokter/rekam-medis')->with('error', 'Rekam medis tidak ditemukan.');
        }
        (new AuditLogModel())->insert([
            'id_user'        => (int) session()->get('id_user'),
            'aksi'           => 'lihat',
            'id_pendaftaran' => (int) $row['id_pendaftaran'],
            'keterangan'     => 'Dokter melihat rekam medis id ' . $row['id_rekam_medis'] . '.',
        ]);
        $revisi = $db->table('rekam_medis_revisi rv')
            ->select('rv.*, u.nama AS nama_pengubah')
            ->join('users u', 'u.id_user = rv.id_user', 'left')
            ->where('rv.id_rekam_medis', $idRekamMedis)
            ->orderBy('rv.created_at', 'DESC')->orderBy('rv.id_revisi', 'DESC')
            ->get()->getResultArray();
        return view('dokter/rekam_medis_detail', ['rekam_medis' => $row, 'revisi' => $revisi]);
    }

    /** Baris pendaftaran lengkap untuk header kunjungan (read-only di form). */
    private function barisPendaftaran(int $idPendaftaran): ?array
    {
        $db = Database::connect();
        $row = $db->table('pendaftaran pd')
            ->select('pd.*, ps.no_rm, u.nama AS nama_pasien, j.tanggal, j.jam_mulai, j.jam_selesai, d.nama_dokter, p.nama_poli, p.kode_antrean AS kode_antrean_poli')
            ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->where('pd.id_pendaftaran', $idPendaftaran)->get()->getRowArray();
        return $row ? KodeAntrean::pastikanKode($row) : null;
    }

    public function rekamMedisForm(int $idPendaftaran)
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $cek = $this->cekPendaftaranDokter($idPendaftaran, (int) $profil['id_dokter']);
        if ($cek !== true) {
            return redirect()->to('/dokter/pasien')->with('error', $cek);
        }
        if ((new RekamMedisModel())->where('id_pendaftaran', $idPendaftaran)->first()) {
            return redirect()->to('/dokter/pasien')->with('error', 'Rekam medis untuk pendaftaran ini sudah ada. Gunakan tombol Ubah di detail rekam medis bila perlu koreksi.');
        }
        $row = $this->barisPendaftaran($idPendaftaran);
        if (! $row) {
            return redirect()->to('/dokter/pasien')->with('error', 'Pendaftaran tidak ditemukan.');
        }
        // v7: nilai awal form — keluhan (S) di-prefill dari keluhan_awal
        // pendaftaran, bisa diedit dokter; tanggal default hari ini.
        $nilai = [
            'tanggal_periksa' => date('Y-m-d'),
            'keluhan'         => $row['keluhan_awal'],
            'alergi'          => '',
            'ttv_sistolik'    => '', 'ttv_diastolik' => '', 'ttv_nadi' => '',
            'ttv_napas'       => '', 'ttv_suhu' => '', 'ttv_spo2' => '',
            'pemeriksaan_fisik' => '',
            'kode_diagnosis'  => '', 'diagnosis_bebas' => '',
            'tindakan'        => '', 'rencana' => '', 'catatan' => '',
            'tanpa_obat'      => false, 'resep_lines' => [],
        ];
        return view('dokter/rekam_medis_form', [
            'mode' => 'buat', 'aksi' => '/dokter/rekam-medis/pratinjau',
            'pendaftaran' => $row, 'rekam_medis' => null,
            'nilai' => $nilai, 'diagnosis_list' => RekamMedisReferensi::diagnosisList(),
            'ttv_ranges' => RekamMedisReferensi::ttvRanges(), 'errors' => [],
        ]);
    }

    /**
     * v7: Pratinjau konfirmasi sebelum simpan. Halaman ini TIDAK menyimpan
     * apa pun; simpan hanya terjadi pada POST konfirmasi kedua ke
     * rekamMedisSimpan (dengan flag pratinjau_ok). Validasi yang sama
     * persis dijalankan di kedua langkah.
     */
    public function rekamMedisPratinjau()
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $idPendaftaran = (int) $this->request->getPost('id_pendaftaran');
        $cek = $this->cekPendaftaranDokter($idPendaftaran, (int) $profil['id_dokter']);
        if ($cek !== true) {
            return redirect()->to('/dokter/pasien')->with('error', $cek);
        }
        if ((new RekamMedisModel())->where('id_pendaftaran', $idPendaftaran)->first()) {
            return redirect()->to('/dokter/pasien')->with('error', 'Rekam medis untuk pendaftaran ini sudah ada.');
        }
        $parsed = $this->parseRekamMedisInput();
        $row = $this->barisPendaftaran($idPendaftaran);
        if (! $row) {
            return redirect()->to('/dokter/pasien')->with('error', 'Pendaftaran tidak ditemukan.');
        }
        if ($parsed['errors'] !== []) {
            // Render langsung (bukan redirect) supaya nilai yang sudah
            // diisi — termasuk baris resep — tidak hilang.
            return view('dokter/rekam_medis_form', [
                'mode' => 'buat', 'aksi' => '/dokter/rekam-medis/pratinjau',
                'pendaftaran' => $row, 'rekam_medis' => null,
                'nilai' => $parsed['nilai'], 'diagnosis_list' => RekamMedisReferensi::diagnosisList(),
                'ttv_ranges' => RekamMedisReferensi::ttvRanges(), 'errors' => $parsed['errors'],
            ]);
        }
        return view('dokter/rekam_medis_pratinjau', [
            'pendaftaran' => $row, 'nilai' => $parsed['nilai'],
            'diagnosis_list' => RekamMedisReferensi::diagnosisList(),
            'ttv_ranges' => RekamMedisReferensi::ttvRanges(),
        ]);
    }

    /** Kembali dari pratinjau ke form, dengan nilai yang sudah diisi. */
    public function rekamMedisKembali()
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $idPendaftaran = (int) $this->request->getPost('id_pendaftaran');
        $cek = $this->cekPendaftaranDokter($idPendaftaran, (int) $profil['id_dokter']);
        if ($cek !== true) {
            return redirect()->to('/dokter/pasien')->with('error', $cek);
        }
        $row = $this->barisPendaftaran($idPendaftaran);
        if (! $row) {
            return redirect()->to('/dokter/pasien')->with('error', 'Pendaftaran tidak ditemukan.');
        }
        $parsed = $this->parseRekamMedisInput();
        return view('dokter/rekam_medis_form', [
            'mode' => 'buat', 'aksi' => '/dokter/rekam-medis/pratinjau',
            'pendaftaran' => $row, 'rekam_medis' => null,
            'nilai' => $parsed['nilai'], 'diagnosis_list' => RekamMedisReferensi::diagnosisList(),
            'ttv_ranges' => RekamMedisReferensi::ttvRanges(), 'errors' => [],
        ]);
    }

    public function rekamMedisSimpan()
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $idPendaftaran = (int) $this->request->getPost('id_pendaftaran');
        $cek = $this->cekPendaftaranDokter($idPendaftaran, (int) $profil['id_dokter']);
        if ($cek !== true) {
            return redirect()->to('/dokter/pasien')->with('error', $cek);
        }
        if ((new RekamMedisModel())->where('id_pendaftaran', $idPendaftaran)->first()) {
            return redirect()->to('/dokter/pasien')->with('error', 'Rekam medis untuk pendaftaran ini sudah ada.');
        }
        // Penegakan alur pratinjau: POST langsung tanpa melewati pratinjau
        // diarahkan ke pratinjau, bukan disimpan diam-diam.
        if ((string) $this->request->getPost('pratinjau_ok') !== '1') {
            return $this->rekamMedisPratinjau();
        }
        $parsed = $this->parseRekamMedisInput();
        if ($parsed['errors'] !== []) {
            $row = $this->barisPendaftaran($idPendaftaran);
            return view('dokter/rekam_medis_form', [
                'mode' => 'buat', 'aksi' => '/dokter/rekam-medis/pratinjau',
                'pendaftaran' => $row, 'rekam_medis' => null,
                'nilai' => $parsed['nilai'], 'diagnosis_list' => RekamMedisReferensi::diagnosisList(),
                'ttv_ranges' => RekamMedisReferensi::ttvRanges(), 'errors' => $parsed['errors'],
            ]);
        }
        $nilai       = $parsed['nilai'];
        $pendaftaran = (new PendaftaranModel())->find($idPendaftaran);
        $data        = $this->nilaiKeBaris($nilai);
        $data['id_pasien']      = (int) $pendaftaran['id_pasien'];
        $data['id_pendaftaran'] = $idPendaftaran;
        $data['id_dokter']      = (int) $profil['id_dokter'];
        (new RekamMedisModel())->insert($data);
        $idBaru = (int) (new RekamMedisModel())->getInsertID();
        (new AuditLogModel())->insert([
            'id_user'        => (int) session()->get('id_user'),
            'aksi'           => 'buat',
            'id_pendaftaran' => $idPendaftaran,
            'keterangan'     => 'Dokter membuat rekam medis id ' . $idBaru . ' untuk pendaftaran ' . $idPendaftaran . '.',
        ]);
        return redirect()->to('/dokter/rekam-medis')->with('success', 'Rekam medis berhasil disimpan.');
    }

    /** Form koreksi: hanya dokter pembuatnya, alasan wajib. */
    public function rekamMedisUbahForm(int $idRekamMedis)
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $row = (new RekamMedisModel())->where('id_rekam_medis', $idRekamMedis)
            ->where('id_dokter', (int) $profil['id_dokter'])->first();
        if (! $row) {
            return redirect()->to('/dokter/rekam-medis')->with('error', 'Rekam medis tidak ditemukan atau bukan milik Anda.');
        }
        $pendaftaran = $this->barisPendaftaran((int) $row['id_pendaftaran']);
        $nilai       = $this->barisKeNilai($row);
        return view('dokter/rekam_medis_form', [
            'mode' => 'ubah', 'aksi' => '/dokter/rekam-medis/ubah/' . $idRekamMedis,
            'pendaftaran' => $pendaftaran, 'rekam_medis' => $row,
            'nilai' => $nilai, 'diagnosis_list' => RekamMedisReferensi::diagnosisList(),
            'ttv_ranges' => RekamMedisReferensi::ttvRanges(), 'errors' => [],
        ]);
    }

    /** Simpan koreksi dengan jejak audit per field yang berubah. */
    public function rekamMedisUbahSimpan(int $idRekamMedis)
    {
        try {
            $profil = $this->wajibProfil();
        } catch (\RuntimeException $e) {
            return redirect()->to('/jadwal')->with('error', $e->getMessage());
        }
        $model = new RekamMedisModel();
        $lama  = $model->where('id_rekam_medis', $idRekamMedis)
            ->where('id_dokter', (int) $profil['id_dokter'])->first();
        if (! $lama) {
            return redirect()->to('/dokter/rekam-medis')->with('error', 'Rekam medis tidak ditemukan atau bukan milik Anda.');
        }
        $alasan = trim((string) $this->request->getPost('alasan'));
        $parsed = $this->parseRekamMedisInput();
        $errors = $parsed['errors'];
        if ($alasan === '') {
            $errors[] = 'Alasan koreksi wajib diisi.';
        }
        if ($errors !== []) {
            $pendaftaran = $this->barisPendaftaran((int) $lama['id_pendaftaran']);
            return view('dokter/rekam_medis_form', [
                'mode' => 'ubah', 'aksi' => '/dokter/rekam-medis/ubah/' . $idRekamMedis,
                'pendaftaran' => $pendaftaran, 'rekam_medis' => $lama,
                'nilai' => $parsed['nilai'], 'diagnosis_list' => RekamMedisReferensi::diagnosisList(),
                'ttv_ranges' => RekamMedisReferensi::ttvRanges(), 'errors' => $errors,
            ]);
        }
        $nilaiBaru = $this->nilaiKeBaris($parsed['nilai']);
        $labels    = RekamMedisReferensi::fieldLabels();
        $berubah   = [];
        foreach (array_keys($labels) as $field) {
            $old = $this->normalisasiBanding($field, $lama[$field] ?? null);
            $new = $this->normalisasiBanding($field, $nilaiBaru[$field] ?? null);
            if ($old !== $new) {
                $berubah[] = ['field' => $field, 'lama' => $old === '' ? null : $old, 'baru' => $new === '' ? null : $new];
            }
        }
        if ($berubah === []) {
            return redirect()->to('/dokter/rekam-medis/lihat/' . $idRekamMedis)
                ->with('error', 'Tidak ada perubahan yang disimpan. Ubah minimal satu field atau kembali ke detail.');
        }
        $nilaiBaru['updated_at'] = date('Y-m-d H:i:s');
        $model->update($idRekamMedis, $nilaiBaru);
        $revisiModel = new RekamMedisRevisiModel();
        foreach ($berubah as $b) {
            $revisiModel->insert([
                'id_rekam_medis' => $idRekamMedis,
                'field'          => $b['field'],
                'nilai_lama'     => $b['lama'],
                'nilai_baru'     => $b['baru'],
                'alasan'         => $alasan,
                'id_user'        => (int) session()->get('id_user'),
            ]);
        }
        (new AuditLogModel())->insert([
            'id_user'        => (int) session()->get('id_user'),
            'aksi'           => 'ubah',
            'id_pendaftaran' => (int) $lama['id_pendaftaran'],
            'keterangan'     => 'Dokter mengoreksi rekam medis id ' . $idRekamMedis . ' (' . implode(', ', array_column($berubah, 'field')) . '). Alasan: ' . $alasan,
        ]);
        return redirect()->to('/dokter/rekam-medis/lihat/' . $idRekamMedis)
            ->with('success', 'Koreksi berhasil disimpan dan tercatat di riwayat revisi.');
    }

    /**
     * @return true|string  True bila pendaftaran selesai dan milik dokter ini.
     */
    private function cekPendaftaranDokter(int $idPendaftaran, int $idDokter)
    {
        $pendaftaran = (new PendaftaranModel())->find($idPendaftaran);
        if (! $pendaftaran) {
            return 'Pendaftaran tidak ditemukan.';
        }
        $jadwal = (new JadwalDokterModel())->find((int) $pendaftaran['id_jadwal']);
        if (! $jadwal || (int) $jadwal['id_dokter'] !== $idDokter) {
            return 'Pendaftaran bukan milik Anda.';
        }
        if ($pendaftaran['status'] !== 'selesai') {
            return 'Rekam medis hanya dapat dibuat untuk pendaftaran berstatus selesai.';
        }
        return true;
    }

    /**
     * Parse + validasi server untuk form SOAP. Dipakai pratinjau, simpan,
     * dan ubah supaya aturannya tidak menyimpang antar langkah.
     * Mengembalikan ['nilai' => ..., 'errors' => [...]]; nilai selalu
     * lengkap (field kosong = ''/null) supaya form/pratinjau aman dirender.
     */
    private function parseRekamMedisInput(): array
    {
        $post   = fn (string $k) => $this->request->getPost($k);
        $teks   = fn (string $k) => trim((string) ($post($k) ?? ''));
        $errors = [];

        $nilai = [
            'tanggal_periksa' => $teks('tanggal_periksa'),
            'keluhan'         => $teks('keluhan'),
            'alergi'          => $teks('alergi') === '' ? null : $teks('alergi'),
            'pemeriksaan_fisik' => $teks('pemeriksaan_fisik') === '' ? null : $teks('pemeriksaan_fisik'),
            'tindakan'        => $teks('tindakan') === '' ? null : $teks('tindakan'),
            'rencana'         => $teks('rencana') === '' ? null : $teks('rencana'),
            'catatan'         => $teks('catatan') === '' ? null : $teks('catatan'),
        ];
        foreach (['ttv_sistolik', 'ttv_diastolik', 'ttv_nadi', 'ttv_napas', 'ttv_suhu', 'ttv_spo2'] as $f) {
            $nilai[$f] = null;
        }

        if ($nilai['tanggal_periksa'] === '' || strtotime($nilai['tanggal_periksa']) === false) {
            $errors[] = 'Tanggal periksa wajib diisi dengan tanggal yang valid.';
        }
        if ($nilai['keluhan'] === '') {
            $errors[] = 'Keluhan (S) wajib diisi.';
        }

        // TTV: opsional, tapi bila diisi harus numerik dalam rentang kewajaran.
        foreach (RekamMedisReferensi::ttvRanges() as $field => $spec) {
            $raw = $teks($field);
            if ($raw === '') {
                continue;
            }
            if (! is_numeric($raw)) {
                $errors[] = $spec['label'] . ' harus berupa angka.';
                continue;
            }
            $angka = (float) $raw;
            if ($angka < $spec['min'] || $angka > $spec['max']) {
                $errors[] = $spec['label'] . ' harus antara ' . $spec['min'] . ' dan ' . $spec['max'] . ' ' . $spec['satuan'] . '.';
                continue;
            }
            $nilai[$field] = $field === 'ttv_suhu' ? round($angka, 1) : (int) $angka;
        }

        // Diagnosis: dropdown ICD-10 terkurasi ATAU "Lainnya" + teks bebas.
        $list  = RekamMedisReferensi::diagnosisList();
        $kode  = strtoupper($teks('kode_diagnosis'));
        $bebas = $teks('diagnosis_bebas');
        if ($kode !== '' && $kode !== 'LAINNYA' && isset($list[$kode])) {
            $nilai['kode_diagnosis'] = $kode;
            $nilai['diagnosis']      = $list[$kode];
        } elseif ($kode === 'LAINNYA' && $bebas !== '') {
            $nilai['kode_diagnosis'] = null;
            $nilai['diagnosis']      = $bebas;
        } else {
            $nilai['kode_diagnosis'] = null;
            $nilai['diagnosis']      = '';
            $errors[] = 'Diagnosis wajib: pilih dari daftar ICD-10 atau pilih "Lainnya" dan isi diagnosis sendiri.';
        }
        $nilai['diagnosis_bebas'] = ($kode === 'LAINNYA') ? $bebas : '';

        // Resep terstruktur: baris-baris obat, atau pilihan eksplisit tanpa obat.
        $tanpaObat = (string) ($post('tanpa_obat') ?? '') === '1';
        $nilai['tanpa_obat'] = $tanpaObat;
        if ($tanpaObat) {
            $nilai['resep_lines'] = [];
            $nilai['resep']       = 'Tanpa obat';
        } else {
            $obats     = (array) ($post('resep_obat') ?? []);
            $dosis     = (array) ($post('resep_dosis') ?? []);
            $frekuensi = (array) ($post('resep_frekuensi') ?? []);
            $jumlah    = (array) ($post('resep_jumlah') ?? []);
            $aturan    = (array) ($post('resep_aturan') ?? []);
            $lines     = [];
            $adaBaris  = false;
            foreach ($obats as $i => $obatRaw) {
                $obat = trim((string) $obatRaw);
                $dos  = trim((string) ($dosis[$i] ?? ''));
                $fre  = trim((string) ($frekuensi[$i] ?? ''));
                $jum  = trim((string) ($jumlah[$i] ?? ''));
                $atu  = trim((string) ($aturan[$i] ?? ''));
                if ($obat === '' && $dos === '' && $fre === '' && $jum === '' && $atu === '') {
                    continue;
                }
                $adaBaris = true;
                if ($obat === '') {
                    $errors[] = 'Baris resep ke-' . ($i + 1) . ': nama obat wajib diisi.';
                    continue;
                }
                if ($dos === '' || $fre === '') {
                    $errors[] = 'Baris resep ke-' . ($i + 1) . ' (' . $obat . '): dosis dan frekuensi wajib diisi.';
                    continue;
                }
                $lines[] = [
                    'obat' => $obat, 'dosis' => $dos, 'frekuensi' => $fre,
                    'jumlah' => $jum, 'aturan' => $atu,
                ];
            }
            if (! $adaBaris) {
                $errors[] = "Resep wajib dipilih: centang 'Tanpa obat' atau isi minimal satu baris resep.";
                $nilai['resep_lines'] = [];
                $nilai['resep']       = null;
            } else {
                $nilai['resep_lines'] = $lines;
                $nilai['resep']       = implode("\n", array_map(
                    static fn (array $l) => RekamMedisReferensi::formatResepBaris($l['obat'], $l['dosis'], $l['frekuensi'], $l['jumlah'], $l['aturan']),
                    $lines
                ));
            }
        }
        return ['nilai' => $nilai, 'errors' => $errors];
    }

    /** Nilai form -> kolom database rekam_medis. */
    private function nilaiKeBaris(array $nilai): array
    {
        return [
            'tanggal_periksa'   => $nilai['tanggal_periksa'],
            'keluhan'           => $nilai['keluhan'],
            'alergi'            => $nilai['alergi'],
            'ttv_sistolik'      => $nilai['ttv_sistolik'],
            'ttv_diastolik'     => $nilai['ttv_diastolik'],
            'ttv_nadi'          => $nilai['ttv_nadi'],
            'ttv_napas'         => $nilai['ttv_napas'],
            'ttv_suhu'          => $nilai['ttv_suhu'],
            'ttv_spo2'          => $nilai['ttv_spo2'],
            'pemeriksaan_fisik' => $nilai['pemeriksaan_fisik'],
            'kode_diagnosis'    => $nilai['kode_diagnosis'],
            'diagnosis'         => $nilai['diagnosis'],
            'tindakan'          => $nilai['tindakan'],
            'resep'             => $nilai['resep'],
            'rencana'           => $nilai['rencana'],
            'catatan'           => $nilai['catatan'],
        ];
    }

    /** Baris database -> nilai form (untuk form ubah). */
    private function barisKeNilai(array $row): array
    {
        $resep = (string) ($row['resep'] ?? '');
        return [
            'tanggal_periksa' => $row['tanggal_periksa'] ?? date('Y-m-d'),
            'keluhan'         => $row['keluhan'] ?? '',
            'alergi'          => $row['alergi'] ?? '',
            'ttv_sistolik'    => $row['ttv_sistolik'] ?? '',
            'ttv_diastolik'   => $row['ttv_diastolik'] ?? '',
            'ttv_nadi'        => $row['ttv_nadi'] ?? '',
            'ttv_napas'       => $row['ttv_napas'] ?? '',
            'ttv_suhu'        => $row['ttv_suhu'] ?? '',
            'ttv_spo2'        => $row['ttv_spo2'] ?? '',
            'pemeriksaan_fisik' => $row['pemeriksaan_fisik'] ?? '',
            'kode_diagnosis'  => $row['kode_diagnosis'] ?? '',
            'diagnosis_bebas' => empty($row['kode_diagnosis']) ? ($row['diagnosis'] ?? '') : '',
            'tindakan'        => $row['tindakan'] ?? '',
            'rencana'         => $row['rencana'] ?? '',
            'catatan'         => $row['catatan'] ?? '',
            'tanpa_obat'      => $resep === 'Tanpa obat',
            'resep_lines'     => RekamMedisReferensi::parseResep($resep),
        ];
    }

    /** Normalisasi untuk perbandingan lama vs baru (null/'' dianggap sama). */
    private function normalisasiBanding(string $field, $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        if ($field === 'ttv_suhu' && is_numeric($value)) {
            return number_format((float) $value, 1);
        }
        if (in_array($field, ['ttv_sistolik', 'ttv_diastolik', 'ttv_nadi', 'ttv_napas', 'ttv_spo2'], true) && is_numeric($value)) {
            return (string) (int) $value;
        }
        return trim((string) $value);
    }
}
