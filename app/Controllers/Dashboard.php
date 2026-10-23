<?php
namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\PoliModel;
use App\Models\JadwalDokterModel;
use App\Models\ReservasiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $pasienModel = new PasienModel();
        $dokterModel = new DokterModel();
        $poliModel = new PoliModel();
        $jadwalModel = new JadwalDokterModel();
        $reservasiModel = new ReservasiModel();

        $data = [
            'totalPasien' => $pasienModel->countAllResults(),
            'totalDokter' => $dokterModel->countAllResults(),
            'totalPoli' => $poliModel->countAllResults(),
            'totalJadwal' => $jadwalModel->countAllResults(),
            'totalReservasi' => $reservasiModel->countAllResults(),
        ];

        return view('dashboard/index', $data);
    }

    
public function dokter()
{
    $db = \Config\Database::connect();

    $data['dokter'] = $db->table('dokter')
        ->select('dokter.*, poli.nama_poli')
        ->join('poli', 'poli.id_poli = dokter.id_poli')
        ->orderBy('dokter.nama_dokter', 'ASC')
        ->get()
        ->getResultArray();

    return view('dashboard/dokter', $data);
}


public function poli()
{
    $poliModel = new \App\Models\PoliModel();

    $data['poli'] = $poliModel->findAll();

    return view('dashboard/poli', $data);
}

public function jadwal()
{
    $db = \Config\Database::connect();

    $data['jadwal'] = $db->table('jadwal_dokter')
        ->select('
            jadwal_dokter.*,
            dokter.nama_dokter,
            poli.nama_poli
        ')
        ->join(
            'dokter',
            'dokter.id_dokter = jadwal_dokter.id_dokter'
        )
        ->join(
            'poli',
            'poli.id_poli = dokter.id_poli'
        )
        ->orderBy('jadwal_dokter.tanggal', 'ASC')
        ->orderBy('jadwal_dokter.jam_mulai', 'ASC')
        ->get()
        ->getResultArray();

    return view('dashboard/jadwal', $data);
}


}
