<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Data contoh generik dan jelas dummy, hanya untuk demo akademik.
        // Ganti kata sandi demo segera setelah login pertama.
        $this->db->table('users')->insert([
            'nama' => 'Administrator Demo', 'email' => 'admin@demo.local',
            'password' => password_hash('AdminDemo123', PASSWORD_DEFAULT), 'role' => 'admin',
        ]);
        $this->db->table('users')->insert([
            'nama' => 'Pasien Contoh', 'email' => 'pasien@demo.local',
            'password' => password_hash('PasienDemo123', PASSWORD_DEFAULT), 'role' => 'pasien',
        ]);
        $idPasienUser = (int) $this->db->insertID();
        $this->db->table('users')->insert([
            'nama' => 'Dokter Contoh', 'email' => 'dokter@demo.local',
            'password' => password_hash('DokterDemo123', PASSWORD_DEFAULT), 'role' => 'dokter',
        ]);
        $idDokterUser = (int) $this->db->insertID();

        $this->db->table('poli')->insert(['nama_poli' => 'Poli Umum', 'deskripsi' => 'Layanan pemeriksaan umum.', 'kode_antrean' => 'U']);
        $idPoliUmum = (int) $this->db->insertID();
        $this->db->table('poli')->insert(['nama_poli' => 'Poli Gigi', 'deskripsi' => 'Layanan pemeriksaan gigi.', 'kode_antrean' => 'G']);

        $this->db->table('pasien')->insert([
            'id_user' => $idPasienUser, 'no_rm' => 'RMDEMO0001', 'nik' => '1000000000000001',
            'tanggal_lahir' => '1995-05-05', 'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Simulasi No. 1, Jakarta', 'jenis_pasien' => 'umum',
            'no_bpjs' => null, 'status_bpjs' => 'tidak_berlaku',
            'no_hp' => '081200000001', 'golongan_darah' => 'O+', 'alergi' => null,
        ]);

        $this->db->table('dokter')->insert([
            'id_poli' => $idPoliUmum, 'id_user' => $idDokterUser,
            'nama_dokter' => 'Dokter Contoh', 'spesialisasi' => 'Dokter Umum',
        ]);
        $idDokter = (int) $this->db->insertID();

        // Jadwal hari ini (untuk demo check-in hari-H) + 3 hari ke depan.
        // Jadwal selalu relatif terhadap tanggal seed dijalankan.
        foreach ([0, 1, 2, 3] as $plusHari) {
            $this->db->table('jadwal_dokter')->insert([
                'id_dokter'   => $idDokter,
                'tanggal'     => date('Y-m-d', strtotime("+{$plusHari} days")),
                'jam_mulai'   => $plusHari % 2 === 0 ? '13:00:00' : '08:00:00',
                'jam_selesai' => $plusHari % 2 === 0 ? '16:00:00' : '12:00:00',
                'kuota'       => $plusHari % 2 === 0 ? 15 : 20,
            ]);
        }
    }
}
