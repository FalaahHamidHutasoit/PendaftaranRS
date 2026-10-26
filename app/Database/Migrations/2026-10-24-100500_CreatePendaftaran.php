<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pendaftaran' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_pasien' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'id_jadwal' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'jenis_kunjungan' => ['type' => 'ENUM', 'constraint' => ['baru', 'kontrol']],
            'no_antrean' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            // v7: kode antrean publik (huruf poli + nomor 3 digit, mis. U012)
            // dan kode booking acak untuk QR/check-in (unik, tidak berurutan).
            'kode_antrean' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'kode_booking' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'waktu_checkin' => ['type' => 'DATETIME', 'null' => true],
            'no_rujukan' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'faskes_perujuk' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'keluhan_awal' => ['type' => 'TEXT'],
            'status' => ['type' => 'ENUM', 'constraint' => ['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'], 'default' => 'menunggu'],
            'tanggal_daftar' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id_pendaftaran', true);
        $this->forge->addKey('id_pasien');
        $this->forge->addUniqueKey(['id_jadwal', 'no_antrean']);
        $this->forge->addUniqueKey('kode_booking');
        $this->forge->addForeignKey('id_pasien', 'pasien', 'id_pasien', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('id_jadwal', 'jadwal_dokter', 'id_jadwal', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('pendaftaran', true);
    }
}
