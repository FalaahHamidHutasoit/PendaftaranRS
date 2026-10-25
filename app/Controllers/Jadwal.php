<?php

namespace App\Controllers;

use App\Models\JadwalDokterModel;
use App\Models\PendaftaranModel;

class Jadwal extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        // v2: v1 menembak satu query hitung per jadwal (N+1). Sekarang satu
        // query saja dengan subquery terisi per jadwal.
        $rows = $db->table('jadwal_dokter j')
            ->select('j.*, d.nama_dokter, d.spesialisasi, p.nama_poli')
            ->select('(SELECT COUNT(*) FROM pendaftaran pd WHERE pd.id_jadwal = j.id_jadwal AND pd.status != \'dibatalkan\') AS terisi', false)
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->where('j.tanggal >=', date('Y-m-d'))
            ->orderBy('j.tanggal', 'ASC')
            ->orderBy('j.jam_mulai', 'ASC')
            ->get()->getResultArray();
        foreach ($rows as &$row) {
            $row['sisa_kuota'] = max(0, (int) $row['kuota'] - (int) $row['terisi']);
        }
        unset($row);
        return view('jadwal/index', ['jadwal' => $rows]);
    }

    public function sisaKuota(int $idJadwal): int
    {
        $jadwal = (new JadwalDokterModel())->find($idJadwal);
        if (! $jadwal) {
            return 0;
        }
        $terisi = (new PendaftaranModel())
            ->where('id_jadwal', $idJadwal)
            ->where('status !=', 'dibatalkan')
            ->countAllResults();
        return max(0, (int) $jadwal['kuota'] - (int) $terisi);
    }
}
