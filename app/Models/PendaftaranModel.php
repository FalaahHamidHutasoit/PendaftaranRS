<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id_pendaftaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_pasien', 'id_jadwal', 'jenis_kunjungan', 'no_antrean', 'kode_antrean', 'kode_booking', 'no_rujukan', 'faskes_perujuk', 'keluhan_awal', 'status', 'waktu_checkin'];
    protected $useTimestamps    = false;
}
