-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Okt 2026 pada 10.41
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pendaftaran_rs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int(10) UNSIGNED NOT NULL,
  `id_poli` int(10) UNSIGNED NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `spesialisasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `id_poli`, `nama_dokter`, `spesialisasi`) VALUES
(1, 1, 'dr. Andi Pratama', 'Dokter Umum'),
(2, 2, 'drg. Siti Rahmawati', 'Dokter Gigi'),
(3, 3, 'dr. Maya Lestari, Sp.A', 'Spesialis Anak'),
(4, 4, 'dr. Hendra Wijaya, Sp.PD', 'Spesialis Penyakit Dalam'),
(5, 1, 'dr. Citra Anindya', 'Dokter Umum'),
(6, 2, 'drg. Reza Firmansyah', 'Dokter Gigi'),
(7, 3, 'dr. Bayu Nugroho, Sp.A', 'Spesialis Anak'),
(8, 4, 'dr. Lina Marlina, Sp.PD', 'Spesialis Penyakit Dalam'),
(9, 9, 'dr. Fajar Ramadhan, Sp.M', 'Spesialis Mata'),
(10, 10, 'dr. Dewi Kusuma, Sp.THT-KL', 'Spesialis THT'),
(11, 11, 'dr. Tania Putri, Sp.KK', 'Spesialis Kulit dan Kelamin'),
(12, 12, 'dr. Ahmad Syarif, Sp.N', 'Spesialis Saraf'),
(13, 13, 'dr. Yudi Hartono, Sp.JP', 'Spesialis Jantung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `id_dokter` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota` smallint(5) UNSIGNED NOT NULL DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`id_jadwal`, `id_dokter`, `tanggal`, `jam_mulai`, `jam_selesai`, `kuota`) VALUES
(1, 1, '2026-10-24', '08:00:00', '12:00:00', 20),
(2, 2, '2026-10-24', '13:00:00', '16:00:00', 10),
(3, 3, '2026-10-25', '09:00:00', '12:00:00', 15),
(4, 4, '2026-10-26', '10:00:00', '14:00:00', 12),
(5, 1, '2026-10-27', '08:00:00', '12:00:00', 20),
(6, 1, '2026-10-26', '08:00:00', '12:00:00', 20),
(7, 1, '2026-10-28', '08:00:00', '12:00:00', 20),
(8, 1, '2026-10-22', '08:00:00', '12:00:00', 20),
(9, 1, '2026-10-20', '08:00:00', '12:00:00', 20),
(10, 1, '2026-10-23', '08:00:00', '12:00:00', 20),
(11, 5, '2026-10-25', '13:00:00', '16:00:00', 15),
(12, 5, '2026-10-27', '13:00:00', '16:00:00', 15),
(13, 5, '2026-10-29', '13:00:00', '16:00:00', 15),
(14, 5, '2026-10-22', '13:00:00', '16:00:00', 15),
(15, 5, '2026-10-20', '13:00:00', '16:00:00', 15),
(16, 2, '2026-10-26', '08:00:00', '12:00:00', 12),
(17, 2, '2026-10-28', '08:00:00', '12:00:00', 12),
(18, 2, '2026-10-30', '08:00:00', '12:00:00', 12),
(19, 2, '2026-10-22', '08:00:00', '12:00:00', 12),
(20, 2, '2026-10-20', '08:00:00', '12:00:00', 12),
(21, 6, '2026-10-24', '13:00:00', '16:00:00', 10),
(22, 6, '2026-10-27', '13:00:00', '16:00:00', 10),
(23, 6, '2026-10-29', '13:00:00', '16:00:00', 10),
(24, 6, '2026-10-22', '13:00:00', '16:00:00', 10),
(25, 6, '2026-10-20', '13:00:00', '16:00:00', 10),
(26, 6, '2026-10-23', '13:00:00', '16:00:00', 10),
(27, 3, '2026-10-25', '08:00:00', '12:00:00', 25),
(28, 3, '2026-10-28', '08:00:00', '12:00:00', 25),
(29, 3, '2026-10-30', '08:00:00', '12:00:00', 25),
(30, 3, '2026-10-22', '08:00:00', '12:00:00', 25),
(31, 3, '2026-10-20', '08:00:00', '12:00:00', 25),
(32, 7, '2026-10-24', '13:00:00', '16:00:00', 18),
(33, 7, '2026-10-26', '13:00:00', '16:00:00', 18),
(34, 7, '2026-10-29', '13:00:00', '16:00:00', 18),
(35, 7, '2026-10-22', '13:00:00', '16:00:00', 18),
(36, 7, '2026-10-20', '13:00:00', '16:00:00', 18),
(37, 4, '2026-10-25', '08:00:00', '12:00:00', 20),
(38, 4, '2026-10-27', '08:00:00', '12:00:00', 20),
(39, 4, '2026-10-30', '08:00:00', '12:00:00', 20),
(40, 4, '2026-10-22', '08:00:00', '12:00:00', 20),
(41, 4, '2026-10-20', '08:00:00', '12:00:00', 20),
(42, 4, '2026-10-23', '08:00:00', '12:00:00', 20),
(43, 8, '2026-10-24', '13:00:00', '16:00:00', 15),
(44, 8, '2026-10-26', '13:00:00', '16:00:00', 15),
(45, 8, '2026-10-28', '13:00:00', '16:00:00', 15),
(46, 8, '2026-10-22', '13:00:00', '16:00:00', 15),
(47, 8, '2026-10-20', '13:00:00', '16:00:00', 15),
(48, 9, '2026-10-25', '08:00:00', '12:00:00', 12),
(49, 9, '2026-10-27', '08:00:00', '12:00:00', 12),
(50, 9, '2026-10-29', '08:00:00', '12:00:00', 12),
(51, 9, '2026-10-22', '08:00:00', '12:00:00', 12),
(52, 9, '2026-10-20', '08:00:00', '12:00:00', 12),
(53, 10, '2026-10-26', '13:00:00', '16:00:00', 10),
(54, 10, '2026-10-28', '13:00:00', '16:00:00', 10),
(55, 10, '2026-10-30', '13:00:00', '16:00:00', 10),
(56, 10, '2026-10-22', '13:00:00', '16:00:00', 10),
(57, 10, '2026-10-20', '13:00:00', '16:00:00', 10),
(58, 10, '2026-10-23', '13:00:00', '16:00:00', 10),
(59, 11, '2026-10-24', '08:00:00', '12:00:00', 25),
(60, 11, '2026-10-27', '08:00:00', '12:00:00', 25),
(61, 11, '2026-10-29', '08:00:00', '12:00:00', 25),
(62, 11, '2026-10-22', '08:00:00', '12:00:00', 25),
(63, 11, '2026-10-20', '08:00:00', '12:00:00', 25),
(64, 12, '2026-10-25', '13:00:00', '16:00:00', 18),
(65, 12, '2026-10-28', '13:00:00', '16:00:00', 18),
(66, 12, '2026-10-30', '13:00:00', '16:00:00', 18),
(67, 12, '2026-10-22', '13:00:00', '16:00:00', 18),
(68, 12, '2026-10-20', '13:00:00', '16:00:00', 18),
(69, 13, '2026-10-24', '08:00:00', '12:00:00', 20),
(70, 13, '2026-10-26', '08:00:00', '12:00:00', 20),
(71, 13, '2026-10-29', '08:00:00', '12:00:00', 20),
(72, 13, '2026-10-22', '08:00:00', '12:00:00', 20),
(73, 13, '2026-10-20', '08:00:00', '12:00:00', 20),
(74, 13, '2026-10-23', '08:00:00', '12:00:00', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `no_rm` varchar(20) NOT NULL,
  `nik` char(16) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jenis_pasien` enum('umum','bpjs') NOT NULL DEFAULT 'umum',
  `no_bpjs` varchar(20) DEFAULT NULL,
  `status_bpjs` enum('tidak_berlaku','menunggu','terverifikasi','ditolak') NOT NULL DEFAULT 'tidak_berlaku',
  `catatan_bpjs` varchar(255) DEFAULT NULL,
  `no_hp` varchar(15) NOT NULL DEFAULT '',
  `golongan_darah` enum('A+','A-','B+','B-','AB+','AB-','O+','O-','tidak_tahu') NOT NULL DEFAULT 'tidak_tahu',
  `alergi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `id_user`, `no_rm`, `nik`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `jenis_pasien`, `no_bpjs`, `status_bpjs`, `catatan_bpjs`, `no_hp`, `golongan_darah`, `alergi`, `created_at`) VALUES
