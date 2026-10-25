<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dokter' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_poli' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'id_user' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'nama_dokter' => ['type' => 'VARCHAR', 'constraint' => 100],
            'spesialisasi' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id_dokter', true);
        $this->forge->addKey('id_poli');
        $this->forge->addUniqueKey('id_user');
        $this->forge->addForeignKey('id_poli', 'poli', 'id_poli', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('dokter');
    }

    public function down()
    {
        $this->forge->dropTable('dokter', true);
    }
}
