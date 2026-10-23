<?php

namespace App\Controllers;

use App\Models\DokterModel;
use App\Models\JadwalDokterModel;
use App\Models\PoliModel;

/**
 * Pengelolaan data master (poli, dokter, jadwal) dan reservasi oleh admin.
 * Semua route dilindungi filter auth:admin (lihat Config/Routes.php).
 */
class Admin extends BaseController
{
    // =====================================================================
    // POLI
    // =====================================================================
    public function poliForm($id = null)
    {
        $nilai = [];
        if ($id !== null) {
            $nilai = (new PoliModel())->find($id);
            if (!$nilai) {
                return $this->gagal('poli', 'Data poli tidak ditemukan.');
            }
        }

        return $this->formView('Poli', 'poli', $id, [
            ['name' => 'nama_poli', 'label' => 'Nama Poli', 'type' => 'text', 'required' => true, 'maxlength' => 100],
            ['name' => 'deskripsi', 'label' => 'Deskripsi Pelayanan', 'type' => 'textarea', 'maxlength' => 255],
        ], $nilai);
    }

    public function poliSimpan($id = null)
    {
        $aturan = [
            'nama_poli' => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'permit_empty|max_length[255]',
        ];
        if (!$this->validate($aturan)) {
            return $this->kembaliError();
        }

        $model = new PoliModel();
        $nama  = trim($this->request->getPost('nama_poli'));

        $dobel = $model->where('nama_poli', $nama);
        if ($id !== null) {
            $dobel->where('id_poli !=', $id);
        }
        if ($dobel->countAllResults() > 0) {
            return $this->kembaliError(['Nama poli sudah ada.']);
        }

        $data = [
            'nama_poli' => $nama,
            'deskripsi' => trim((string) $this->request->getPost('deskripsi')) ?: null,
        ];
        $id === null ? $model->insert($data) : $model->update($id, $data);

        return $this->sukses('poli', 'Data poli berhasil disimpan.');
    }

    public function poliHapus($id)
    {
        $db = \Config\Database::connect();
        if ($db->table('dokter')->where('id_poli', $id)->countAllResults() > 0) {
            return $this->gagal('poli', 'Poli tidak bisa dihapus karena masih memiliki dokter.');
        }
        (new PoliModel())->delete($id);

        return $this->sukses('poli', 'Data poli dihapus.');
    }

    // =====================================================================
    // DOKTER
    // =====================================================================
    public function dokterForm($id = null)
    {
        $nilai = [];
        if ($id !== null) {
            $nilai = (new DokterModel())->find($id);
            if (!$nilai) {
                return $this->gagal('dokter', 'Data dokter tidak ditemukan.');
            }
        }

        $opsiPoli = [];
        foreach ((new PoliModel())->orderBy('nama_poli')->findAll() as $p) {
            $opsiPoli[$p['id_poli']] = $p['nama_poli'];
        }

        return $this->formView('Dokter', 'dokter', $id, [
            ['name' => 'nama_dokter', 'label' => 'Nama Dokter', 'type' => 'text', 'required' => true, 'maxlength' => 100],
            ['name' => 'spesialisasi', 'label' => 'Spesialisasi', 'type' => 'text', 'required' => true, 'maxlength' => 100],
            ['name' => 'id_poli', 'label' => 'Poli Praktik', 'type' => 'select', 'required' => true, 'options' => $opsiPoli],
        ], $nilai);
    }

    public function dokterSimpan($id = null)
    {
        $aturan = [
            'nama_dokter'  => 'required|min_length[3]|max_length[100]',
            'spesialisasi' => 'required|max_length[100]',
            'id_poli'      => 'required|is_natural_no_zero|is_not_unique[poli.id_poli]',
        ];
        if (!$this->validate($aturan)) {
            return $this->kembaliError();
        }

        $data = [
            'nama_dokter'  => trim($this->request->getPost('nama_dokter')),
            'spesialisasi' => trim($this->request->getPost('spesialisasi')),
            'id_poli'      => (int) $this->request->getPost('id_poli'),
        ];

        $model = new DokterModel();
        $id === null ? $model->insert($data) : $model->update($id, $data);

        return $this->sukses('dokter', 'Data dokter berhasil disimpan.');
    }

