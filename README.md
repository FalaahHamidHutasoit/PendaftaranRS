# Aplikasi Pintar Pendaftaran Pasien RS Politeknik LP3I Jakarta

Aplikasi web pendaftaran pasien rumah sakit (demo akademik, UTS Sistem
Informasi Manajemen) berbasis **CodeIgniter 4 + MySQL**. Pasien mendaftar
dan memesan jadwal dokter secara online, admisi melakukan check-in
(termasuk lewat kode booking / QR), dan dokter mencatat rekam medis SOAP
dengan pratinjau dan koreksi beraudit.

Dokumen ini menggantikan README bawaan CodeIgniter 4 yang sebelumnya ada
di repo. Dokumen ini hanya panduan instalasi dan pengoperasian aplikasi;
laporan lengkap (Bab I–V) ada di file laporan Word yang terpisah.

## Fungsi utama

- Pasien: registrasi (umum/BPJS), lihat jadwal + sisa kuota, booking
  (baru/kontrol) dengan kode antrean dan kode booking, Beranda dengan
  kartu antrean aktif + QR kode booking, riwayat, pembatalan sebelum
  hari praktik, profil, pengingat H-1.
- Admisi (role `admin`): dashboard, CRUD poli/dokter/jadwal, daftar
  pasien, verifikasi BPJS, daftar pendaftaran, pindai/cari kode booking,
  check-in hari-H, ubah status manual, rekap.
- Dokter: jadwal miliknya, pasien terjadwal, rekam medis SOAP
  (TTV, diagnosis ICD-10 terkurasi + Lainnya, resep per baris),
  pratinjau konfirmasi sebelum simpan, koreksi beraudit (alasan wajib,
  riwayat revisi, tanpa tombol hapus).
- Audit: `audit_log` mencatat login, registrasi, booking, batal,
  check-in, ubah status, verifikasi BPJS, dan rekam medis. Keterangan
  audit tidak berisi kata sandi, NIK, atau nomor BPJS.

## Prasyarat

- PHP ^8.1 (sesuai `composer.json` di repo) dengan ekstensi `intl`,
  `mbstring`, dan `mysqli` (untuk MySQL).
- MySQL / MariaDB dan Composer.
- Cukup PHP + MySQL (untuk `php spark serve`, cara akses
  utama) atau XAMPP (untuk opsi akses lewat Apache).
- Koneksi internet saat pertama kali menjalankan `composer install`
  dan saat membuka aplikasi, karena styling (Bootstrap + ikon) dimuat
  lewat CDN; tanpa internet fungsi tetap jalan.

## Instalasi (pola KAMELA: clone > install > env > import satu file > serve)

### 1. Clone repo

```bash
git clone https://github.com/FalaahHamidHutasoit/PendaftaranRS.git
cd PendaftaranRS
```

### 2. Install vendor sesuai kebutuhan

```bash
composer install
```

Perintah ini membuat folder `vendor/` dari `composer.json` yang ada di
repo. Folder `vendor/` tidak ikut di-commit dan tidak ada di paket
overlay ini; ia selalu dibuat ulang oleh Composer.

### 3. Salin environment development menjadi .env

**Windows CMD**

```cmd
copy .env.development.example .env
```

**PowerShell**

```powershell
Copy-Item .env.development.example .env
```

### 4. Pastikan database di .env

Default proyek ini menggunakan:

```text
database : pendaftaran_rs
host     : localhost
user     : root
password : (kosong, default XAMPP)
port     : 3306
```

Sesuaikan hanya bila MySQL lokal Anda berbeda. JANGAN PERNAH commit
file `.env`.

### 5. Buka phpMyAdmin dan import SATU file saja

```text
PENDAFTARAN_RS_FULL_RESET.sql
```