(1, 2, 'RM202610230001', '3171010101900001', '1990-01-01', 'L', 'Jl. Contoh No. 1, Jakarta Timur', 'bpjs', '0001234567890', 'menunggu', NULL, '', 'tidak_tahu', NULL, '2026-10-23 02:54:02'),
(2, 3, 'RM202610230002', '3172010101900001', '1985-03-13', 'P', 'Jl. Cipinang Melayu No. 8, Jakarta Timur', 'bpjs', '0001207388624', 'terverifikasi', NULL, '081297366946', 'B+', 'Alergi obat sulfa', '2026-10-23 08:38:56'),
(3, 4, 'RM202610230003', '3172010201900002', '1997-04-02', 'L', 'Jl. Pemuda No. 31, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081221535642', 'B-', NULL, '2026-10-23 08:38:56'),
(4, 5, 'RM202610230004', '3172010301900003', '1970-09-14', 'P', 'Jl. Rawamangun No. 6, Jakarta Timur', 'bpjs', '0005070378921', 'terverifikasi', NULL, '081217933677', 'B-', NULL, '2026-10-23 08:38:56'),
(5, 6, 'RM202610230005', '3172010401900004', '2000-03-10', 'L', 'Jl. Pemuda No. 74, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081266255890', 'O+', NULL, '2026-10-23 08:38:56'),
(6, 7, 'RM202610230006', '3172010501900005', '1984-09-27', 'P', 'Jl. Pulogadung No. 9, Jakarta Timur', 'bpjs', '0006101867205', 'menunggu', NULL, '081234256684', 'B+', NULL, '2026-10-23 08:38:56'),
(7, 8, 'RM202610230007', '3172010601900006', '2001-01-20', 'L', 'Jl. Klender Indah No. 41, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081237643310', 'tidak_tahu', NULL, '2026-10-23 08:38:56'),
(8, 9, 'RM202610230008', '3172010701900007', '1994-10-15', 'P', 'Jl. Pemuda No. 74, Jakarta Timur', 'bpjs', '0002287489453', 'terverifikasi', NULL, '081258530762', 'O+', 'Alergi debu', '2026-10-23 08:38:56'),
(9, 10, 'RM202610230009', '3172010801900008', '1984-09-16', 'L', 'Jl. Cipinang Melayu No. 10, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081256100526', 'tidak_tahu', NULL, '2026-10-23 08:38:56'),
(10, 11, 'RM202610230010', '3172010901900009', '1972-09-14', 'L', 'Jl. Klender Indah No. 6, Jakarta Timur', 'bpjs', '0008546862847', 'ditolak', 'Nomor BPJS tidak aktif / tidak ditemukan pada data kepesertaan.', '081232140838', 'O+', 'Alergi kacang', '2026-10-23 08:38:56'),
(11, 12, 'RM202610230011', '3172011001900010', '2007-02-25', 'P', 'Jl. Klender Indah No. 75, Jakarta Timur', 'bpjs', '0006642502604', 'terverifikasi', NULL, '081284903659', 'A-', NULL, '2026-10-23 08:38:56'),
(12, 13, 'RM202610230012', '3172011101900011', '1994-02-27', 'L', 'Jl. Pemuda No. 94, Jakarta Timur', 'bpjs', '0009352341718', 'menunggu', NULL, '081222562241', 'tidak_tahu', NULL, '2026-10-23 08:38:56'),
(13, 14, 'RM202610230013', '3172011201900012', '1984-11-19', 'P', 'Jl. Pulogadung No. 45, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081269812891', 'O-', NULL, '2026-10-23 08:38:56'),
(14, 15, 'RM202610230014', '3172011301900013', '1966-08-12', 'L', 'Jl. Rawamangun No. 99, Jakarta Timur', 'bpjs', '0003623879480', 'terverifikasi', NULL, '081232555071', 'tidak_tahu', NULL, '2026-10-23 08:38:56'),
(15, 16, 'RM202610230015', '3172011401900014', '1983-03-24', 'P', 'Jl. Jatinegara Barat No. 64, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081243234300', 'B-', NULL, '2026-10-23 08:38:56'),
(16, 17, 'RM202610230016', '3172011501900015', '1970-03-15', 'L', 'Jl. Jatinegara Barat No. 71, Jakarta Timur', 'bpjs', '0007654793745', 'menunggu', NULL, '081263907779', 'O+', NULL, '2026-10-23 08:38:56'),
(17, 18, 'RM202610230017', '3172011601900016', '1982-12-14', 'P', 'Jl. Rawamangun No. 11, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081258153450', 'B-', 'Alergi debu', '2026-10-23 08:38:56'),
(18, 19, 'RM202610230018', '3172011701900017', '1976-03-08', 'L', 'Jl. Rawamangun No. 34, Jakarta Timur', 'bpjs', '0002002170858', 'terverifikasi', NULL, '081298384612', 'tidak_tahu', NULL, '2026-10-23 08:38:56'),
(19, 20, 'RM202610230019', '3172011801900018', '1983-01-05', 'P', 'Jl. Cipinang Melayu No. 41, Jakarta Timur', 'umum', NULL, 'tidak_berlaku', NULL, '081266230047', 'A-', NULL, '2026-10-23 08:38:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `poli`
--

CREATE TABLE `poli` (
  `id_poli` int(10) UNSIGNED NOT NULL,
  `nama_poli` varchar(100) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `poli`
--

INSERT INTO `poli` (`id_poli`, `nama_poli`, `deskripsi`) VALUES
(1, 'Poli Umum', 'Pemeriksaan kesehatan umum dan konsultasi awal.'),
(2, 'Poli Gigi', 'Perawatan dan pemeriksaan kesehatan gigi dan mulut.'),
(3, 'Poli Anak', 'Pelayanan kesehatan bayi, anak, dan imunisasi.'),
(4, 'Poli Penyakit Dalam', 'Diagnosis dan penanganan penyakit organ dalam dewasa.'),
(9, 'Poli Mata', 'Pemeriksaan mata, gangguan penglihatan, dan kacamata.'),
(10, 'Poli THT', 'Telinga, hidung, dan tenggorokan.'),
(11, 'Poli Kulit dan Kelamin', 'Penyakit kulit, alergi kulit, dan kesehatan kelamin.'),
(12, 'Poli Saraf', 'Gangguan saraf, sakit kepala, dan stroke.'),
(13, 'Poli Jantung', 'Pemeriksaan jantung dan pembuluh darah.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int(10) UNSIGNED NOT NULL,
  `id_pasien` int(10) UNSIGNED NOT NULL,
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `jenis_kunjungan` enum('baru','kontrol') NOT NULL,
  `no_antrean` int(10) UNSIGNED NOT NULL,
  `no_rujukan` varchar(30) DEFAULT NULL,
  `faskes_perujuk` varchar(100) DEFAULT NULL,
  `keluhan_awal` text NOT NULL,
  `status` enum('menunggu','dikonfirmasi','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu',
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_pasien`, `id_jadwal`, `jenis_kunjungan`, `no_antrean`, `no_rujukan`, `faskes_perujuk`, `keluhan_awal`, `status`, `tanggal_daftar`) VALUES
(1, 18, 1, 'kontrol', 1, 'RJ-513264', NULL, 'Sakit kepala berulang', 'menunggu', '2026-10-19 08:38:56'),
(2, 3, 1, 'kontrol', 2, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'dikonfirmasi', '2026-10-19 08:38:56'),
(3, 16, 1, 'baru', 3, 'RJ-318904', 'Puskesmas Kecamatan Pulogadung', 'Nyeri perut bagian atas', 'menunggu', '2026-10-19 08:38:56'),
(4, 12, 6, 'baru', 1, 'RJ-258612', 'Klinik Pratama Medika', 'Sakit kepala berulang', 'menunggu', '2026-10-17 08:38:56'),
(5, 3, 6, 'kontrol', 2, NULL, NULL, 'Sakit kepala berulang', 'dikonfirmasi', '2026-10-17 08:38:56'),
(6, 14, 7, 'kontrol', 1, 'RJ-597183', NULL, 'Sakit kepala berulang', 'dikonfirmasi', '2026-10-15 08:38:56'),
(7, 6, 7, 'baru', 2, 'RJ-588625', 'Puskesmas Kecamatan Pulogadung', 'Telinga berdenging', 'menunggu', '2026-10-15 08:38:56'),
(8, 12, 8, 'baru', 1, 'RJ-315183', 'Klinik Pratama Medika', 'Ruam merah dan gatal di lengan', 'dibatalkan', '2026-10-19 08:38:56'),
(9, 10, 8, 'baru', 2, 'RJ-128356', 'Klinik Pratama Medika', 'Kontrol rutin tekanan darah', 'dibatalkan', '2026-10-19 08:38:56'),
(10, 17, 8, 'baru', 3, NULL, NULL, 'Kontrol rutin tekanan darah', 'selesai', '2026-10-19 08:38:56'),
(11, 13, 9, 'kontrol', 1, NULL, NULL, 'Anak demam dan rewel', 'selesai', '2026-10-17 08:38:56'),
(12, 7, 9, 'baru', 2, NULL, NULL, 'Pusing dan mudah lelah', 'selesai', '2026-10-17 08:38:56'),
(13, 19, 9, 'kontrol', 3, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:56'),
(14, 14, 9, 'baru', 4, 'RJ-472834', 'Puskesmas Kecamatan Jatinegara', 'Demam dan batuk sejak tiga hari', 'selesai', '2026-10-17 08:38:56'),
(15, 5, 9, 'kontrol', 5, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:56'),
(16, 10, 9, 'kontrol', 6, 'RJ-858254', NULL, 'Ruam merah dan gatal di lengan', 'dibatalkan', '2026-10-17 08:38:56'),
(17, 16, 9, 'kontrol', 7, 'RJ-207119', NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'dibatalkan', '2026-10-17 08:38:56'),
(18, 8, 10, 'baru', 1, 'RJ-784697', 'Klinik Sehat Sentosa', 'Nyeri sendi lutut', 'dikonfirmasi', '2026-10-20 08:38:56'),
(19, 12, 10, 'baru', 2, 'RJ-225728', 'Puskesmas Kecamatan Pulogadung', 'Nyeri sendi lutut', 'menunggu', '2026-10-20 08:38:56'),
(20, 19, 10, 'baru', 3, NULL, NULL, 'Nyeri perut bagian atas', 'dikonfirmasi', '2026-10-20 08:38:56'),
(21, 9, 10, 'kontrol', 4, NULL, NULL, 'Ruam merah dan gatal di lengan', 'dikonfirmasi', '2026-10-20 08:38:56'),
(22, 11, 10, 'baru', 5, 'RJ-856888', 'Puskesmas Kecamatan Pulogadung', 'Telinga berdenging', 'dikonfirmasi', '2026-10-20 08:38:56'),
(23, 4, 11, 'baru', 1, 'RJ-587958', 'Puskesmas Kecamatan Matraman', 'Anak demam dan rewel', 'dikonfirmasi', '2026-10-18 08:38:56'),
(24, 7, 11, 'kontrol', 2, NULL, NULL, 'Ruam merah dan gatal di lengan', 'dikonfirmasi', '2026-10-18 08:38:56'),
(25, 18, 11, 'baru', 3, 'RJ-237346', 'Puskesmas Kecamatan Jatinegara', 'Demam dan batuk sejak tiga hari', 'dikonfirmasi', '2026-10-18 08:38:56'),
(26, 19, 11, 'baru', 4, NULL, NULL, 'Nyeri perut bagian atas', 'dikonfirmasi', '2026-10-18 08:38:56'),
(27, 2, 11, 'kontrol', 5, 'RJ-304268', NULL, 'Pusing dan mudah lelah', 'dibatalkan', '2026-10-18 08:38:56'),
(28, 2, 12, 'kontrol', 1, 'RJ-900776', NULL, 'Anak demam dan rewel', 'dikonfirmasi', '2026-10-16 08:38:56'),
(29, 8, 12, 'kontrol', 3, 'RJ-163863', NULL, 'Pilek dan hidung tersumbat', 'dikonfirmasi', '2026-10-16 08:38:56'),
(30, 16, 13, 'baru', 1, 'RJ-648936', 'Klinik Pratama Medika', 'Demam dan batuk sejak tiga hari', 'menunggu', '2026-10-14 08:38:56'),
(31, 18, 13, 'kontrol', 2, 'RJ-738115', NULL, 'Demam dan batuk sejak tiga hari', 'dikonfirmasi', '2026-10-14 08:38:56'),
(32, 15, 13, 'baru', 3, NULL, NULL, 'Telinga berdenging', 'menunggu', '2026-10-14 08:38:56'),
(33, 17, 13, 'baru', 4, NULL, NULL, 'Ruam merah dan gatal di lengan', 'dikonfirmasi', '2026-10-14 08:38:56'),
(34, 18, 14, 'baru', 1, 'RJ-909774', 'Puskesmas Kecamatan Jatinegara', 'Nyeri dada saat beraktivitas', 'selesai', '2026-10-19 08:38:56'),
(35, 17, 14, 'kontrol', 2, NULL, NULL, 'Nyeri sendi lutut', 'selesai', '2026-10-19 08:38:56'),
(36, 5, 14, 'baru', 3, NULL, NULL, 'Anak demam dan rewel', 'selesai', '2026-10-19 08:38:56'),
(37, 16, 14, 'baru', 4, 'RJ-574318', 'Klinik Pratama Medika', 'Nyeri dada saat beraktivitas', 'dibatalkan', '2026-10-19 08:38:56'),
(38, 10, 14, 'kontrol', 5, 'RJ-359685', NULL, 'Pilek dan hidung tersumbat', 'dibatalkan', '2026-10-19 08:38:56'),
(39, 2, 14, 'kontrol', 6, 'RJ-312429', NULL, 'Pusing dan mudah lelah', 'dibatalkan', '2026-10-19 08:38:56'),
(40, 19, 14, 'kontrol', 7, NULL, NULL, 'Sakit kepala berulang', 'selesai', '2026-10-19 08:38:56'),
(41, 16, 15, 'baru', 1, 'RJ-417487', 'Puskesmas Kecamatan Jatinegara', 'Nyeri sendi lutut', 'dibatalkan', '2026-10-17 08:38:56'),
(42, 12, 15, 'baru', 2, 'RJ-774714', 'Klinik Sehat Sentosa', 'Nyeri perut bagian atas', 'dibatalkan', '2026-10-17 08:38:56'),
(43, 4, 15, 'kontrol', 3, 'RJ-590456', NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'dibatalkan', '2026-10-17 08:38:56'),
(44, 18, 15, 'baru', 4, 'RJ-610929', 'Puskesmas Kecamatan Matraman', 'Kontrol gula darah', 'selesai', '2026-10-17 08:38:56'),
(45, 5, 15, 'baru', 5, NULL, NULL, 'Mata terasa perih dan berair', 'selesai', '2026-10-17 08:38:56'),
(46, 8, 15, 'kontrol', 6, 'RJ-305253', NULL, 'Ruam merah dan gatal di lengan', 'selesai', '2026-10-17 08:38:56'),
(47, 4, 16, 'kontrol', 1, 'RJ-118960', NULL, 'Mata terasa perih dan berair', 'dikonfirmasi', '2026-10-17 08:38:56'),
(48, 13, 16, 'kontrol', 2, NULL, NULL, 'Kontrol rutin tekanan darah', 'dikonfirmasi', '2026-10-17 08:38:56'),
(49, 2, 16, 'baru', 3, 'RJ-926658', 'Puskesmas Kecamatan Matraman', 'Sakit kepala berulang', 'menunggu', '2026-10-17 08:38:56'),
(50, 7, 16, 'baru', 4, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'menunggu', '2026-10-17 08:38:56'),
(51, 6, 17, 'kontrol', 2, 'RJ-193807', NULL, 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-15 08:38:56'),
(52, 15, 17, 'baru', 3, NULL, NULL, 'Nyeri perut bagian atas', 'dikonfirmasi', '2026-10-15 08:38:56'),
(53, 4, 18, 'kontrol', 1, 'RJ-997820', NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'menunggu', '2026-10-13 08:38:56'),
(54, 2, 18, 'baru', 3, 'RJ-455626', 'Klinik Pratama Medika', 'Mata terasa perih dan berair', 'dikonfirmasi', '2026-10-13 08:38:56'),
(55, 12, 18, 'kontrol', 4, 'RJ-145304', NULL, 'Nyeri dada saat beraktivitas', 'menunggu', '2026-10-13 08:38:56'),
(56, 3, 18, 'baru', 5, NULL, NULL, 'Nyeri perut bagian atas', 'dibatalkan', '2026-10-13 08:38:56'),
(57, 3, 19, 'kontrol', 1, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-19 08:38:56'),
(58, 7, 19, 'kontrol', 2, NULL, NULL, 'Kontrol gula darah', 'selesai', '2026-10-19 08:38:56'),
(59, 8, 19, 'baru', 3, 'RJ-942718', 'Puskesmas Kecamatan Jatinegara', 'Kontrol rutin tekanan darah', 'selesai', '2026-10-19 08:38:56'),
(60, 16, 19, 'baru', 4, 'RJ-868690', 'Klinik Pratama Medika', 'Nyeri dada saat beraktivitas', 'dibatalkan', '2026-10-19 08:38:56'),
(61, 6, 19, 'baru', 5, 'RJ-357613', 'Puskesmas Kecamatan Pulogadung', 'Sakit kepala berulang', 'dibatalkan', '2026-10-19 08:38:56'),
(62, 17, 20, 'kontrol', 1, NULL, NULL, 'Pilek dan hidung tersumbat', 'selesai', '2026-10-17 08:38:56'),
(63, 14, 20, 'baru', 2, 'RJ-464434', 'Puskesmas Kecamatan Jatinegara', 'Pusing dan mudah lelah', 'selesai', '2026-10-17 08:38:56'),
(64, 11, 20, 'baru', 3, 'RJ-755830', 'Klinik Sehat Sentosa', 'Mata terasa perih dan berair', 'selesai', '2026-10-17 08:38:56'),
(65, 13, 20, 'baru', 4, NULL, NULL, 'Kontrol gula darah', 'selesai', '2026-10-17 08:38:56'),
(66, 5, 20, 'kontrol', 5, NULL, NULL, 'Kontrol gula darah', 'dibatalkan', '2026-10-17 08:38:56'),
(67, 15, 20, 'kontrol', 6, NULL, NULL, 'Pilek dan hidung tersumbat', 'selesai', '2026-10-17 08:38:56'),
(68, 3, 21, 'kontrol', 1, NULL, NULL, 'Kontrol rutin tekanan darah', 'dikonfirmasi', '2026-10-19 08:38:56'),
(69, 16, 21, 'kontrol', 2, 'RJ-673648', NULL, 'Ruam merah dan gatal di lengan', 'dibatalkan', '2026-10-19 08:38:56'),
(70, 7, 21, 'baru', 3, NULL, NULL, 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-19 08:38:56'),
(71, 4, 21, 'baru', 4, 'RJ-101120', 'Klinik Sehat Sentosa', 'Mata terasa perih dan berair', 'menunggu', '2026-10-19 08:38:56'),
(72, 17, 22, 'baru', 1, NULL, NULL, 'Nyeri sendi lutut', 'menunggu', '2026-10-16 08:38:56'),
(73, 6, 23, 'baru', 1, 'RJ-414201', 'Klinik Sehat Sentosa', 'Kontrol gula darah', 'menunggu', '2026-10-14 08:38:56'),
(74, 14, 23, 'baru', 2, 'RJ-654895', 'Puskesmas Kecamatan Matraman', 'Kontrol gula darah', 'menunggu', '2026-10-14 08:38:56'),
(75, 14, 24, 'baru', 1, 'RJ-975864', 'Klinik Pratama Medika', 'Kontrol gula darah', 'selesai', '2026-10-19 08:38:56'),
(76, 12, 24, 'kontrol', 2, 'RJ-951673', NULL, 'Nyeri dada saat beraktivitas', 'dibatalkan', '2026-10-19 08:38:56'),
(77, 17, 24, 'baru', 3, NULL, NULL, 'Nyeri sendi lutut', 'dibatalkan', '2026-10-19 08:38:56'),
(78, 4, 24, 'baru', 4, 'RJ-712432', 'Puskesmas Kecamatan Matraman', 'Sakit kepala berulang', 'selesai', '2026-10-19 08:38:56'),
(79, 6, 24, 'baru', 5, 'RJ-768068', 'Klinik Sehat Sentosa', 'Sakit kepala berulang', 'dibatalkan', '2026-10-19 08:38:56'),
(80, 13, 24, 'kontrol', 6, NULL, NULL, 'Nyeri dada saat beraktivitas', 'selesai', '2026-10-19 08:38:56'),
(81, 11, 24, 'baru', 7, 'RJ-756646', 'Klinik Pratama Medika', 'Kontrol gula darah', 'selesai', '2026-10-19 08:38:56'),
(82, 17, 25, 'baru', 1, NULL, NULL, 'Nyeri dada saat beraktivitas', 'selesai', '2026-10-17 08:38:57'),
(83, 10, 25, 'baru', 2, 'RJ-169258', 'Puskesmas Kecamatan Pulogadung', 'Kontrol rutin tekanan darah', 'dibatalkan', '2026-10-17 08:38:57'),
(84, 2, 25, 'baru', 3, 'RJ-346190', 'Puskesmas Kecamatan Matraman', 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:57'),
(85, 9, 25, 'kontrol', 4, NULL, NULL, 'Mata terasa perih dan berair', 'selesai', '2026-10-17 08:38:57'),
(86, 17, 26, 'baru', 1, NULL, NULL, 'Kontrol gula darah', 'dikonfirmasi', '2026-10-20 08:38:57'),
(87, 11, 26, 'baru', 2, 'RJ-254586', 'Klinik Sehat Sentosa', 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-20 08:38:57'),
(88, 6, 27, 'kontrol', 1, 'RJ-804644', NULL, 'Sakit kepala berulang', 'menunggu', '2026-10-18 08:38:57'),
(89, 2, 27, 'baru', 2, 'RJ-404985', 'Klinik Pratama Medika', 'Kontrol rutin tekanan darah', 'dikonfirmasi', '2026-10-18 08:38:57'),
(90, 17, 27, 'kontrol', 3, NULL, NULL, 'Nyeri sendi lutut', 'dikonfirmasi', '2026-10-18 08:38:57'),
(91, 18, 27, 'baru', 4, 'RJ-675748', 'Puskesmas Kecamatan Matraman', 'Kontrol rutin tekanan darah', 'dibatalkan', '2026-10-18 08:38:57'),
(92, 17, 28, 'kontrol', 1, NULL, NULL, 'Pusing dan mudah lelah', 'dikonfirmasi', '2026-10-15 08:38:57'),
(93, 2, 28, 'kontrol', 2, 'RJ-505639', NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'dibatalkan', '2026-10-15 08:38:57'),
(94, 4, 29, 'kontrol', 1, 'RJ-239046', NULL, 'Anak demam dan rewel', 'dibatalkan', '2026-10-13 08:38:57'),
(95, 19, 29, 'kontrol', 2, NULL, NULL, 'Pilek dan hidung tersumbat', 'dibatalkan', '2026-10-13 08:38:57'),
(96, 6, 29, 'kontrol', 3, 'RJ-609755', NULL, 'Mata terasa perih dan berair', 'menunggu', '2026-10-13 08:38:57'),
(97, 7, 30, 'kontrol', 1, NULL, NULL, 'Pilek dan hidung tersumbat', 'selesai', '2026-10-19 08:38:57'),
(98, 2, 30, 'baru', 2, 'RJ-494375', 'Klinik Sehat Sentosa', 'Sakit kepala berulang', 'selesai', '2026-10-19 08:38:57'),
(99, 17, 30, 'kontrol', 3, NULL, NULL, 'Nyeri sendi lutut', 'selesai', '2026-10-19 08:38:57'),
(100, 14, 31, 'kontrol', 1, 'RJ-168133', NULL, 'Mata terasa perih dan berair', 'selesai', '2026-10-17 08:38:57'),
(101, 5, 31, 'kontrol', 2, NULL, NULL, 'Anak demam dan rewel', 'dibatalkan', '2026-10-17 08:38:57'),
(102, 8, 31, 'baru', 3, 'RJ-548845', 'Klinik Sehat Sentosa', 'Pusing dan mudah lelah', 'selesai', '2026-10-17 08:38:57'),
(103, 13, 31, 'baru', 4, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'selesai', '2026-10-17 08:38:57'),
(104, 2, 31, 'kontrol', 5, 'RJ-256148', NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:57'),
(105, 15, 32, 'kontrol', 1, NULL, NULL, 'Mata terasa perih dan berair', 'dikonfirmasi', '2026-10-19 08:38:57'),
(106, 18, 32, 'baru', 2, 'RJ-761542', 'Puskesmas Kecamatan Pulogadung', 'Nyeri dada saat beraktivitas', 'dikonfirmasi', '2026-10-19 08:38:57'),
(107, 12, 32, 'baru', 3, 'RJ-151879', 'Puskesmas Kecamatan Pulogadung', 'Telinga berdenging', 'menunggu', '2026-10-19 08:38:57'),
(108, 5, 32, 'baru', 4, NULL, NULL, 'Kontrol rutin tekanan darah', 'dikonfirmasi', '2026-10-19 08:38:57'),
(109, 3, 33, 'kontrol', 1, NULL, NULL, 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-17 08:38:57'),
(110, 6, 33, 'kontrol', 2, 'RJ-350258', NULL, 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-17 08:38:57'),
(111, 7, 33, 'kontrol', 3, NULL, NULL, 'Mata terasa perih dan berair', 'dikonfirmasi', '2026-10-17 08:38:57'),
(112, 9, 33, 'baru', 4, NULL, NULL, 'Nyeri perut bagian atas', 'menunggu', '2026-10-17 08:38:57'),
(113, 8, 33, 'baru', 5, 'RJ-951261', 'Puskesmas Kecamatan Pulogadung', 'Nyeri dada saat beraktivitas', 'menunggu', '2026-10-17 08:38:57'),
(114, 16, 34, 'kontrol', 1, 'RJ-301753', NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'menunggu', '2026-10-14 08:38:57'),
(115, 12, 34, 'baru', 2, 'RJ-682876', 'Puskesmas Kecamatan Jatinegara', 'Ruam merah dan gatal di lengan', 'menunggu', '2026-10-14 08:38:57'),
(116, 19, 34, 'baru', 3, NULL, NULL, 'Nyeri sendi lutut', 'menunggu', '2026-10-14 08:38:57'),
(117, 8, 35, 'baru', 1, 'RJ-454631', 'Puskesmas Kecamatan Jatinegara', 'Telinga berdenging', 'selesai', '2026-10-19 08:38:57'),
(118, 2, 35, 'kontrol', 2, 'RJ-477639', NULL, 'Nyeri perut bagian atas', 'selesai', '2026-10-19 08:38:57'),
(119, 15, 35, 'baru', 3, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-19 08:38:57'),
(120, 19, 35, 'kontrol', 4, NULL, NULL, 'Telinga berdenging', 'selesai', '2026-10-19 08:38:57'),
(121, 16, 35, 'kontrol', 5, 'RJ-989909', NULL, 'Pusing dan mudah lelah', 'dibatalkan', '2026-10-19 08:38:57'),
(122, 13, 35, 'baru', 6, NULL, NULL, 'Mata terasa perih dan berair', 'selesai', '2026-10-19 08:38:57'),
(123, 10, 35, 'kontrol', 7, 'RJ-613618', NULL, 'Demam dan batuk sejak tiga hari', 'dibatalkan', '2026-10-19 08:38:57'),
(124, 14, 36, 'kontrol', 1, 'RJ-214343', NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:57'),
(125, 18, 36, 'baru', 2, 'RJ-815207', 'Puskesmas Kecamatan Jatinegara', 'Pusing dan mudah lelah', 'selesai', '2026-10-17 08:38:57'),
(126, 16, 36, 'kontrol', 3, 'RJ-914598', NULL, 'Demam dan batuk sejak tiga hari', 'dibatalkan', '2026-10-17 08:38:57'),
(127, 6, 37, 'baru', 1, 'RJ-418538', 'Puskesmas Kecamatan Matraman', 'Kontrol gula darah', 'menunggu', '2026-10-18 08:38:57'),
(128, 9, 37, 'kontrol', 2, NULL, NULL, 'Mata terasa perih dan berair', 'dikonfirmasi', '2026-10-18 08:38:57'),
(129, 5, 38, 'kontrol', 1, NULL, NULL, 'Anak demam dan rewel', 'dikonfirmasi', '2026-10-16 08:38:57'),
(130, 4, 38, 'baru', 2, 'RJ-334443', 'Klinik Pratama Medika', 'Demam dan batuk sejak tiga hari', 'menunggu', '2026-10-16 08:38:57'),
(131, 19, 39, 'kontrol', 1, NULL, NULL, 'Ruam merah dan gatal di lengan', 'menunggu', '2026-10-13 08:38:57'),
(132, 11, 39, 'baru', 2, 'RJ-346172', 'Klinik Pratama Medika', 'Gigi berlubang dan nyeri saat mengunyah', 'dikonfirmasi', '2026-10-13 08:38:57'),
(133, 15, 40, 'baru', 1, NULL, NULL, 'Kontrol gula darah', 'selesai', '2026-10-19 08:38:57'),
(134, 11, 40, 'kontrol', 2, 'RJ-338908', NULL, 'Kontrol gula darah', 'selesai', '2026-10-19 08:38:57'),
(135, 3, 40, 'kontrol', 3, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'dibatalkan', '2026-10-19 08:38:57'),
(136, 3, 41, 'baru', 1, NULL, NULL, 'Kontrol rutin tekanan darah', 'selesai', '2026-10-17 08:38:57'),
(137, 12, 41, 'baru', 2, 'RJ-310149', 'Klinik Sehat Sentosa', 'Nyeri sendi lutut', 'dibatalkan', '2026-10-17 08:38:57'),
(138, 15, 41, 'baru', 3, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:57'),
(139, 7, 41, 'kontrol', 4, NULL, NULL, 'Kontrol rutin tekanan darah', 'selesai', '2026-10-17 08:38:57'),
(140, 18, 41, 'baru', 5, 'RJ-619846', 'Klinik Pratama Medika', 'Nyeri perut bagian atas', 'dibatalkan', '2026-10-17 08:38:57'),
(141, 8, 41, 'baru', 6, 'RJ-797611', 'Puskesmas Kecamatan Jatinegara', 'Anak demam dan rewel', 'selesai', '2026-10-17 08:38:57'),
(142, 14, 42, 'baru', 1, 'RJ-248804', 'Puskesmas Kecamatan Pulogadung', 'Demam dan batuk sejak tiga hari', 'dibatalkan', '2026-10-20 08:38:57'),
(143, 3, 42, 'baru', 2, NULL, NULL, 'Telinga berdenging', 'menunggu', '2026-10-20 08:38:57'),
(144, 8, 42, 'kontrol', 3, 'RJ-183216', NULL, 'Nyeri perut bagian atas', 'dikonfirmasi', '2026-10-20 08:38:57'),
(145, 8, 43, 'kontrol', 1, 'RJ-497011', NULL, 'Pusing dan mudah lelah', 'dikonfirmasi', '2026-10-19 08:38:57'),
(146, 7, 43, 'kontrol', 2, NULL, NULL, 'Telinga berdenging', 'dibatalkan', '2026-10-19 08:38:57'),
(147, 16, 43, 'baru', 3, 'RJ-182042', 'Klinik Sehat Sentosa', 'Sakit kepala berulang', 'menunggu', '2026-10-19 08:38:57'),
(148, 2, 43, 'kontrol', 4, 'RJ-229717', NULL, 'Nyeri dada saat beraktivitas', 'dikonfirmasi', '2026-10-19 08:38:57'),
(149, 14, 44, 'kontrol', 1, 'RJ-839515', NULL, 'Telinga berdenging', 'menunggu', '2026-10-17 08:38:57'),
(150, 13, 44, 'baru', 2, NULL, NULL, 'Telinga berdenging', 'menunggu', '2026-10-17 08:38:57'),
(151, 11, 44, 'baru', 3, 'RJ-873135', 'Puskesmas Kecamatan Pulogadung', 'Demam dan batuk sejak tiga hari', 'menunggu', '2026-10-17 08:38:57'),
(152, 9, 45, 'kontrol', 1, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'menunggu', '2026-10-15 08:38:57'),
(153, 14, 45, 'kontrol', 2, 'RJ-165904', NULL, 'Anak demam dan rewel', 'menunggu', '2026-10-15 08:38:57'),
(154, 3, 45, 'kontrol', 3, NULL, NULL, 'Ruam merah dan gatal di lengan', 'menunggu', '2026-10-15 08:38:57'),
(155, 8, 45, 'baru', 4, 'RJ-851447', 'Klinik Sehat Sentosa', 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-15 08:38:57'),
(156, 2, 45, 'kontrol', 5, 'RJ-892358', NULL, 'Anak demam dan rewel', 'menunggu', '2026-10-15 08:38:57'),
(157, 2, 46, 'kontrol', 1, 'RJ-588367', NULL, 'Nyeri sendi lutut', 'selesai', '2026-10-19 08:38:57'),
(158, 9, 46, 'kontrol', 2, NULL, NULL, 'Mata terasa perih dan berair', 'selesai', '2026-10-19 08:38:57'),
(159, 5, 46, 'kontrol', 3, NULL, NULL, 'Telinga berdenging', 'selesai', '2026-10-19 08:38:57'),
(160, 2, 47, 'baru', 1, 'RJ-435071', 'Puskesmas Kecamatan Pulogadung', 'Ruam merah dan gatal di lengan', 'selesai', '2026-10-17 08:38:57'),
(161, 11, 47, 'baru', 2, 'RJ-510711', 'Puskesmas Kecamatan Matraman', 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:57'),
(162, 6, 47, 'kontrol', 3, 'RJ-135508', NULL, 'Telinga berdenging', 'dibatalkan', '2026-10-17 08:38:57'),
(163, 18, 47, 'kontrol', 4, 'RJ-547274', NULL, 'Sakit kepala berulang', 'selesai', '2026-10-17 08:38:57'),
(164, 4, 48, 'kontrol', 2, 'RJ-568674', NULL, 'Nyeri perut bagian atas', 'dibatalkan', '2026-10-18 08:38:57'),
(165, 6, 49, 'baru', 1, 'RJ-988130', 'Puskesmas Kecamatan Jatinegara', 'Nyeri sendi lutut', 'menunggu', '2026-10-16 08:38:57'),
(166, 15, 49, 'kontrol', 2, NULL, NULL, 'Anak demam dan rewel', 'menunggu', '2026-10-16 08:38:57'),
(167, 16, 49, 'kontrol', 3, 'RJ-873919', NULL, 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-16 08:38:57'),
(168, 16, 50, 'baru', 1, 'RJ-395021', 'Klinik Pratama Medika', 'Gigi berlubang dan nyeri saat mengunyah', 'menunggu', '2026-10-14 08:38:57'),
(169, 9, 50, 'kontrol', 2, NULL, NULL, 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-14 08:38:57'),
(170, 7, 50, 'baru', 3, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'dikonfirmasi', '2026-10-14 08:38:57'),
(171, 16, 51, 'baru', 1, 'RJ-958891', 'Puskesmas Kecamatan Matraman', 'Pusing dan mudah lelah', 'dibatalkan', '2026-10-19 08:38:57'),
(172, 3, 51, 'kontrol', 2, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'dibatalkan', '2026-10-19 08:38:57'),
(173, 5, 51, 'kontrol', 3, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'selesai', '2026-10-19 08:38:57'),
(174, 8, 52, 'baru', 1, 'RJ-372575', 'Puskesmas Kecamatan Jatinegara', 'Sakit kepala berulang', 'selesai', '2026-10-17 08:38:57'),
(175, 4, 52, 'kontrol', 2, 'RJ-486618', NULL, 'Ruam merah dan gatal di lengan', 'selesai', '2026-10-17 08:38:57'),
(176, 13, 52, 'baru', 3, NULL, NULL, 'Kontrol rutin tekanan darah', 'selesai', '2026-10-17 08:38:57'),
(177, 10, 52, 'baru', 4, 'RJ-783297', 'Puskesmas Kecamatan Matraman', 'Pusing dan mudah lelah', 'dibatalkan', '2026-10-17 08:38:57'),
(178, 12, 53, 'kontrol', 1, 'RJ-427360', NULL, 'Sakit kepala berulang', 'menunggu', '2026-10-17 08:38:57'),
(179, 15, 53, 'baru', 2, NULL, NULL, 'Telinga berdenging', 'menunggu', '2026-10-17 08:38:57'),
(180, 17, 54, 'baru', 1, NULL, NULL, 'Sakit kepala berulang', 'dikonfirmasi', '2026-10-15 08:38:57'),
(181, 4, 54, 'baru', 2, 'RJ-384339', 'Puskesmas Kecamatan Pulogadung', 'Kontrol rutin tekanan darah', 'menunggu', '2026-10-15 08:38:57'),
(182, 15, 54, 'kontrol', 3, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'dikonfirmasi', '2026-10-15 08:38:57'),
(183, 3, 54, 'kontrol', 4, NULL, NULL, 'Ruam merah dan gatal di lengan', 'dikonfirmasi', '2026-10-15 08:38:57'),
(184, 14, 54, 'kontrol', 5, 'RJ-903904', NULL, 'Nyeri sendi lutut', 'dikonfirmasi', '2026-10-15 08:38:57'),
(185, 8, 54, 'kontrol', 6, 'RJ-509711', NULL, 'Pilek dan hidung tersumbat', 'dikonfirmasi', '2026-10-15 08:38:57'),
(186, 8, 55, 'kontrol', 1, 'RJ-194883', NULL, 'Mata terasa perih dan berair', 'menunggu', '2026-10-13 08:38:57'),
(187, 2, 55, 'kontrol', 2, 'RJ-270440', NULL, 'Nyeri perut bagian atas', 'dikonfirmasi', '2026-10-13 08:38:57'),
(188, 15, 55, 'baru', 3, NULL, NULL, 'Nyeri perut bagian atas', 'menunggu', '2026-10-13 08:38:57'),
(189, 16, 55, 'kontrol', 4, 'RJ-752418', NULL, 'Ruam merah dan gatal di lengan', 'menunggu', '2026-10-13 08:38:57'),
(190, 4, 55, 'baru', 5, 'RJ-397056', 'Puskesmas Kecamatan Matraman', 'Nyeri dada saat beraktivitas', 'menunggu', '2026-10-13 08:38:57'),
(191, 4, 56, 'baru', 1, 'RJ-977964', 'Puskesmas Kecamatan Jatinegara', 'Telinga berdenging', 'selesai', '2026-10-19 08:38:57'),
(192, 5, 56, 'kontrol', 2, NULL, NULL, 'Kontrol gula darah', 'selesai', '2026-10-19 08:38:57'),
(193, 14, 56, 'kontrol', 3, 'RJ-846911', NULL, 'Anak demam dan rewel', 'selesai', '2026-10-19 08:38:57'),
(194, 9, 56, 'baru', 4, NULL, NULL, 'Pusing dan mudah lelah', 'selesai', '2026-10-19 08:38:57'),
(195, 14, 57, 'baru', 1, 'RJ-643049', 'Puskesmas Kecamatan Matraman', 'Mata terasa perih dan berair', 'selesai', '2026-10-17 08:38:57'),
(196, 8, 57, 'kontrol', 2, 'RJ-359060', NULL, 'Pilek dan hidung tersumbat', 'selesai', '2026-10-17 08:38:57'),
(197, 17, 57, 'baru', 3, NULL, NULL, 'Nyeri dada saat beraktivitas', 'selesai', '2026-10-17 08:38:57'),
(198, 4, 57, 'baru', 4, 'RJ-439951', 'Puskesmas Kecamatan Jatinegara', 'Mata terasa perih dan berair', 'selesai', '2026-10-17 08:38:57'),
(199, 16, 58, 'kontrol', 1, 'RJ-485299', NULL, 'Telinga berdenging', 'menunggu', '2026-10-20 08:38:57'),
(200, 11, 58, 'kontrol', 2, 'RJ-103678', NULL, 'Anak demam dan rewel', 'menunggu', '2026-10-20 08:38:57'),
(201, 15, 58, 'kontrol', 3, NULL, NULL, 'Telinga berdenging', 'dikonfirmasi', '2026-10-20 08:38:57'),
(202, 6, 58, 'kontrol', 4, 'RJ-949901', NULL, 'Telinga berdenging', 'menunggu', '2026-10-20 08:38:57'),
(203, 18, 58, 'kontrol', 5, 'RJ-234695', NULL, 'Ruam merah dan gatal di lengan', 'menunggu', '2026-10-20 08:38:57'),
(204, 5, 58, 'kontrol', 6, NULL, NULL, 'Nyeri sendi lutut', 'menunggu', '2026-10-20 08:38:57'),
(205, 18, 59, 'baru', 1, 'RJ-869109', 'Klinik Sehat Sentosa', 'Nyeri sendi lutut', 'menunggu', '2026-10-19 08:38:57'),
(206, 19, 59, 'baru', 2, NULL, NULL, 'Nyeri dada saat beraktivitas', 'menunggu', '2026-10-19 08:38:57'),
(207, 3, 59, 'kontrol', 3, NULL, NULL, 'Nyeri sendi lutut', 'dikonfirmasi', '2026-10-19 08:38:57'),
(208, 2, 59, 'baru', 4, 'RJ-169605', 'Klinik Pratama Medika', 'Pilek dan hidung tersumbat', 'menunggu', '2026-10-19 08:38:57'),
(209, 12, 59, 'baru', 5, 'RJ-615763', 'Klinik Sehat Sentosa', 'Nyeri sendi lutut', 'menunggu', '2026-10-19 08:38:57'),
(210, 9, 60, 'kontrol', 1, NULL, NULL, 'Anak demam dan rewel', 'menunggu', '2026-10-16 08:38:57'),
(211, 4, 60, 'kontrol', 2, 'RJ-578573', NULL, 'Nyeri perut bagian atas', 'dibatalkan', '2026-10-16 08:38:57'),
(212, 13, 60, 'kontrol', 3, NULL, NULL, 'Telinga berdenging', 'dikonfirmasi', '2026-10-16 08:38:57'),
(213, 18, 61, 'baru', 2, 'RJ-269061', 'Klinik Sehat Sentosa', 'Kontrol gula darah', 'menunggu', '2026-10-14 08:38:57'),
(214, 9, 61, 'kontrol', 3, NULL, NULL, 'Nyeri perut bagian atas', 'dibatalkan', '2026-10-14 08:38:57'),
(215, 5, 62, 'kontrol', 1, NULL, NULL, 'Telinga berdenging', 'dibatalkan', '2026-10-19 08:38:57'),
(216, 18, 62, 'baru', 2, 'RJ-661723', 'Puskesmas Kecamatan Pulogadung', 'Pilek dan hidung tersumbat', 'selesai', '2026-10-19 08:38:57'),
(217, 3, 62, 'kontrol', 3, NULL, NULL, 'Ruam merah dan gatal di lengan', 'selesai', '2026-10-19 08:38:57'),
(218, 12, 62, 'baru', 4, 'RJ-901782', 'Puskesmas Kecamatan Jatinegara', 'Telinga berdenging', 'dibatalkan', '2026-10-19 08:38:57'),
(219, 15, 62, 'baru', 5, NULL, NULL, 'Pilek dan hidung tersumbat', 'selesai', '2026-10-19 08:38:57'),
(220, 11, 63, 'kontrol', 1, 'RJ-714329', NULL, 'Kontrol gula darah', 'selesai', '2026-10-17 08:38:57'),
(221, 18, 63, 'kontrol', 2, 'RJ-883411', NULL, 'Demam dan batuk sejak tiga hari', 'selesai', '2026-10-17 08:38:57'),
(222, 10, 63, 'baru', 3, 'RJ-745977', 'Puskesmas Kecamatan Pulogadung', 'Mata terasa perih dan berair', 'dibatalkan', '2026-10-17 08:38:57'),
(223, 13, 64, 'baru', 1, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'menunggu', '2026-10-18 08:38:57'),
(224, 3, 64, 'kontrol', 2, NULL, NULL, 'Nyeri dada saat beraktivitas', 'menunggu', '2026-10-18 08:38:57'),
(225, 6, 64, 'kontrol', 3, 'RJ-533311', NULL, 'Anak demam dan rewel', 'menunggu', '2026-10-18 08:38:57'),
(226, 9, 64, 'kontrol', 4, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'dikonfirmasi', '2026-10-18 08:38:57'),
(227, 5, 64, 'kontrol', 5, NULL, NULL, 'Telinga berdenging', 'dikonfirmasi', '2026-10-18 08:38:57'),
(228, 11, 64, 'baru', 6, 'RJ-940436', 'Puskesmas Kecamatan Matraman', 'Pilek dan hidung tersumbat', 'menunggu', '2026-10-18 08:38:57'),
(229, 16, 65, 'baru', 1, 'RJ-920150', 'Klinik Sehat Sentosa', 'Mata terasa perih dan berair', 'dibatalkan', '2026-10-15 08:38:57'),
(230, 5, 65, 'kontrol', 2, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'dibatalkan', '2026-10-15 08:38:57'),
(231, 4, 65, 'kontrol', 3, 'RJ-706572', NULL, 'Telinga berdenging', 'dikonfirmasi', '2026-10-15 08:38:57'),
(232, 18, 66, 'baru', 1, 'RJ-525710', 'Puskesmas Kecamatan Matraman', 'Gigi berlubang dan nyeri saat mengunyah', 'dikonfirmasi', '2026-10-13 08:38:57'),
(233, 17, 66, 'baru', 2, NULL, NULL, 'Nyeri sendi lutut', 'menunggu', '2026-10-13 08:38:57'),
(234, 9, 66, 'baru', 3, NULL, NULL, 'Nyeri dada saat beraktivitas', 'menunggu', '2026-10-13 08:38:57'),
(235, 4, 66, 'baru', 4, 'RJ-309210', 'Klinik Pratama Medika', 'Anak demam dan rewel', 'menunggu', '2026-10-13 08:38:57'),
(236, 2, 66, 'kontrol', 5, 'RJ-283122', NULL, 'Nyeri dada saat beraktivitas', 'dikonfirmasi', '2026-10-13 08:38:57'),
(237, 15, 66, 'kontrol', 6, NULL, NULL, 'Kontrol gula darah', 'menunggu', '2026-10-13 08:38:57'),
(238, 17, 67, 'kontrol', 1, NULL, NULL, 'Telinga berdenging', 'selesai', '2026-10-19 08:38:57'),
(239, 2, 67, 'baru', 2, 'RJ-574467', 'Puskesmas Kecamatan Matraman', 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-19 08:38:57'),
(240, 14, 67, 'baru', 3, 'RJ-775303', 'Puskesmas Kecamatan Jatinegara', 'Sakit kepala berulang', 'selesai', '2026-10-19 08:38:57'),
(241, 10, 68, 'kontrol', 1, 'RJ-648661', NULL, 'Kontrol rutin tekanan darah', 'dibatalkan', '2026-10-17 08:38:57'),
(242, 3, 68, 'kontrol', 2, NULL, NULL, 'Gigi berlubang dan nyeri saat mengunyah', 'selesai', '2026-10-17 08:38:57'),
(243, 19, 68, 'baru', 3, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'dibatalkan', '2026-10-17 08:38:57'),
(244, 12, 68, 'baru', 4, 'RJ-347578', 'Puskesmas Kecamatan Matraman', 'Nyeri perut bagian atas', 'dibatalkan', '2026-10-17 08:38:57'),
(245, 17, 68, 'kontrol', 5, NULL, NULL, 'Mata terasa perih dan berair', 'selesai', '2026-10-17 08:38:57'),
(246, 9, 69, 'baru', 1, NULL, NULL, 'Mata terasa perih dan berair', 'dibatalkan', '2026-10-19 08:38:57'),
(247, 14, 69, 'baru', 2, 'RJ-422700', 'Puskesmas Kecamatan Matraman', 'Mata terasa perih dan berair', 'dikonfirmasi', '2026-10-19 08:38:57'),
(248, 17, 69, 'baru', 3, NULL, NULL, 'Nyeri perut bagian atas', 'dikonfirmasi', '2026-10-19 08:38:57'),
(249, 19, 69, 'baru', 4, NULL, NULL, 'Sakit kepala berulang', 'menunggu', '2026-10-19 08:38:57'),
(250, 7, 70, 'baru', 1, NULL, NULL, 'Demam dan batuk sejak tiga hari', 'dikonfirmasi', '2026-10-17 08:38:57'),
(251, 13, 70, 'baru', 2, NULL, NULL, 'Kontrol gula darah', 'menunggu', '2026-10-17 08:38:57'),
(252, 4, 71, 'baru', 1, 'RJ-898772', 'Klinik Sehat Sentosa', 'Gigi berlubang dan nyeri saat mengunyah', 'dibatalkan', '2026-10-14 08:38:57'),
(253, 3, 71, 'baru', 2, NULL, NULL, 'Nyeri sendi lutut', 'dibatalkan', '2026-10-14 08:38:57'),
(254, 5, 72, 'baru', 1, NULL, NULL, 'Nyeri sendi lutut', 'dibatalkan', '2026-10-19 08:38:57'),
(255, 9, 72, 'baru', 2, NULL, NULL, 'Kontrol gula darah', 'selesai', '2026-10-19 08:38:57'),
(256, 8, 72, 'kontrol', 3, 'RJ-239097', NULL, 'Sakit kepala berulang', 'selesai', '2026-10-19 08:38:57'),
(257, 19, 72, 'baru', 4, NULL, NULL, 'Ruam merah dan gatal di lengan', 'selesai', '2026-10-19 08:38:57'),
(258, 3, 72, 'kontrol', 5, NULL, NULL, 'Ruam merah dan gatal di lengan', 'selesai', '2026-10-19 08:38:57'),
(259, 2, 72, 'kontrol', 6, 'RJ-150759', NULL, 'Pilek dan hidung tersumbat', 'dibatalkan', '2026-10-19 08:38:57'),
(260, 12, 73, 'baru', 1, 'RJ-132766', 'Puskesmas Kecamatan Pulogadung', 'Nyeri dada saat beraktivitas', 'dibatalkan', '2026-10-17 08:38:57'),
(261, 18, 73, 'baru', 2, 'RJ-838889', 'Puskesmas Kecamatan Jatinegara', 'Nyeri dada saat beraktivitas', 'selesai', '2026-10-17 08:38:57'),
(262, 17, 73, 'baru', 3, NULL, NULL, 'Pusing dan mudah lelah', 'selesai', '2026-10-17 08:38:57'),
(263, 15, 73, 'baru', 4, NULL, NULL, 'Kontrol rutin tekanan darah', 'selesai', '2026-10-17 08:38:57'),
(264, 6, 73, 'baru', 5, 'RJ-648987', 'Puskesmas Kecamatan Matraman', 'Kontrol rutin tekanan darah', 'dibatalkan', '2026-10-17 08:38:57'),
(265, 2, 74, 'kontrol', 1, 'RJ-828978', NULL, 'Nyeri sendi lutut', 'menunggu', '2026-10-20 08:38:57'),
(266, 13, 74, 'baru', 2, NULL, NULL, 'Anak demam dan rewel', 'dibatalkan', '2026-10-20 08:38:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pasien') NOT NULL DEFAULT 'pasien',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator RS', 'admin@rslp3i.test', '$2y$10$X0laFjsdW5hqC091onFv8uf8vkvyNO7LfThWLZ24Lujt96RdnAh4e', 'admin', '2026-10-23 02:54:02'),
(2, 'Budi Santoso', 'pasien@rslp3i.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 02:54:02'),
(3, 'Rina Wulandari', 'rina.wulandari@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(4, 'Dimas Anggara', 'dimas.anggara@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(5, 'Putri Maharani', 'putri.maharani@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(6, 'Eko Prasetyo', 'eko.prasetyo@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(7, 'Nadia Safitri', 'nadia.safitri@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(8, 'Fauzan Hakim', 'fauzan.hakim@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(9, 'Laras Ayu Pertiwi', 'laras.ayu.pertiwi@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(10, 'Rizky Maulana', 'rizky.maulana@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(11, 'Wahyu Setiawan', 'wahyu.setiawan@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(12, 'Anisa Rahmi', 'anisa.rahmi@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(13, 'Galih Permana', 'galih.permana@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(14, 'Siska Amelia', 'siska.amelia@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(15, 'Taufik Hidayat', 'taufik.hidayat@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(16, 'Melati Kusumawati', 'melati.kusumawati@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(17, 'Bagas Saputra', 'bagas.saputra@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(18, 'Yuli Astuti', 'yuli.astuti@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(19, 'Hasan Basri', 'hasan.basri@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56'),
(20, 'Intan Permata', 'intan.permata@contoh.test', '$2y$10$v8/VtomLQzn8oUD9wXpjxe6gg3tBO0WsYeAlZ34HWAwAlMjQ4SQM6', 'pasien', '2026-10-23 08:38:56');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `idx_dokter_poli` (`id_poli`);

--
-- Indeks untuk tabel `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `idx_jadwal_dokter_tgl` (`id_dokter`,`tanggal`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD UNIQUE KEY `uq_pasien_user` (`id_user`),
  ADD UNIQUE KEY `uq_pasien_norm` (`no_rm`),
  ADD UNIQUE KEY `uq_pasien_nik` (`nik`);

--
-- Indeks untuk tabel `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD UNIQUE KEY `uq_poli_nama` (`nama_poli`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD UNIQUE KEY `uq_reservasi_antrean` (`id_jadwal`,`no_antrean`),
  ADD KEY `idx_reservasi_pasien` (`id_pasien`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id_jadwal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `poli`
--
ALTER TABLE `poli`
  MODIFY `id_poli` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id_poli`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `fk_jadwal_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `fk_pasien_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `fk_reservasi_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_dokter` (`id_jadwal`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservasi_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
