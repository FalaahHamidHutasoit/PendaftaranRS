<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// v6: '/' adalah Beranda (Home). Daftar jadwal tetap di '/jadwal';
// admin/dokter yang membuka Beranda di-redirect ke dashboard mereka
// oleh Beranda::index.
$routes->get('/', 'Beranda::index');
$routes->get('beranda', 'Beranda::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
// v2: logout lewat POST (dengan CSRF) agar tidak bisa dipicu oleh
// sekadar memuat URL/gambar dari situs lain.
$routes->post('logout', 'Auth::logout');

$routes->get('registrasi', 'PendaftaranPasien::index');
$routes->post('registrasi', 'PendaftaranPasien::simpan');

$routes->get('jadwal', 'Jadwal::index');

$routes->group('pendaftaran', ['filter' => 'auth:pasien'], static function ($routes) {
    $routes->get('/', 'Pendaftaran::riwayat');
    $routes->get('buat/(:num)', 'Pendaftaran::buat/$1');
    $routes->post('simpan', 'Pendaftaran::simpan');
    $routes->post('batal/(:num)', 'Pendaftaran::batal/$1');
});

$routes->group('profil', ['filter' => 'auth:pasien'], static function ($routes) {
    $routes->get('/', 'PendaftaranPasien::profil');
    $routes->post('simpan', 'PendaftaranPasien::simpanProfil');
});

$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('poli', 'Admin::poli');
    $routes->get('poli/tambah', 'Admin::poliForm');
    $routes->post('poli/simpan', 'Admin::poliSimpan');
    $routes->get('poli/ubah/(:num)', 'Admin::poliForm/$1');
    $routes->post('poli/hapus/(:num)', 'Admin::poliHapus/$1');
    $routes->get('dokter', 'Admin::dokter');
    $routes->get('dokter/tambah', 'Admin::dokterForm');
    $routes->post('dokter/akun', 'Admin::akunDokterSimpan');
    $routes->post('dokter/simpan', 'Admin::dokterSimpan');
    $routes->get('dokter/ubah/(:num)', 'Admin::dokterForm/$1');
    $routes->post('dokter/hapus/(:num)', 'Admin::dokterHapus/$1');
    $routes->get('jadwal', 'Admin::jadwal');
    $routes->get('jadwal/tambah', 'Admin::jadwalForm');
    $routes->post('jadwal/simpan', 'Admin::jadwalSimpan');
    $routes->get('jadwal/ubah/(:num)', 'Admin::jadwalForm/$1');
    $routes->post('jadwal/hapus/(:num)', 'Admin::jadwalHapus/$1');
    $routes->get('pasien', 'Admin::pasien');
    $routes->post('pasien/bpjs/(:num)', 'Admin::verifikasiBpjs/$1');
    $routes->get('pendaftaran', 'Admin::pendaftaran');
    // v7: pindai/cari kode booking (ketik, scanner USB, atau kamera in-app).
    $routes->get('pendaftaran/pindai', 'Admin::pindai');
    $routes->post('pendaftaran/pindai-checkin/(:num)', 'Admin::pindaiCheckIn/$1');
    $routes->post('pendaftaran/status/(:num)', 'Admin::ubahStatusPendaftaran/$1');
    $routes->post('pendaftaran/checkin/(:num)', 'Admin::checkIn/$1');
    $routes->get('rekap', 'Admin::rekap');
});

$routes->group('dokter', ['filter' => 'auth:dokter'], static function ($routes) {
    $routes->get('/', 'Dokter::index');
    $routes->get('pasien', 'Dokter::pasienTerjadwal');
    $routes->get('jadwal/ubah/(:num)', 'Dokter::jadwalForm/$1');
    $routes->post('jadwal/simpan', 'Dokter::jadwalSimpan');
    $routes->get('rekam-medis', 'Dokter::rekamMedis');
    $routes->get('rekam-medis/lihat/(:num)', 'Dokter::rekamMedisLihat/$1');
    $routes->get('rekam-medis/buat/(:num)', 'Dokter::rekamMedisForm/$1');
    // v7: pratinjau konfirmasi sebelum simpan + kembali ke form + koreksi beraudit.
    $routes->post('rekam-medis/pratinjau', 'Dokter::rekamMedisPratinjau');
    $routes->post('rekam-medis/kembali', 'Dokter::rekamMedisKembali');
    $routes->post('rekam-medis/simpan', 'Dokter::rekamMedisSimpan');
    $routes->get('rekam-medis/ubah/(:num)', 'Dokter::rekamMedisUbahForm/$1');
    $routes->post('rekam-medis/ubah/(:num)', 'Dokter::rekamMedisUbahSimpan/$1');
});

// Endpoint API (autentikasi sesi, untuk keperluan UTS).
// Pada produksi, endpoint ini harus memakai token API, bukan sesi browser.
$routes->post('api/pendaftaran', 'Pendaftaran::apiSimpan', ['filter' => 'auth:pasien']);
