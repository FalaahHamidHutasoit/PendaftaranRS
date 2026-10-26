<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateRekamMedis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rekam_medis' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_pasien' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'id_pendaftaran' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'id_dokter' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'tanggal_periksa' => ['type' => 'DATE'],
            // v7: formulir SOAP — S (keluhan + alergi), O (TTV numerik +
            // pemeriksaan fisik), A (diagnosis + kode ICD-10), P (tindakan
            // + resep terstruktur + rencana tindak lanjut).
            'keluhan' => ['type' => 'TEXT', 'null' => true],
            'alergi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'ttv_sistolik' => ['type' => 'INT', 'null' => true],
            'ttv_diastolik' => ['type' => 'INT', 'null' => true],
            'ttv_nadi' => ['type' => 'INT', 'null' => true],
            'ttv_napas' => ['type' => 'INT', 'null' => true],
            'ttv_suhu' => ['type' => 'DECIMAL', 'constraint' => '4,1', 'null' => true],
            'ttv_spo2' => ['type' => 'INT', 'null' => true],
            'pemeriksaan_fisik' => ['type' => 'TEXT', 'null' => true],
            'kode_diagnosis' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'diagnosis' => ['type' => 'TEXT'],
            'rencana' => ['type' => 'TEXT', 'null' => true],
            'tindakan' => ['type' => 'TEXT', 'null' => true],
            'resep' => ['type' => 'TEXT', 'null' => true],
            'catatan' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => null],
        ]);
        $this->forge->addKey('id_rekam_medis', true);
        $this->forge->addKey('id_pasien');
        $this->forge->addKey('id_dokter');
        $this->forge->addUniqueKey('id_pendaftaran');
        $this->forge->addForeignKey('id_pasien', 'pasien', 'id_pasien', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('id_pendaftaran', 'pendaftaran', 'id_pendaftaran', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('id_dokter', 'dokter', 'id_dokter', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('rekam_medis');
    }

    public function down()
    {
        $this->forge->dropTable('rekam_medis', true);
    }
}
