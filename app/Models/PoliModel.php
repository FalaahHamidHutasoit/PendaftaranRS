<?php

namespace App\Models;

use CodeIgniter\Model;

class PoliModel extends Model
{
    protected $table            = 'poli';
    protected $primaryKey       = 'id_poli';
    protected $allowedFields    = [
        'nama_poli',
        'deskripsi'
    ];
    protected $useTimestamps    = false;
}