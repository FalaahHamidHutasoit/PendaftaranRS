<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalDokterModel extends Model
{
    protected $table            = 'jadwal_dokter';
    protected $primaryKey       = 'id_jadwal';
    protected $allowedFields    = [
        'id_dokter',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'kuota'
    ];
    protected $useTimestamps    = false;
}