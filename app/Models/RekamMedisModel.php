<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamMedisModel extends Model
{
    protected $table            = 'rekam_medis';
    protected $primaryKey       = 'id_rekam_medis';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_pasien', 'id_pendaftaran', 'id_dokter', 'tanggal_periksa', 'diagnosis', 'tindakan', 'resep', 'catatan'];
    protected $useTimestamps    = false;
}
