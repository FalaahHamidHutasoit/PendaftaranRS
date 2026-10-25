<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\DokterModel;
use App\Models\JadwalDokterModel;
use App\Models\PendaftaranModel;
use App\Models\RekamMedisModel;
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
            ->select('pd.*, ps.no_rm, u.nama AS nama_pasien, j.tanggal, j.jam_mulai')
            ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->where('j.id_dokter', $profil['id_dokter'])
            ->where('pd.status !=', 'dibatalkan')
            ->orderBy('j.tanggal', 'ASC')->orderBy('pd.no_antrean', 'ASC')
            ->get()->getResultArray();
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
            ->select('rm.*, ps.no_rm, u.nama AS nama_pasien, pd.no_antrean, j.tanggal')
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
            ->select('rm.*, ps.no_rm, u.nama AS nama_pasien, pd.no_antrean, j.tanggal')
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
        return view('dokter/rekam_medis_detail', ['rekam_medis' => $row]);
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
        $db = Database::connect();
        $row = $db->table('pendaftaran pd')
            ->select('pd.*, ps.no_rm, u.nama AS nama_pasien, j.tanggal')
            ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->where('pd.id_pendaftaran', $idPendaftaran)->get()->getRowArray();
        return view('dokter/rekam_medis_form', ['pendaftaran' => $row]);
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
        if (! $this->validate([
            'tanggal_periksa' => 'required|valid_date',
            'diagnosis'       => 'required',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Tanggal periksa dan diagnosis wajib diisi.');
        }
        $pendaftaran = (new PendaftaranModel())->find($idPendaftaran);
        $model = new RekamMedisModel();
        if ($model->where('id_pendaftaran', $idPendaftaran)->first()) {
            return redirect()->to('/dokter/pasien')->with('error', 'Rekam medis untuk pendaftaran ini sudah ada.');
        }
        $model->insert([
            'id_pasien'       => (int) $pendaftaran['id_pasien'],
            'id_pendaftaran'  => $idPendaftaran,
            'id_dokter'       => (int) $profil['id_dokter'],
            'tanggal_periksa' => $this->request->getPost('tanggal_periksa'),
            'diagnosis'       => $this->request->getPost('diagnosis'),
            'tindakan'        => $this->request->getPost('tindakan') ?: null,
            'resep'           => $this->request->getPost('resep') ?: null,
            'catatan'         => $this->request->getPost('catatan') ?: null,
        ]);
        (new AuditLogModel())->insert([
            'id_user'        => (int) session()->get('id_user'),
            'aksi'           => 'buat',
            'id_pendaftaran' => $idPendaftaran,
            'keterangan'     => 'Dokter membuat rekam medis untuk pendaftaran ' . $idPendaftaran . '.',
        ]);
        return redirect()->to('/dokter/rekam-medis')->with('success', 'Rekam medis berhasil disimpan.');
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
}
