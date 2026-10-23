<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table            = 'dokter';
    protected $primaryKey       = 'id_dokter';
    protected $allowedFields    = [
        'id_poli',
        'nama_dokter',
        'spesialisasi'
    ];
    protected $useTimestamps    = false;
}