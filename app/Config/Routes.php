<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Beranda: arahkan sesuai status login / peran
$routes->get('/', 'Home::index');

// Publik
$routes->get('/pendaftaran', 'Pendaftaran::index');
$routes->post('/pendaftaran', 'Pendaftaran::simpan');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::prosesLogin');
$routes->post('/logout', 'Auth::logout');

// Admin
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth:admin']);
$routes->get('/dokter', 'Dashboard::dokter', ['filter' => 'auth:admin']);
$routes->get('/poli', 'Dashboard::poli', ['filter' => 'auth:admin']);
$routes->get('/jadwal', 'Dashboard::jadwal', ['filter' => 'auth:admin']);

$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    foreach (['poli', 'dokter', 'jadwal'] as $m) {
        $c = ucfirst($m);
        $routes->get("$m/tambah", "Admin::{$m}Form");
        $routes->get("$m/edit/(:num)", "Admin::{$m}Form/$1");
        $routes->post("$m/simpan", "Admin::{$m}Simpan");
        $routes->post("$m/simpan/(:num)", "Admin::{$m}Simpan/$1");
        $routes->post("$m/hapus/(:num)", "Admin::{$m}Hapus/$1");
    }
    $routes->get('pasien', 'Admin::pasien');
    $routes->post('pasien/bpjs/(:num)', 'Admin::pasienBpjs/$1');
    $routes->get('reservasi', 'Admin::reservasi');
    $routes->post('reservasi/status/(:num)', 'Admin::reservasiStatus/$1');
});

// Pasien
$routes->group('', ['filter' => 'auth:pasien'], static function ($routes) {
    $routes->get('reservasi', 'Reservasi::index');
    $routes->get('reservasi/form/(:num)', 'Reservasi::form/$1');
    $routes->post('reservasi/simpan', 'Reservasi::simpan');
    $routes->post('reservasi/batal/(:num)', 'Reservasi::batal/$1');
    $routes->get('riwayat-reservasi', 'Reservasi::riwayat');
    $routes->get('profil', 'Profil::index');
    $routes->post('profil', 'Profil::simpan');
});
