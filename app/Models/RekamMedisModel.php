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
    protected $allowedFields    = ['id_pasien', 'id_pendaftaran', 'id_dokter', 'tanggal_periksa', 'keluhan', 'alergi', 'ttv_sistolik', 'ttv_diastolik', 'ttv_nadi', 'ttv_napas', 'ttv_suhu', 'ttv_spo2', 'pemeriksaan_fisik', 'kode_diagnosis', 'diagnosis', 'tindakan', 'resep', 'rencana', 'catatan'];
    protected $useTimestamps    = false;
}