    public function dokterHapus($id)
    {
        $db = \Config\Database::connect();
        if ($db->table('jadwal_dokter')->where('id_dokter', $id)->countAllResults() > 0) {
            return $this->gagal('dokter', 'Dokter tidak bisa dihapus karena masih memiliki jadwal praktik.');
        }
        (new DokterModel())->delete($id);

        return $this->sukses('dokter', 'Data dokter dihapus.');
    }

    // =====================================================================
    // JADWAL
    // =====================================================================
    public function jadwalForm($id = null)
    {
        $nilai = [];
        if ($id !== null) {
            $nilai = (new JadwalDokterModel())->find($id);
            if (!$nilai) {
                return $this->gagal('jadwal', 'Jadwal tidak ditemukan.');
            }
            $nilai['jam_mulai']   = substr($nilai['jam_mulai'], 0, 5);
            $nilai['jam_selesai'] = substr($nilai['jam_selesai'], 0, 5);
        }

        $opsiDokter = [];
        $rows = \Config\Database::connect()->table('dokter')
            ->select('dokter.id_dokter, dokter.nama_dokter, poli.nama_poli')
            ->join('poli', 'poli.id_poli = dokter.id_poli')
            ->orderBy('dokter.nama_dokter')
            ->get()->getResultArray();
        foreach ($rows as $r) {
            $opsiDokter[$r['id_dokter']] = $r['nama_dokter'] . ' — ' . $r['nama_poli'];
        }

        return $this->formView('Jadwal Dokter', 'jadwal', $id, [
            ['name' => 'id_dokter', 'label' => 'Dokter', 'type' => 'select', 'required' => true, 'options' => $opsiDokter],
            ['name' => 'tanggal', 'label' => 'Tanggal Praktik', 'type' => 'date', 'required' => true],
            ['name' => 'jam_mulai', 'label' => 'Jam Mulai', 'type' => 'time', 'required' => true],
            ['name' => 'jam_selesai', 'label' => 'Jam Selesai', 'type' => 'time', 'required' => true],
            ['name' => 'kuota', 'label' => 'Kuota Pasien', 'type' => 'number', 'required' => true, 'min' => 1, 'max' => 500],
        ], $nilai);
    }

    public function jadwalSimpan($id = null)
    {
        $aturan = [
            'id_dokter'   => 'required|is_natural_no_zero|is_not_unique[dokter.id_dokter]',
            'tanggal'     => 'required|valid_date[Y-m-d]',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'kuota'       => 'required|is_natural_no_zero|less_than_equal_to[500]',
        ];
        if (!$this->validate($aturan)) {
            return $this->kembaliError();
        }

        $idDokter = (int) $this->request->getPost('id_dokter');
        $tanggal  = $this->request->getPost('tanggal');
        $mulai    = $this->request->getPost('jam_mulai');
        $selesai  = $this->request->getPost('jam_selesai');
        $kuota    = (int) $this->request->getPost('kuota');

        $polaJam = '/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/';
        if (!preg_match($polaJam, $mulai) || !preg_match($polaJam, $selesai)) {
            return $this->kembaliError(['Format jam tidak valid.']);
        }
        $mulai   = substr($mulai, 0, 5) . ':00';
        $selesai = substr($selesai, 0, 5) . ':00';

        if ($selesai <= $mulai) {
            return $this->kembaliError(['Jam selesai harus lebih besar dari jam mulai.']);
        }
        if ($id === null && $tanggal < date('Y-m-d')) {
            return $this->kembaliError(['Tanggal praktik tidak boleh di masa lalu.']);
        }

        $db = \Config\Database::connect();

        // Jadwal dokter yang sama tidak boleh bertabrakan pada tanggal yang sama.
        $bentrok = $db->table('jadwal_dokter')
            ->where('id_dokter', $idDokter)
            ->where('tanggal', $tanggal)
            ->where('jam_mulai <', $selesai)
            ->where('jam_selesai >', $mulai);
        if ($id !== null) {
            $bentrok->where('id_jadwal !=', $id);
        }
        if ($bentrok->countAllResults() > 0) {
            return $this->kembaliError(['Jadwal bentrok dengan jadwal lain milik dokter ini pada tanggal tersebut.']);
        }

        // Kuota tidak boleh lebih kecil dari jumlah reservasi aktif.
        if ($id !== null) {
            $terisi = $db->table('reservasi')
                ->where('id_jadwal', $id)
                ->where('status !=', 'dibatalkan')
                ->countAllResults();
            if ($kuota < $terisi) {
                return $this->kembaliError(["Kuota tidak boleh kurang dari reservasi aktif yang sudah ada ({$terisi})."]);
            }
        }

        $data = [
            'id_dokter'   => $idDokter,
            'tanggal'     => $tanggal,
            'jam_mulai'   => $mulai,
            'jam_selesai' => $selesai,
            'kuota'       => $kuota,
        ];
        $model = new JadwalDokterModel();
        $id === null ? $model->insert($data) : $model->update($id, $data);

        return $this->sukses('jadwal', 'Jadwal dokter berhasil disimpan.');
    }

