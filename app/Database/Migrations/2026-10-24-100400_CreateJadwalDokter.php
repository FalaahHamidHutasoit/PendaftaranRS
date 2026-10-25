<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalDokter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_dokter' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'tanggal' => ['type' => 'DATE'],
            'jam_mulai' => ['type' => 'TIME'],
            'jam_selesai' => ['type' => 'TIME'],
            'kuota' => ['type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => true, 'default' => 20],
        ]);
        $this->forge->addKey('id_jadwal', true);
        $this->forge->addKey(['id_dokter', 'tanggal']);
        $this->forge->addForeignKey('id_dokter', 'dokter', 'id_dokter', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('jadwal_dokter');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_dokter', true);
    }
}
