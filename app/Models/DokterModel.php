<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table            = 'dokter';
    protected $primaryKey       = 'id_dokter';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_poli', 'id_user', 'nama_dokter', 'spesialisasi'];
    protected $useTimestamps    = false;
}
