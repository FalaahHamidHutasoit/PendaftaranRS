<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * v7: Jejak koreksi rekam medis. Satu baris per field yang diubah
 * (bukan satu baris per edit), supaya nilai lama vs baru tiap field
 * tetap terbaca. Rekam medis tidak pernah dihapus; koreksi hanya
 * menambah baris di sini + mencatat ke audit_log.
 */
class RekamMedisRevisiModel extends Model
{
    protected $table            = 'rekam_medis_revisi';
    protected $primaryKey       = 'id_revisi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_rekam_medis', 'field', 'nilai_lama', 'nilai_baru', 'alasan', 'id_user'];
    protected $useTimestamps    = false;
}
