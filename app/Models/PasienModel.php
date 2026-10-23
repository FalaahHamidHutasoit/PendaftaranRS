<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id_pasien';
    protected $allowedFields    = [
        'id_user',
        'no_rm',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'jenis_pasien',
        'no_bpjs',
        'status_bpjs',
        'catatan_bpjs',
        'no_hp',
        'golongan_darah',
        'alergi'
    ];
    protected $useTimestamps    = false;
}