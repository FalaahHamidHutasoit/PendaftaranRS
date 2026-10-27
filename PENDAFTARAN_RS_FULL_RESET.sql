-- =====================================================================
-- PENDAFTARAN_RS_FULL_RESET.sql - self-contained, gaya KAMELA_FULL_RESET.sql
-- Import SATU file ini saja di phpMyAdmin. File ini membuat databasenya
-- sendiri, lalu DROP + CREATE ulang 9 tabel beserta data demonya.
-- TIDAK perlu membuat database kosong dulu, dan TIDAK perlu menjalankan
-- migrate/seed sesudah impor. DESTRUKTIF: hanya untuk instalasi baru.
-- Isi di bawah header ini identik dengan sim-uts-full-reset-v1.1.
-- =====================================================================
CREATE DATABASE IF NOT EXISTS `pendaftaran_rs` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pendaftaran_rs`;
-- =====================================================================
-- SIM UTS - FULL RESET v1.1 (pola KAMELA_FULL_RESET.sql)
-- Aplikasi Pintar Pendaftaran Pasien, CodeIgniter 4 + MySQL, paket v8
-- v1.1 = v1 + perbaikan: golongan_darah 'O' -> 'O+' (ENUM v1 tidak
-- mengenal 'O' polos; di MariaDB strict, INSERT pasien v1 gagal dan
-- skrip berhenti sebelum dokter/jadwal terisi), UNIQUE no_bpjs,
-- kolom v7 (kode poli/antrean/booking, waktu check-in, kolom SOAP,
-- tabel rekam_medis_revisi), dan data demo alur lengkap.
-- =====================================================================
-- PERINGATAN - FILE INI MENGHAPUS SEMUA DATA LAMA:
--   Import file ini akan DROP semua tabel di bawah dan membuatnya
--   ulang dari nol. Data hasil import sebelumnya (termasuk seluruh
--   pendaftaran lama) akan HILANG. Backup dulu bila data lama masih
--   dibutuhkan: phpMyAdmin -> pilih database -> tab Ekspor.
--
-- CARA PAKAI (phpMyAdmin XAMPP, persis pola KAMELA dulu):
--   1. XAMPP Control Panel: Start Apache dan MySQL.
--   2. phpMyAdmin (http://localhost/phpmyadmin): pilih database
--      tujuan (database yang dipakai aplikasi; bila belum ada, buat
--      dulu database kosong, mis. pendaftaran_rs).
--   3. Tab Impor -> pilih file ini -> Kirim/Go.
--   4. TIDAK PERLU `php spark migrate` dan TIDAK PERLU
--      `php spark db:seed` setelah import ini. Tabel dan data demo
--      sudah dibuat oleh file ini. Menjalankan migrate setelah
--      import justru akan gagal karena tabelnya sudah ada.
--   5. Pastikan file .env di folder proyek menunjuk ke database yang
--      SAMA dengan yang baru saja di-import ini (hostname localhost,
--      username root, password dikosongkan untuk default XAMPP).
--      Ini penyebab gagal login yang paling sering: SQL di-import ke
--      satu database, sedangkan aplikasi membaca database lain.
--   6. Buka aplikasi lewat Apache XAMPP
--      (http://localhost/pendaftaran-rs/public/) atau
--      `php spark serve` (http://localhost:8080/).
--
-- AKUN DEMO (password = nama peran + 123, HANYA untuk demo lokal):
--   Admisi : admin@demo.local  / admin123
--   Pasien : pasien@demo.local / pasien123
--   Dokter : dokter@demo.local / dokter123
--   Ganti password ini bila aplikasi dipakai di luar demo lokal.
--
-- ISI FILE INI:
--   7 tabel inti (users, pasien, poli, dokter, jadwal_dokter,
--   pendaftaran, rekam_medis) + 2 tabel pendukung (audit_log,
--   rekam_medis_revisi), lengkap dengan kolom v7 dan UNIQUE no_bpjs.
--   Data demo generik dan jelas dummy (bukan data dari file acuan
--   mana pun): 3 user, 2 poli, 1 pasien, 1 dokter (sudah tertaut ke
--   akun dokter, jadi dokter langsung bisa login), 4 jadwal
--   (HARI INI, besok, lusa, dan 1 jadwal lampau khusus demo), 1
--   booking AKTIF hari ini (menunggu, U001, kode booking AB23CD45),
--   1 booking SELESAI di jadwal lampau + 1 rekam medis SOAP contoh
--   + 1 baris revisi (koreksi beralasan) + 5 baris audit_log contoh.
--   Tanggal jadwal dihitung dari tanggal import, jadi demo
--   check-in hari-H dan pengingat H-1 selalu relevan. Jadwal lampau
--   hanya ada sebagai data contoh; booking lewat UI tetap menolak
--   jadwal lampau, sesuai aturan aplikasi.
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `rekam_medis_revisi`;
DROP TABLE IF EXISTS `audit_log`;
DROP TABLE IF EXISTS `rekam_medis`;
DROP TABLE IF EXISTS `pendaftaran`;
DROP TABLE IF EXISTS `jadwal_dokter`;
DROP TABLE IF EXISTS `dokter`;
DROP TABLE IF EXISTS `pasien`;
DROP TABLE IF EXISTS `poli`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','pasien','dokter') NOT NULL DEFAULT 'pasien',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `poli` (
  `id_poli` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_poli` VARCHAR(100) NOT NULL,
  `deskripsi` VARCHAR(255) DEFAULT NULL,
  `kode_antrean` VARCHAR(1) DEFAULT NULL,
  PRIMARY KEY (`id_poli`),
  UNIQUE KEY `uq_poli_nama` (`nama_poli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pasien` (
  `id_pasien` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` INT(10) UNSIGNED NOT NULL,
  `no_rm` VARCHAR(20) NOT NULL,
  `nik` CHAR(16) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `jenis_kelamin` ENUM('L','P') NOT NULL,
  `alamat` VARCHAR(255) NOT NULL,
  `jenis_pasien` ENUM('umum','bpjs') NOT NULL DEFAULT 'umum',
  `no_bpjs` VARCHAR(20) DEFAULT NULL,
  `status_bpjs` ENUM('tidak_berlaku','menunggu','terverifikasi','ditolak') NOT NULL DEFAULT 'tidak_berlaku',
  `catatan_bpjs` VARCHAR(255) DEFAULT NULL,
  `no_hp` VARCHAR(15) NOT NULL DEFAULT '',
  `golongan_darah` ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-','tidak_tahu') NOT NULL DEFAULT 'tidak_tahu',
  `alergi` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pasien`),
  UNIQUE KEY `uq_pasien_user` (`id_user`),
  UNIQUE KEY `uq_pasien_norm` (`no_rm`),
  UNIQUE KEY `uq_pasien_nik` (`nik`),
  UNIQUE KEY `uq_pasien_bpjs` (`no_bpjs`),
  CONSTRAINT `fk_pasien_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `dokter` (
  `id_dokter` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_poli` INT(10) UNSIGNED NOT NULL,
  `id_user` INT(10) UNSIGNED DEFAULT NULL,
  `nama_dokter` VARCHAR(100) NOT NULL,
  `spesialisasi` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_dokter`),
  KEY `idx_dokter_poli` (`id_poli`),
  UNIQUE KEY `uq_dokter_user` (`id_user`),
  CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id_poli`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dokter_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jadwal_dokter` (
  `id_jadwal` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_dokter` INT(10) UNSIGNED NOT NULL,
  `tanggal` DATE NOT NULL,
  `jam_mulai` TIME NOT NULL,
  `jam_selesai` TIME NOT NULL,
  `kuota` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 20,
  PRIMARY KEY (`id_jadwal`),
  KEY `idx_jadwal_dokter_tgl` (`id_dokter`,`tanggal`),
  CONSTRAINT `fk_jadwal_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pasien` INT(10) UNSIGNED NOT NULL,
  `id_jadwal` INT(10) UNSIGNED NOT NULL,
  `jenis_kunjungan` ENUM('baru','kontrol') NOT NULL,
  `no_antrean` INT(10) UNSIGNED NOT NULL,
  `kode_antrean` VARCHAR(10) DEFAULT NULL,
  `kode_booking` VARCHAR(20) DEFAULT NULL,
  `no_rujukan` VARCHAR(30) DEFAULT NULL,
  `faskes_perujuk` VARCHAR(100) DEFAULT NULL,
  `keluhan_awal` TEXT NOT NULL,
  `status` ENUM('menunggu','dikonfirmasi','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu',
  `waktu_checkin` DATETIME DEFAULT NULL,
  `tanggal_daftar` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pendaftaran`),
  UNIQUE KEY `uq_pendaftaran_antrean` (`id_jadwal`,`no_antrean`),
  UNIQUE KEY `kode_booking` (`kode_booking`),
  KEY `idx_pendaftaran_pasien` (`id_pasien`),
  CONSTRAINT `fk_pendaftaran_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_dokter` (`id_jadwal`) ON UPDATE CASCADE,
  CONSTRAINT `fk_pendaftaran_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rekam_medis` (
  `id_rekam_medis` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pasien` INT(10) UNSIGNED NOT NULL,
  `id_pendaftaran` INT(10) UNSIGNED NOT NULL,
  `id_dokter` INT(10) UNSIGNED NOT NULL,
  `tanggal_periksa` DATE NOT NULL,
  `keluhan` TEXT DEFAULT NULL,
  `alergi` VARCHAR(255) DEFAULT NULL,
  `ttv_sistolik` INT DEFAULT NULL,
  `ttv_diastolik` INT DEFAULT NULL,
  `ttv_nadi` INT DEFAULT NULL,
  `ttv_napas` INT DEFAULT NULL,
  `ttv_suhu` DECIMAL(4,1) DEFAULT NULL,
  `ttv_spo2` INT DEFAULT NULL,
  `pemeriksaan_fisik` TEXT DEFAULT NULL,
  `kode_diagnosis` VARCHAR(20) DEFAULT NULL,
  `diagnosis` TEXT NOT NULL,
  `tindakan` TEXT DEFAULT NULL,
  `resep` TEXT DEFAULT NULL,
  `rencana` TEXT DEFAULT NULL,
  `catatan` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_rekam_medis`),
  UNIQUE KEY `uq_rm_pendaftaran` (`id_pendaftaran`),
  KEY `idx_rm_pasien` (`id_pasien`),
  KEY `idx_rm_dokter` (`id_dokter`),
  CONSTRAINT `fk_rm_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON UPDATE CASCADE,
  CONSTRAINT `fk_rm_pendaftaran` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON UPDATE CASCADE,
  CONSTRAINT `fk_rm_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `audit_log` (
  `id_audit_log` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` INT(10) UNSIGNED DEFAULT NULL,
  `aksi` VARCHAR(50) NOT NULL,
  `id_pendaftaran` INT(10) UNSIGNED DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_audit_log`),
  KEY `idx_audit_user` (`id_user`),
  KEY `idx_audit_pendaftaran` (`id_pendaftaran`),
  CONSTRAINT `fk_audit_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rekam_medis_revisi` (
  `id_revisi` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_rekam_medis` INT(10) UNSIGNED NOT NULL,
  `field` VARCHAR(50) NOT NULL,
  `nilai_lama` TEXT DEFAULT NULL,
  `nilai_baru` TEXT DEFAULT NULL,
  `alasan` TEXT NOT NULL,
  `id_user` INT(10) UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_revisi`),
  KEY `id_rekam_medis` (`id_rekam_medis`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `fk_revisi_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- DATA DEMO
-- Password di bawah ini sudah dalam bentuk hash bcrypt yang dibuat
-- dari admin123 / pasien123 / dokter123 dan sudah diverifikasi
-- dengan password_verify. Jangan mengedit hash-nya.
-- ---------------------------------------------------------------------

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@demo.local', '$2y$10$3qN.tb7F1klfXzCCW3run.nbEcyw8cKTdJnc33hY5UDcqPF1JEoU6', 'admin'),
(2, 'Pasien Demo', 'pasien@demo.local', '$2y$10$bAtmxNBtKieMHcQdUsloqeXa7I/GcL0yUq6wypegeUCLZAHa6NU5i', 'pasien'),
(3, 'Dokter Demo', 'dokter@demo.local', '$2y$10$YWsWGcjAMZrHkkf9Kdjk1uu5YxtPep2owOndQYBletkWgxLMhOepa', 'dokter');

INSERT INTO `poli` (`id_poli`, `nama_poli`, `deskripsi`, `kode_antrean`) VALUES
(1, 'Poli Umum', 'Pemeriksaan kesehatan umum dan konsultasi awal.', 'U'),
(2, 'Poli Gigi', 'Perawatan dan pemeriksaan kesehatan gigi dan mulut.', 'G');

INSERT INTO `pasien` (`id_pasien`, `id_user`, `no_rm`, `nik`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `jenis_pasien`, `no_bpjs`, `status_bpjs`, `catatan_bpjs`, `no_hp`, `golongan_darah`, `alergi`) VALUES
(1, 2, CONCAT('RM', DATE_FORMAT(CURDATE(), '%Y%m%d'), '0001'), '0000000000000001', '2000-01-01', 'L', 'Jl. Demo No. 1, Jakarta', 'umum', NULL, 'tidak_berlaku', NULL, '081200000001', 'O+', NULL);

INSERT INTO `dokter` (`id_dokter`, `id_poli`, `id_user`, `nama_dokter`, `spesialisasi`) VALUES
(1, 1, 3, 'dr. Demo', 'Dokter Umum');

-- Jadwal selalu relatif terhadap tanggal import: hari ini (untuk demo
-- check-in hari-H), besok (untuk demo pengingat H-1), dan lusa.
INSERT INTO `jadwal_dokter` (`id_dokter`, `tanggal`, `jam_mulai`, `jam_selesai`, `kuota`) VALUES
(1, CURDATE(), '08:00:00', '12:00:00', 20),
(1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '08:00:00', '12:00:00', 20),
(1, DATE_ADD(CURDATE(), INTERVAL 2 DAY), '13:00:00', '16:00:00', 10),
(1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:00:00', '12:00:00', 20);

-- Data demo alur lengkap (semua generik/dummy). ID jadwal: 1 = hari
-- ini, 4 = jadwal lampau. Booking aktif hari ini masih menunggu,
-- jadi kuota jadwal hari ini berkurang 1 (sisa 19 dari 20).
INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_pasien`, `id_jadwal`, `jenis_kunjungan`, `no_antrean`, `kode_antrean`, `kode_booking`, `keluhan_awal`, `status`) VALUES
(1, 1, 1, 'baru', 1, 'U001', 'AB23CD45', 'Demam dan batuk ringan (data demo).', 'menunggu'),
(2, 1, 4, 'kontrol', 1, 'U001', 'CD45EF67', 'Kontrol pilek (data demo).', 'selesai');

INSERT INTO `rekam_medis` (`id_rekam_medis`, `id_pasien`, `id_pendaftaran`, `id_dokter`, `tanggal_periksa`, `keluhan`, `alergi`, `ttv_sistolik`, `ttv_diastolik`, `ttv_nadi`, `ttv_napas`, `ttv_suhu`, `ttv_spo2`, `pemeriksaan_fisik`, `kode_diagnosis`, `diagnosis`, `tindakan`, `resep`, `rencana`, `catatan`) VALUES
(1, 1, 2, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'Pilek dan hidung tersumbat (data demo).', NULL, 120, 80, 72, 18, 36.8, 98, 'Keadaan umum baik, tenggorokan tidak merah (data demo).', 'J06', 'Infeksi saluran pernapasan atas akut multipel', 'Pemeriksaan fisik dan edukasi istirahat cukup', 'Paracetamol — 500 mg — 3x1 — 10 tablet — sesudah makan', 'Kontrol bila keluhan memburuk', NULL);

INSERT INTO `rekam_medis_revisi` (`id_rekam_medis`, `field`, `nilai_lama`, `nilai_baru`, `alasan`, `id_user`) VALUES
(1, 'kode_diagnosis', 'J00', 'J06', 'Koreksi kode diagnosis setelah verifikasi ulang (data demo).', 3);

INSERT INTO `audit_log` (`id_user`, `aksi`, `id_pendaftaran`, `keterangan`) VALUES
(2, 'booking', 1, 'Pasien membuat pendaftaran id 1.'),
(1, 'checkin', 2, 'Admisi melakukan check-in pendaftaran id 2.'),
(3, 'buat', 2, 'Dokter membuat rekam medis id 1 untuk pendaftaran 2.'),
(3, 'lihat', 2, 'Dokter melihat rekam medis id 1.'),
(3, 'ubah', 2, 'Dokter mengoreksi rekam medis id 1 (kode_diagnosis). Alasan: Koreksi kode diagnosis setelah verifikasi ulang (data demo).');

SET FOREIGN_KEY_CHECKS = 1;
