<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model tabel pendukung audit_log. Tabel ini BUKAN entitas ERD inti
 * (bukan Pasien/Dokter/Poli/Jadwal/Pendaftaran/Rekam Medis); ia hanya
 * mencatat siapa mengakses rekam medis, kapan, dan untuk pendaftaran apa.
 */
class AuditLogModel extends Model
{
    protected $table            = 'audit_log';
    protected $primaryKey       = 'id_audit_log';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_user', 'aksi', 'id_pendaftaran', 'keterangan'];
    protected $useTimestamps    = false;
}
