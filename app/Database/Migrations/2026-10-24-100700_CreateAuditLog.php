<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

/**
 * Migration aditif v2. TIDAK mengubah 7 tabel inti ERD v1.
 * Tabel pendukung audit_log: jejak akses rekam medis oleh dokter.
 * Sengaja TANPA foreign key ke pendaftaran agar riwayat audit tidak ikut
 * terhapus bila baris pendaftaran dihapus; id_pendaftaran hanya referensi
 * numerik. Foreign key ke users memakai SET NULL agar jejak tetap ada
 * bila akun pengguna dihapus.
 */
class CreateAuditLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_audit_log'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_user'        => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'aksi'           => ['type' => 'VARCHAR', 'constraint' => 50],
            'id_pendaftaran' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'keterangan'     => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id_audit_log', true);
        $this->forge->addKey('id_user');
        $this->forge->addKey('id_pendaftaran');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('audit_log');
    }

    public function down()
    {
        $this->forge->dropTable('audit_log', true);
    }
}
