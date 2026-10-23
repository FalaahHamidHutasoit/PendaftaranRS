<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservasiModel extends Model
{
    protected $table            = 'reservasi';
    protected $primaryKey       = 'id_reservasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_pasien',
        'id_jadwal',
        'jenis_kunjungan',
        'no_antrean',
        'no_rujukan',
        'faskes_perujuk',
        'keluhan_awal',
        'status'
    ];
}