    public function jadwalHapus($id)
    {
        $db = \Config\Database::connect();
        if ($db->table('reservasi')->where('id_jadwal', $id)->countAllResults() > 0) {
            return $this->gagal('jadwal', 'Jadwal tidak bisa dihapus karena sudah memiliki reservasi. Ubah kuota atau batalkan reservasinya.');
        }
        (new JadwalDokterModel())->delete($id);

        return $this->sukses('jadwal', 'Jadwal dokter dihapus.');
    }

    // =====================================================================
    // RESERVASI
    // =====================================================================
    public function reservasi()
    {
        $tanggal = (string) $this->request->getGet('tanggal');
        $status  = (string) $this->request->getGet('status');

        $builder = \Config\Database::connect()->table('reservasi')
            ->select('reservasi.*, users.nama AS nama_pasien, pasien.no_rm, pasien.jenis_pasien, pasien.no_bpjs, pasien.status_bpjs,
                      jadwal_dokter.tanggal, jadwal_dokter.jam_mulai, jadwal_dokter.jam_selesai,
                      dokter.nama_dokter, poli.nama_poli')
            ->join('pasien', 'pasien.id_pasien = reservasi.id_pasien')
            ->join('users', 'users.id_user = pasien.id_user')
            ->join('jadwal_dokter', 'jadwal_dokter.id_jadwal = reservasi.id_jadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal_dokter.id_dokter')
            ->join('poli', 'poli.id_poli = dokter.id_poli');

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $builder->where('jadwal_dokter.tanggal', $tanggal);
        } else {
            $tanggal = '';
        }
        if (in_array($status, self::STATUS, true)) {
            $builder->where('reservasi.status', $status);
        } else {
            $status = '';
        }

        $data = [
            'reservasi' => $builder
                ->orderBy('jadwal_dokter.tanggal', 'DESC')
                ->orderBy('jadwal_dokter.jam_mulai', 'ASC')
                ->orderBy('reservasi.no_antrean', 'ASC')
                ->get()->getResultArray(),
            'fTanggal'  => $tanggal,
            'fStatus'   => $status,
            'active'    => 'reservasi',
        ];

        return view('admin/reservasi', $data);
    }

    // =====================================================================
    // PASIEN & VERIFIKASI BPJS
    // =====================================================================
    private const STATUS_BPJS = ['menunggu', 'terverifikasi', 'ditolak', 'tidak_berlaku'];

    public function pasien()
    {
        $jenis  = (string) $this->request->getGet('jenis');
        $status = (string) $this->request->getGet('status_bpjs');
        $cari   = trim((string) $this->request->getGet('q'));

        $builder = \Config\Database::connect()->table('pasien')
            ->select('pasien.*, users.nama, users.email')
            ->join('users', 'users.id_user = pasien.id_user');

        if (in_array($jenis, ['umum', 'bpjs'], true)) {
            $builder->where('pasien.jenis_pasien', $jenis);
        } else {
            $jenis = '';
        }
        if (in_array($status, self::STATUS_BPJS, true)) {
            $builder->where('pasien.status_bpjs', $status);
        } else {
            $status = '';
        }
        if ($cari !== '') {
            $builder->groupStart()
                ->like('users.nama', $cari)
                ->orLike('pasien.no_rm', $cari)
                ->orLike('pasien.nik', $cari)
                ->orLike('pasien.no_bpjs', $cari)
                ->groupEnd();
        }

        return view('admin/pasien', [
            'pasien'  => $builder->orderBy('pasien.id_pasien', 'DESC')->get()->getResultArray(),
            'fJenis'  => $jenis,
            'fStatus' => $status,
            'fCari'   => $cari,
            'active'  => 'pasien',
        ]);
    }

