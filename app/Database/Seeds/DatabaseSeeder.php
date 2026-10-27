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
        $idAdminUser = (int) $this->db->insertID();
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
        $idPasien = (int) $this->db->insertID();

        $this->db->table('dokter')->insert([
            'id_poli' => $idPoliUmum, 'id_user' => $idDokterUser,
            'nama_dokter' => 'Dokter Contoh', 'spesialisasi' => 'Dokter Umum',
        ]);
        $idDokter = (int) $this->db->insertID();

        // Jadwal hari ini (untuk demo check-in hari-H) + 3 hari ke depan.
        // Jadwal selalu relatif terhadap tanggal seed dijalankan.
        $idJadwalHariIni = 0;
        foreach ([0, 1, 2, 3] as $plusHari) {
            $this->db->table('jadwal_dokter')->insert([
                'id_dokter'   => $idDokter,
                'tanggal'     => date('Y-m-d', strtotime("+{$plusHari} days")),
                'jam_mulai'   => $plusHari % 2 === 0 ? '13:00:00' : '08:00:00',
                'jam_selesai' => $plusHari % 2 === 0 ? '16:00:00' : '12:00:00',
                'kuota'       => $plusHari % 2 === 0 ? 15 : 20,
            ]);
            if ($plusHari === 0) {
                $idJadwalHariIni = (int) $this->db->insertID();
            }
        }

        // v8: data demo alur lengkap (P0.2 — dosen bisa demo tanpa membuat
        // dari nol). Semua data generik/dummy. Jadwal lampau hanya untuk
        // contoh booking selesai + rekam medis; booking lewat UI tetap
        // menolak jadwal lampau, sesuai aturan aplikasi.
        $this->db->table('jadwal_dokter')->insert([
            'id_dokter' => $idDokter, 'tanggal' => date('Y-m-d', strtotime('-1 day')),
            'jam_mulai' => '08:00:00', 'jam_selesai' => '12:00:00', 'kuota' => 20,
        ]);
        $idJadwalLampau = (int) $this->db->insertID();

        $this->db->table('pendaftaran')->insert([
            'id_pasien' => $idPasien, 'id_jadwal' => $idJadwalHariIni, 'jenis_kunjungan' => 'baru',
            'no_antrean' => 1, 'kode_antrean' => 'U001', 'kode_booking' => 'AB23CD45',
            'keluhan_awal' => 'Demam dan batuk ringan (data demo).', 'status' => 'menunggu',
        ]);
        $idBookingAktif = (int) $this->db->insertID();

        $this->db->table('pendaftaran')->insert([
            'id_pasien' => $idPasien, 'id_jadwal' => $idJadwalLampau, 'jenis_kunjungan' => 'kontrol',
            'no_antrean' => 1, 'kode_antrean' => 'U001', 'kode_booking' => 'CD45EF67',
            'keluhan_awal' => 'Kontrol pilek (data demo).', 'status' => 'selesai',
        ]);
        $idBookingSelesai = (int) $this->db->insertID();

        $this->db->table('rekam_medis')->insert([
            'id_pasien' => $idPasien, 'id_pendaftaran' => $idBookingSelesai, 'id_dokter' => $idDokter,
            'tanggal_periksa' => date('Y-m-d', strtotime('-1 day')),
            'keluhan' => 'Pilek dan hidung tersumbat (data demo).', 'alergi' => null,
            'ttv_sistolik' => 120, 'ttv_diastolik' => 80, 'ttv_nadi' => 72, 'ttv_napas' => 18,
            'ttv_suhu' => 36.8, 'ttv_spo2' => 98,
            'pemeriksaan_fisik' => 'Keadaan umum baik, tenggorokan tidak merah (data demo).',
            'kode_diagnosis' => 'J06', 'diagnosis' => 'Infeksi saluran pernapasan atas akut multipel',
            'tindakan' => 'Pemeriksaan fisik dan edukasi istirahat cukup',
            'resep' => 'Paracetamol — 500 mg — 3x1 — 10 tablet — sesudah makan',
            'rencana' => 'Kontrol bila keluhan memburuk', 'catatan' => null,
        ]);
        $idRm = (int) $this->db->insertID();

        $this->db->table('rekam_medis_revisi')->insert([
            'id_rekam_medis' => $idRm, 'field' => 'kode_diagnosis',
            'nilai_lama' => 'J00', 'nilai_baru' => 'J06',
            'alasan' => 'Koreksi kode diagnosis setelah verifikasi ulang (data demo).',
            'id_user' => $idDokterUser,
        ]);

        $this->db->table('audit_log')->insert([
            'id_user' => $idPasienUser, 'aksi' => 'booking', 'id_pendaftaran' => $idBookingAktif,
            'keterangan' => 'Pasien membuat pendaftaran id ' . $idBookingAktif . '.',
        ]);
        $this->db->table('audit_log')->insert([
            'id_user' => $idAdminUser, 'aksi' => 'checkin', 'id_pendaftaran' => $idBookingSelesai,
            'keterangan' => 'Admisi melakukan check-in pendaftaran id ' . $idBookingSelesai . '.',
        ]);
        $this->db->table('audit_log')->insert([
            'id_user' => $idDokterUser, 'aksi' => 'buat', 'id_pendaftaran' => $idBookingSelesai,
            'keterangan' => 'Dokter membuat rekam medis id ' . $idRm . ' untuk pendaftaran ' . $idBookingSelesai . '.',
        ]);
        $this->db->table('audit_log')->insert([
            'id_user' => $idDokterUser, 'aksi' => 'lihat', 'id_pendaftaran' => $idBookingSelesai,
            'keterangan' => 'Dokter melihat rekam medis id ' . $idRm . '.',
        ]);
        $this->db->table('audit_log')->insert([
            'id_user' => $idDokterUser, 'aksi' => 'ubah', 'id_pendaftaran' => $idBookingSelesai,
            'keterangan' => 'Dokter mengoreksi rekam medis id ' . $idRm . ' (kode_diagnosis). Alasan: Koreksi kode diagnosis setelah verifikasi ulang (data demo).',
        ]);
    }
}
