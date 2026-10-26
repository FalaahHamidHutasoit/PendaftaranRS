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
            // v7: 1 huruf untuk kode antrean (U = Poli Umum, G = Poli Gigi).
            'kode_antrean' => ['type' => 'VARCHAR', 'constraint' => 1, 'null' => true],
        ]);
        $this->forge->addKey('id_poli', true);
        $this->forge->addUniqueKey('nama_poli');
        $this->forge->addUniqueKey('kode_antrean');
        $this->forge->createTable('poli');
    }

    public function down()
    {
        $this->forge->dropTable('poli', true);
    }
}
