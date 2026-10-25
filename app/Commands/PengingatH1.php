<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use Config\Database;

/**
 * Pengingat H-1 (FR-P07) versi tanpa email/SMS.
 *
 * Menampilkan daftar pendaftaran yang jadwal praktiknya BESOK (berdasarkan
 * tanggal jadwal, bukan tanggal daftar) dengan status menunggu/dikonfirmasi.
 * Jalankan: php spark pengingat:h-1
 * Untuk pengiriman nyata (email/SMS/WA) di luar lingkup UTS ini; daftar ini
 * dapat dijadwalkan (cron) dan diteruskan ke kanal pengiriman oleh admisi.
 */
class PengingatH1 extends BaseCommand
{
    protected $group       = 'Pendaftaran';
    protected $name        = 'pengingat:h-1';
    protected $description = 'Menampilkan daftar pendaftaran dengan jadwal praktik besok (pengingat H-1).';
    protected $usage       = 'pengingat:h-1';

    public function run(array $params)
    {
        $besok = date('Y-m-d', strtotime('+1 day'));
        $db    = Database::connect();
        $rows  = $db->table('pendaftaran pd')
            ->select('pd.no_antrean, pd.status, j.tanggal, j.jam_mulai, d.nama_dokter, p.nama_poli, u.nama AS nama_pasien, ps.no_rm')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('dokter d', 'd.id_dokter = j.id_dokter')
            ->join('poli p', 'p.id_poli = d.id_poli')
            ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
            ->join('users u', 'u.id_user = ps.id_user')
            ->where('j.tanggal', $besok)
            ->whereIn('pd.status', ['menunggu', 'dikonfirmasi'])
            ->orderBy('j.jam_mulai', 'ASC')
            ->orderBy('pd.no_antrean', 'ASC')
            ->get()->getResultArray();

        if (empty($rows)) {
            $this->show('Tidak ada pendaftaran untuk besok (' . $besok . ').');
            return;
        }
        $this->show('Pengingat H-1 — jadwal praktik besok (' . $besok . '): ' . count($rows) . ' pendaftaran.');
        foreach ($rows as $r) {
            $this->show('- Antrean ' . $r['no_antrean'] . ' | ' . $r['nama_pasien'] . ' (' . $r['no_rm'] . ') | '
                . $r['nama_dokter'] . ' / ' . $r['nama_poli'] . ' | ' . $r['tanggal'] . ' ' . $r['jam_mulai']
                . ' | status: ' . $r['status']);
        }
    }

    private function show(string $text): void
    {
        \CodeIgniter\CLI\CLI::write($text);
    }
}
