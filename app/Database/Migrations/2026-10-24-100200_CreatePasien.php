<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePasien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pasien' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_user' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'no_rm' => ['type' => 'VARCHAR', 'constraint' => 20],
            'nik' => ['type' => 'CHAR', 'constraint' => 16],
            'tanggal_lahir' => ['type' => 'DATE'],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
            'alamat' => ['type' => 'VARCHAR', 'constraint' => 255],
            'jenis_pasien' => ['type' => 'ENUM', 'constraint' => ['umum', 'bpjs'], 'default' => 'umum'],
            'no_bpjs' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'status_bpjs' => ['type' => 'ENUM', 'constraint' => ['tidak_berlaku', 'menunggu', 'terverifikasi', 'ditolak'], 'default' => 'tidak_berlaku'],
            'catatan_bpjs' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => 15, 'default' => ''],
            'golongan_darah' => ['type' => 'ENUM', 'constraint' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'tidak_tahu'], 'default' => 'tidak_tahu'],
            'alergi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id_pasien', true);
        $this->forge->addUniqueKey('id_user');
        $this->forge->addUniqueKey('no_rm');
        $this->forge->addUniqueKey('nik');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pasien');
    }

    public function down()
    {
        $this->forge->dropTable('pasien', true);
    }
}
