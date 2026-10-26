<?php

namespace App\Models;

use CodeIgniter\Model;

class PoliModel extends Model
{
    protected $table            = 'poli';
    protected $primaryKey       = 'id_poli';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nama_poli', 'deskripsi', 'kode_antrean'];
    protected $useTimestamps    = false;
}
