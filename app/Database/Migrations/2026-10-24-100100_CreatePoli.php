<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePoli extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_poli' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nama_poli' => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id_poli', true);
        $this->forge->addUniqueKey('nama_poli');
        $this->forge->createTable('poli');
    }

    public function down()
    {
        $this->forge->dropTable('poli', true);
    }
}
