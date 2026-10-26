<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

/**
 * v7: Jejak koreksi rekam medis. Nilai lama TIDAK pernah dihapus atau
 * ditimpa tanpa jejak: setiap field yang diubah mendapat satu baris di
 * sini (field, nilai lama, nilai baru, alasan wajib, siapa, kapan).
 * Tanpa foreign key CASCADE ke rekam_medis yang akan menghapus jejak
 * bila baris induk terhapus; id_rekam_medis hanya referensi numerik
 * dengan index. id_user memakai SET NULL seperti audit_log.
 */
class CreateRekamMedisRevisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_revisi' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_rekam_medis' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'field' => ['type' => 'VARCHAR', 'constraint' => 50],
            'nilai_lama' => ['type' => 'TEXT', 'null' => true],
            'nilai_baru' => ['type' => 'TEXT', 'null' => true],
            'alasan' => ['type' => 'TEXT'],
            'id_user' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id_revisi', true);
        $this->forge->addKey('id_rekam_medis');
        $this->forge->addKey('id_user');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('rekam_medis_revisi');
    }

    public function down()
    {
        $this->forge->dropTable('rekam_medis_revisi', true);
    }
}