File ini ada di root proyek (disertakan dalam paket ini) dan bersifat
self-contained: ia membuat database `pendaftaran_rs` sendiri, lalu
menghapus (DROP) dan membuat ulang 9 tabel (7 tabel inti +
`audit_log` + `rekam_medis_revisi`) beserta data demonya. Jadi
**tidak perlu membuat database kosong dulu**, dan sesudah impor
**TIDAK PERLU** `php spark migrate` dan **TIDAK PERLU**
`php spark db:seed`. Menjalankan migrate setelah impor justru akan
gagal karena tabelnya sudah ada. File ini DESTRUKTIF: pakai hanya
untuk instalasi baru/kosong, bukan untuk database yang sudah berisi
data.

Skema yang dibuat file ini sudah sesuai dengan aplikasi di repo
setelah overlay paket ini: kolom kode antrean/kode booking, kolom
SOAP, tabel `rekam_medis_revisi`, tabel `audit_log`, dan UNIQUE
untuk nomor BPJS.

### 6. Jalankan aplikasi (cara akses UTAMA)

```bash
php spark serve
```

Lalu buka di browser:

```
http://localhost:8080
```

**Alternatif (XAMPP lewat Apache):** jalankan Apache dan MySQL dari
XAMPP Control Panel, ubah `app.baseURL` di `.env` ke alamat folder
`public/` (contoh: `http://localhost/PendaftaranRS/public/`), lalu
buka alamat tersebut di browser. Sesuaikan `PendaftaranRS` dengan
nama folder clone Anda.

### 7. Login demo

```
Admisi : admin@demo.local  / admin123
Pasien : pasien@demo.local / pasien123
Dokter : dokter@demo.local / dokter123
```

Akun demo ini hanya untuk instalasi lokal/demo dan harus diganti
bila aplikasi dipakai di luar demo. Akun demo ini juga ditampilkan
di halaman login, di bawah formulir.

## Isi paket perbaikan repo ini

Paket ini (sim-uts-repo-fix-v3) berisi changed-files-only, bukan
proyek penuh:

- `.gitignore` dan `.env.development.example` baru di root
  (menggantikan yang lama; file `.env.example` dari v2 digantikan
  oleh `.env.development.example` ini).
- `README.md` ini (menggantikan README bawaan CodeIgniter 4).
- `PENDAFTARAN_RS_FULL_RESET.sql` di root (pengganti
  `database/sim-uts-full-reset-v1.1.sql` dari v2): isi yang sama
  dengan file full-reset v1.1, ditambah header self-contained
  (`CREATE DATABASE IF NOT EXISTS pendaftaran_rs` + `USE`) di
  paling atas, sehingga tidak perlu membuat database kosong dulu).
- Overlay `app/` dari paket aplikasi v8 (7 file: controller Auth,
  Admin, Pendaftaran, PendaftaranPasien; library AuditTrail; migrasi
  dan seeder yang diperbarui) + view Beranda v9 (tampilan hero +
  modal QR). Overlay ini menyamakan repo — yang sebelumnya masih
  setara aplikasi v7 — dengan versi yang sudah terpasang di XAMPP
  (v8 + tampilan v9). File `app/` lain di repo tetap dipakai sebagai
  basis v7 di bawah overlay ini.
- `CATATAN_PENERAPAN.txt` — daftar file kotor yang harus dihapus
  dari pelacakan git oleh PEMILIK repo sebelum push, karena file
  zip overlay tidak bisa menghapus file yang sudah ter-commit.
- View login `app/Views/auth/login.php` (dari v2, dipertahankan): sama persis
  dengan view login bawaan aplikasi, ditambah satu kotak kecil di
  bawah formulir yang menampilkan ketiga akun demo di atas. Tidak
  ada perubahan logika auth, formulir, validasi, atau styling lain.

## Catatan untuk dosen/penguji yang menginstal

- Bila login gagal setelah instalasi, penyebab paling sering adalah
  `.env` menunjuk ke database yang berbeda dengan database tempat
  file SQL diimpor. Pastikan nama database di `.env` sama dengan
  database tempat impor dilakukan.
- Bila halaman error menampilkan pesan "error view file was not
  specified", itu adalah pesan pengganti CodeIgniter yang menutupi
  error asli. Untuk melihat error asli saat instalasi, pastikan
  `CI_ENVIRONMENT = development` di `.env` dan periksa file log di
  `writable/logs/`.
