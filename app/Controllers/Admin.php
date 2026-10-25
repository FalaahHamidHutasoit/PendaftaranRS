<?php

namespace App\Controllers;

use App\Models\DokterModel;
use App\Models\JadwalDokterModel;
use App\Models\PasienModel;
use App\Models\PendaftaranModel;
use App\Models\PoliModel;
use App\Models\UserModel;
use Config\Database;

class Admin extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $data = [
            'total_pasien'      => (new PasienModel())->countAllResults(),
            'total_dokter'      => (new DokterModel())->countAllResults(),
            'total_jadwal'      => (new JadwalDokterModel())->where('tanggal >=', date('Y-m-d'))->countAllResults(),
            'menunggu'          => (new PendaftaranModel())->where('status', 'menunggu')->countAllResults(),
            'terbaru'           => $db->table('pendaftaran pd')
                ->select('pd.*, ps.no_rm, u.nama AS nama_pasien, j.tanggal, d.nama_dokter')
                ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
                ->join('users u', 'u.id_user = ps.id_user')
                ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
                ->join('dokter d', 'd.id_dokter = j.id_dokter')
                ->orderBy('pd.tanggal_daftar', 'DESC')->limit(10)
                ->get()->getResultArray(),
        ];
        return view('admin/dashboard', $data);
    }

    // ---------- Poli ----------
    public function poli()
    {
        return view('admin/poli', ['poli' => (new PoliModel())->orderBy('nama_poli')->findAll()]);
    }

    public function poliForm(?int $id = null)
    {
        $row = $id ? (new PoliModel())->find($id) : null;
        return view('admin/poli_form', ['poli' => $row]);
    }

    public function poliSimpan()
    {
        if (! $this->validate(['nama_poli' => 'required|max_length[100]'])) {
            return redirect()->back()->withInput()->with('error', 'Nama poli wajib diisi.');
        }
        $model = new PoliModel();
        $id = (int) $this->request->getPost('id_poli');
        if ($id && ! $model->find($id)) {
            return redirect()->to('/admin/poli')->with('error', 'Poli tidak ditemukan.');
        }
        $ada = $model->where('nama_poli', $this->request->getPost('nama_poli'))->first();
        if ($ada && (int) $ada['id_poli'] !== $id) {
            return redirect()->back()->withInput()->with('error', 'Nama poli sudah digunakan.');
        }
        $data = ['nama_poli' => $this->request->getPost('nama_poli'), 'deskripsi' => $this->request->getPost('deskripsi') ?: null];
        $id ? $model->update($id, $data) : $model->insert($data);
        return redirect()->to('/admin/poli')->with('success', 'Data poli berhasil disimpan.');
    }

    public function poliHapus(int $id)
    {
        if ((new DokterModel())->where('id_poli', $id)->first()) {
            return redirect()->to('/admin/poli')->with('error', 'Poli tidak dapat dihapus karena masih memiliki dokter.');
        }
        (new PoliModel())->delete($id);
        return redirect()->to('/admin/poli')->with('success', 'Poli berhasil dihapus.');
    }

    // ---------- Dokter ----------
    public function dokter()
    {
        $db = Database::connect();
        $rows = $db->table('dokter d')
            ->select('d.*, p.nama_poli, u.nama AS nama_akun')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->join('users u', 'u.id_user = d.id_user', 'left')
            ->orderBy('d.nama_dokter')->get()->getResultArray();
        return view('admin/dokter', ['dokter' => $rows]);
    }

    public function dokterForm(?int $id = null)
    {
        $row = $id ? (new DokterModel())->find($id) : null;
        $akunDokter = (new UserModel())->where('role', 'dokter')->orderBy('nama')->findAll();
        return view('admin/dokter_form', [
            'dokter' => $row,
            'poli'   => (new PoliModel())->orderBy('nama_poli')->findAll(),
            'akun'   => $akunDokter,
        ]);
    }

    public function dokterSimpan()
    {
        if (! $this->validate([
            'id_poli'      => 'required|integer',
            'nama_dokter'  => 'required|max_length[100]',
            'spesialisasi' => 'required|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali isian dokter.');
        }
        if (! (new PoliModel())->find((int) $this->request->getPost('id_poli'))) {
            return redirect()->back()->withInput()->with('error', 'Poli yang dipilih tidak ditemukan.');
        }
        $idUser = $this->request->getPost('id_user');
        $idUser = $idUser === '' ? null : (int) $idUser;
        if ($idUser !== null) {
            $akun = (new UserModel())->find($idUser);
            if (! $akun || $akun['role'] !== 'dokter') {
                return redirect()->back()->withInput()->with('error', 'Akun yang dipilih bukan akun dokter.');
            }
            $id = (int) $this->request->getPost('id_dokter');
            $terpakai = (new DokterModel())->where('id_user', $idUser)->first();
            if ($terpakai && (int) $terpakai['id_dokter'] !== $id) {
                return redirect()->back()->withInput()->with('error', 'Akun dokter sudah terhubung ke dokter lain.');
            }
        }
        $model = new DokterModel();
        $id = (int) $this->request->getPost('id_dokter');
        if ($id && ! $model->find($id)) {
            return redirect()->to('/admin/dokter')->with('error', 'Dokter tidak ditemukan.');
        }
        $data = [
            'id_poli'      => (int) $this->request->getPost('id_poli'),
            'id_user'      => $idUser,
            'nama_dokter'  => $this->request->getPost('nama_dokter'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
        ];
        $id ? $model->update($id, $data) : $model->insert($data);
        return redirect()->to('/admin/dokter')->with('success', 'Data dokter berhasil disimpan.');
    }

    /**
     * v2: v1 tidak menyediakan cara membuat akun login dokter lewat UI —
     * registrasi hanya membuat peran pasien, dan form dokter hanya bisa
     * menautkan akun dokter yang sudah ada. Akibatnya admisi tidak bisa
     * meng-onboard dokter baru tanpa menyentuh database. Formulir ini
     * menutup celah itu: buat akun peran dokter, lalu tautkan lewat
     * form dokter seperti biasa.
     */
    public function akunDokterSimpan()
    {
        if (! $this->validate([
            'nama'     => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|max_length[100]',
            'password' => 'required|min_length[8]',
        ])) {
            return redirect()->back()->withInput()
                ->with('error', 'Periksa kembali isian akun dokter: ' . implode(' ', $this->validator->getErrors()));
        }
        $email = (string) $this->request->getPost('email');
        if ((new UserModel())->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }
        (new UserModel())->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $email,
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'dokter',
        ]);
        return redirect()->to('/admin/dokter')
            ->with('success', 'Akun dokter berhasil dibuat. Tautkan akun ini lewat form Tambah/Ubah Dokter.');
    }

    public function dokterHapus(int $id)
    {
        if ((new JadwalDokterModel())->where('id_dokter', $id)->first()) {
            return redirect()->to('/admin/dokter')->with('error', 'Dokter tidak dapat dihapus karena masih memiliki jadwal.');
        }
        (new DokterModel())->delete($id);
        return redirect()->to('/admin/dokter')->with('success', 'Dokter berhasil dihapus.');
    }

    // ---------- Jadwal ----------
    public function jadwal()
    {
        $db = Database::connect();
        $rows = $db->table('jadwal_dokter j')
            ->select('j.*, d.nama_dokter, p.nama_poli')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->orderBy('j.tanggal', 'DESC')->orderBy('j.jam_mulai', 'ASC')
            ->get()->getResultArray();
        return view('admin/jadwal', ['jadwal' => $rows]);
    }

    public function jadwalForm(?int $id = null)
    {
        $row = $id ? (new JadwalDokterModel())->find($id) : null;
        return view('admin/jadwal_form', [
            'jadwal' => $row,
            'dokter' => (new DokterModel())->orderBy('nama_dokter')->findAll(),
        ]);
    }

    public function jadwalSimpan()
    {
        if (! $this->validate([
            'id_dokter'   => 'required|integer',
            'tanggal'     => 'required|valid_date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'kuota'       => 'required|integer|greater_than[0]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali isian jadwal.');
        }
        if ((string) $this->request->getPost('jam_mulai') >= (string) $this->request->getPost('jam_selesai')) {
            return redirect()->back()->withInput()->with('error', 'Jam selesai harus setelah jam mulai.');
        }
        if (! (new DokterModel())->find((int) $this->request->getPost('id_dokter'))) {
            return redirect()->back()->withInput()->with('error', 'Dokter yang dipilih tidak ditemukan.');
        }
        $model = new JadwalDokterModel();
        $id = (int) $this->request->getPost('id_jadwal');
        if ($id && ! $model->find($id)) {
            return redirect()->to('/admin/jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }
        $data = [
            'id_dokter'   => (int) $this->request->getPost('id_dokter'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'jam_mulai'   => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'kuota'       => (int) $this->request->getPost('kuota'),
        ];
        $id ? $model->update($id, $data) : $model->insert($data);
        return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil disimpan.');
    }

    public function jadwalHapus(int $id)
    {
        if ((new PendaftaranModel())->where('id_jadwal', $id)->first()) {
            return redirect()->to('/admin/jadwal')->with('error', 'Jadwal tidak dapat dihapus karena sudah memiliki pendaftaran.');
        }
        (new JadwalDokterModel())->delete($id);
        return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus.');
    }

    // ---------- Pasien & BPJS ----------
    public function pasien()
    {
        $db = Database::connect();
        $rows = $db->table('pasien ps')
            ->select('ps.*, u.nama, u.email')
            ->join('users u', 'u.id_user = ps.id_user')
            ->orderBy('ps.created_at', 'DESC')->get()->getResultArray();
        return view('admin/pasien', ['pasien' => $rows]);
    }

    public function verifikasiBpjs(int $id)
    {
        $status = (string) $this->request->getPost('status_bpjs');
        if (! in_array($status, ['menunggu', 'terverifikasi', 'ditolak'], true)) {
            return redirect()->to('/admin/pasien')->with('error', 'Status BPJS tidak valid.');
        }
        $pasien = (new PasienModel())->find($id);
        if (! $pasien || $pasien['jenis_pasien'] !== 'bpjs') {
            return redirect()->to('/admin/pasien')->with('error', 'Hanya pasien jalur BPJS yang dapat diverifikasi.');
        }
        (new PasienModel())->update($id, [
            'status_bpjs'  => $status,
            'catatan_bpjs' => $this->request->getPost('catatan_bpjs') ?: null,
        ]);
        return redirect()->to('/admin/pasien')->with('success', 'Status BPJS berhasil diperbarui.');
    }

    // ---------- Pendaftaran ----------
    public function pendaftaran()
    {
        $db = Database::connect();
        $rows = $db->table('pendaftaran pd')
            ->select('pd.*, ps.no_rm, u.nama AS nama_pasien, j.tanggal, d.nama_dokter')
            ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->orderBy('pd.tanggal_daftar', 'DESC')->get()->getResultArray();
        return view('admin/pendaftaran', ['pendaftaran' => $rows]);
    }

    public function ubahStatusPendaftaran(int $id)
    {
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'], true)) {
            return redirect()->to('/admin/pendaftaran')->with('error', 'Status pendaftaran tidak valid.');
        }
        $model = new PendaftaranModel();
        $row   = $model->find($id);
        if (! $row) {
            return redirect()->to('/admin/pendaftaran')->with('error', 'Pendaftaran tidak ditemukan.');
        }
        // v2: v1 mengizinkan transisi status apa pun, termasuk menghidupkan
        // kembali pendaftaran yang sudah selesai/dibatalkan. Sekarang hanya
        // transisi yang masuk akal yang diizinkan; status selesai dan
        // dibatalkan bersifat terminal.
        $diizinkan = [
            'menunggu'    => ['dikonfirmasi', 'dibatalkan'],
            'dikonfirmasi' => ['selesai', 'dibatalkan'],
            'selesai'     => [],
            'dibatalkan'  => [],
        ];
        if ($status !== $row['status'] && ! in_array($status, $diizinkan[$row['status']] ?? [], true)) {
            return redirect()->to('/admin/pendaftaran')
                ->with('error', 'Transisi status dari ' . $row['status'] . ' ke ' . $status . ' tidak diizinkan.');
        }
        $model->update($id, ['status' => $status]);
        return redirect()->to('/admin/pendaftaran')->with('success', 'Status pendaftaran berhasil diubah.');
    }

    /**
     * Check-in eksplisit admisi (FR-A01).
     * Keputusan desain v2: check-in HANYA pada hari praktik (tanggal jadwal
     * sama dengan hari ini) dan hanya dari status menunggu. Alasannya:
     * check-in berarti pasien hadir pada hari itu; mengonfirmasi jauh-jauh
     * hari akan mengaburkan antrean hari-H. Bila admisi perlu mengoreksi
     * status di luar hari praktik, gunakan ubah status manual di kolom yang
     * sama (yang tetap dijaga transisinya, tetapi tanpa syarat hari).
     */
    public function checkIn(int $id)
    {
        $model = new PendaftaranModel();
        $row   = $model->find($id);
        if (! $row) {
            return redirect()->to('/admin/pendaftaran')->with('error', 'Pendaftaran tidak ditemukan.');
        }
        if ($row['status'] !== 'menunggu') {
            return redirect()->to('/admin/pendaftaran')
                ->with('error', 'Check-in hanya dapat dilakukan untuk pendaftaran berstatus menunggu.');
        }
        $jadwal = (new JadwalDokterModel())->find((int) $row['id_jadwal']);
        if (! $jadwal || $jadwal['tanggal'] !== date('Y-m-d')) {
            return redirect()->to('/admin/pendaftaran')
                ->with('error', 'Check-in hanya dapat dilakukan pada hari praktik (tanggal jadwal hari ini).');
        }
        $model->update($id, ['status' => 'dikonfirmasi']);
        return redirect()->to('/admin/pendaftaran')
            ->with('success', 'Check-in berhasil. Pendaftaran antrean ' . $row['no_antrean'] . ' kini dikonfirmasi.');
    }

    // ---------- Rekap ----------
    public function rekap()
    {
        $db = Database::connect();
        $perStatus = $db->table('pendaftaran')
            ->select('status, COUNT(*) AS jumlah')
            ->groupBy('status')->get()->getResultArray();
        $perPoli = $db->table('pendaftaran pd')
            ->select('p.nama_poli, COUNT(*) AS jumlah')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->where('pd.status !=', 'dibatalkan')
            ->groupBy('p.nama_poli')->orderBy('jumlah', 'DESC')
            ->get()->getResultArray();
        $bpjsMenunggu = (new PasienModel())
            ->where('jenis_pasien', 'bpjs')->where('status_bpjs', 'menunggu')->countAllResults();
        return view('admin/rekap', [
            'per_status'    => $perStatus,
            'per_poli'      => $perPoli,
            'bpjs_menunggu' => $bpjsMenunggu,
            'total_aktif'   => (new PendaftaranModel())->where('status !=', 'dibatalkan')->countAllResults(),
        ]);
    }
}
