<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Konfigurasi keamanan (CSRF) aplikasi ini.
 *
 * Nilai-nilai di bawah sama dengan bawaan skeleton CI4 4.6, KECUALI
 * $redirect yang sengaja dibuat true di semua environment.
 *
 * Alasannya (temuan uji runtime v2): bawaan skeleton memakai
 * $redirect = (ENVIRONMENT === 'production'), sehingga pada mode
 * development kegagalan CSRF melempar SecurityException ke penampil
 * error debug framework — dan penampil itu sendiri crash
 * ("Undefined array key args" di BaseExceptionHandler) sehingga
 * pengguna melihat 500, bukan 403. Dengan $redirect = true, kegagalan
 * CSRF selalu dialihkan kembali dengan pesan error, di development
 * maupun production, dan aksi tetap TIDAK dieksekusi.
 */
class Security extends BaseConfig
{
    public string $csrfProtection = 'cookie';
    public bool $tokenRandomize   = false;
    public string $tokenName      = 'csrf_test_name';
    public string $headerName     = 'X-CSRF-TOKEN';
    public string $cookieName     = 'csrf_cookie_name';
    public int $expires           = 7200;
    public bool $regenerate       = true;
    public bool $redirect         = true;
}