    public function pasienBpjs($id)
    {
        $keputusan = (string) $this->request->getPost('keputusan');
        $catatan   = trim((string) $this->request->getPost('catatan'));
        $db        = \Config\Database::connect();

        $row = $db->table('pasien')->where('id_pasien', $id)->get()->getRowArray();
        if (!$row || $row['jenis_pasien'] !== 'bpjs') {
            return $this->gagal('admin/pasien', 'Pasien BPJS tidak ditemukan.');
        }
        if (!in_array($keputusan, ['terverifikasi', 'ditolak'], true)) {
            return $this->gagal('admin/pasien', 'Keputusan verifikasi tidak valid.');
        }
        if ($keputusan === 'ditolak' && ($catatan === '' || mb_strlen($catatan) > 255)) {
            return $this->gagal('admin/pasien', 'Alasan penolakan wajib diisi (maks. 255 karakter).');
        }

        $db->table('pasien')->where('id_pasien', $id)->update([
            'status_bpjs'  => $keputusan,
            'catatan_bpjs' => $keputusan === 'ditolak' ? $catatan : null,
        ]);

        return $this->sukses('admin/pasien', 'Status BPJS pasien diubah menjadi ' . $keputusan . '.');
    }

    private const STATUS = ['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'];

    /** Alur status yang diizinkan. */
    private const ALUR = [
        'menunggu'     => ['dikonfirmasi', 'dibatalkan'],
        'dikonfirmasi' => ['selesai', 'dibatalkan'],
        'selesai'      => [],
        'dibatalkan'   => [],
    ];

    public function reservasiStatus($id)
    {
        $baru = (string) $this->request->getPost('status');
        $db   = \Config\Database::connect();

        $row = $db->table('reservasi')->where('id_reservasi', $id)->get()->getRowArray();
        if (!$row) {
            return $this->gagal('admin/reservasi', 'Reservasi tidak ditemukan.');
        }
        if ($baru === 'dikonfirmasi') {
            $p = $db->table('pasien')->where('id_pasien', $row['id_pasien'])->get()->getRowArray();
            if ($p && $p['jenis_pasien'] === 'bpjs' && $p['status_bpjs'] !== 'terverifikasi') {
                return $this->gagal('admin/reservasi', 'Reservasi pasien BPJS baru bisa dikonfirmasi setelah BPJS diverifikasi (menu Data Pasien).');
            }
        }
        if (!in_array($baru, self::ALUR[$row['status']] ?? [], true)) {
            return $this->gagal('admin/reservasi', "Status tidak bisa diubah dari {$row['status']} ke {$baru}.");
        }

        $db->table('reservasi')->where('id_reservasi', $id)->update(['status' => $baru]);

        return $this->sukses('admin/reservasi', "Status reservasi diubah menjadi {$baru}.");
    }

    // =====================================================================
    // Helper
    // =====================================================================
    private function formView(string $judul, string $segmen, $id, array $fields, array $nilai)
    {
        return view('admin/form', [
            'judul'  => $judul,
            'action' => base_url('admin/' . $segmen . '/simpan' . ($id !== null ? '/' . $id : '')),
            'back'   => base_url($segmen),
            'fields' => $fields,
            'nilai'  => $nilai,
            'edit'   => $id !== null,
            'active' => $segmen,
        ]);
    }

    private function kembaliError(?array $errors = null)
    {
        return redirect()->back()->withInput()
            ->with('errors', $errors ?? $this->validator->getErrors());
    }

    private function sukses(string $tujuan, string $pesan)
    {
        return redirect()->to(base_url($tujuan))->with('pesan_sukses', $pesan);
    }

    private function gagal(string $tujuan, string $pesan)
    {
        return redirect()->to(base_url($tujuan))->with('pesan_error', $pesan);
    }
}
