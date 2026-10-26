<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Pendaftaran Pasien') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--brand:#118eea;--brand-dark:#0d7acb;--ink:#0f172a;--muted:#64748b;--border:#e6ebf2;--surface:#fff;--bg:#f2f5f9;--success:#0f9f6e;--danger:#dc2626;--warning:#d97706}
*{font-family:'Inter',system-ui,-apple-system,'Segoe UI',sans-serif;box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink)}
.app-header{position:sticky;top:0;z-index:1030;background:rgba(255,255,255,.96);backdrop-filter:blur(8px);border-bottom:1px solid var(--border)}
.app-shell{width:100%;margin:0 auto;padding-left:16px;padding-right:16px}
.app-shell-narrow{max-width:600px}
.app-shell-wide{max-width:1080px}
.brand-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 0}
.brand-mark{width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#2ea3f0,#0b63d8);color:#fff;display:grid;place-items:center;font-size:20px;flex:0 0 auto}
.brand-row strong{display:block;font-size:16px;letter-spacing:-.02em;line-height:1.2}
.brand-row small{display:block;color:var(--muted);font-size:11px}
.user-chip{display:flex;align-items:center;gap:8px;background:#eef6ff;border:1px solid #dbeafe;border-radius:999px;padding:4px 12px 4px 4px;max-width:220px}
.user-chip .avatar{width:28px;height:28px;border-radius:50%;background:var(--brand);color:#fff;display:grid;place-items:center;font-weight:800;font-size:12px;flex:0 0 auto}
.user-chip .user-copy{min-width:0}
.user-chip strong,.user-chip small{display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.2}
.user-chip strong{font-size:12px}
.user-chip small{font-size:10px;color:var(--muted)}
.top-nav{display:flex;gap:6px;overflow-x:auto;padding:0 0 10px;scrollbar-width:none}
.top-nav::-webkit-scrollbar{display:none}
.top-nav a{white-space:nowrap;color:var(--muted);text-decoration:none;font-size:13px;font-weight:600;padding:8px 14px;border-radius:999px}
.top-nav a:hover{color:var(--ink)}
.top-nav a.active{background:#eaf3ff;color:var(--brand)}
.top-nav .nav-count{display:inline-block;min-width:18px;height:18px;line-height:18px;text-align:center;border-radius:999px;background:var(--brand);color:#fff;font-size:10px;padding:0 4px;margin-left:4px}
.app-main{padding:20px 0 24px}
.app-footer{padding-bottom:88px}
@media(min-width:992px){.app-footer{padding-bottom:24px}}
.page-heading{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:18px}
.page-heading h1,.page-heading h2,.page-heading h3{margin:0;font-weight:800;letter-spacing:-.02em;font-size:22px}
.page-heading p{margin:4px 0 0;color:var(--muted);font-size:13px}
.page-icon{width:38px;height:38px;border-radius:12px;background:#eaf3ff;color:var(--brand);display:inline-grid;place-items:center;font-size:18px;flex:0 0 auto}
.surface-card{background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:0 2px 12px rgba(15,40,90,.06)}
.card,.surface-card{border-radius:18px!important}
.btn{border-radius:12px;font-weight:600;min-height:44px;display:inline-flex;align-items:center;justify-content:center;gap:6px}
.btn i{vertical-align:-.08em}
.btn-sm{min-height:34px;border-radius:10px;padding:4px 12px;font-size:13px}
.btn-primary{background:var(--brand);border-color:var(--brand)}
.btn-primary:hover{background:var(--brand-dark);border-color:var(--brand-dark)}
.btn-navy{background:var(--brand);border-color:var(--brand);color:#fff}
.btn-navy:hover{background:var(--brand-dark);border-color:var(--brand-dark);color:#fff}
.form-control,.form-select{border-color:#dbe3ee;border-radius:12px;min-height:48px}
.form-control:focus,.form-select:focus{border-color:#7cc0f5;box-shadow:0 0 0 .2rem rgba(17,142,234,.15)}
.form-label{font-weight:600;font-size:13px}
.table-responsive{scrollbar-width:thin}
.table{--bs-table-hover-bg:#f8fbff}
.table>:not(caption)>*>*{padding:.82rem .85rem}
.table>thead>tr>th{font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#667085;background:#f8fafc;border-bottom-color:#e5e7eb}
.table>tbody>tr>td{vertical-align:middle;border-color:#eef1f5;font-size:13px}
.table>tbody>tr:last-child>td{border-bottom:0}
.table .btn-sm{border-radius:9px}
.badge{font-weight:600;letter-spacing:.01em}
.badge-soft-success{background:#e6f7ef;color:#087956}.badge-soft-danger{background:#fff0f0;color:#b42318}.badge-soft-warning{background:#fff8e7;color:#a35b00}.badge-soft-primary{background:#eaf3ff;color:#0b63d8}.badge-soft-secondary{background:#f1f5f9;color:#475569}
.alert{border-radius:14px}
.hero-antrean{background:linear-gradient(135deg,#2ea3f0,#0b63d8);color:#fff;border:0;border-radius:20px;box-shadow:0 12px 28px rgba(11,99,216,.28)}
.hero-antrean .text-muted{color:rgba(255,255,255,.85)!important}
.hero-num{display:block;font-size:64px;font-weight:800;line-height:1.05;letter-spacing:-.03em}
.hero-badge{background:#fff;color:#0b63d8}
.hero-antrean .btn-light{background:#fff;color:#0b63d8;font-weight:700;border:0}
.hero-empty{background:#eaf3ff;border:1px solid #dbeafe;border-radius:20px}
.antrean-card{border:2px solid #118eea}
.antrean-besar{display:block;font-size:48px;font-weight:800;color:#118eea;line-height:1.1}
.antrean-tebal{font-size:20px;font-weight:800;color:#118eea}
.antrean-item{margin-bottom:14px}
.antrean-item:last-child{margin-bottom:0}
.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.quick-item{display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 6px;background:#fff;border:1px solid var(--border);border-radius:16px;text-decoration:none;color:var(--ink);font-size:12px;font-weight:600;text-align:center;box-shadow:0 2px 10px rgba(15,40,90,.05)}
.quick-item:active{transform:scale(.97)}
.quick-item .qicon{width:48px;height:48px;border-radius:50%;background:#eaf3ff;color:var(--brand);display:grid;place-items:center;font-size:20px}
.list-icon{width:44px;height:44px;border-radius:14px;background:#eaf3ff;color:var(--brand);display:grid;place-items:center;font-size:18px;flex:0 0 auto}
.bottom-nav{position:fixed;left:0;right:0;bottom:0;z-index:1040;background:#fff;border-top:1px solid var(--border);padding:6px 8px calc(6px + env(safe-area-inset-bottom));display:flex;justify-content:space-around}
.bottom-nav a{display:flex;flex-direction:column;align-items:center;gap:2px;text-decoration:none;color:#94a3b8;font-size:11px;font-weight:600;padding:4px 10px;border-radius:12px;position:relative}
.bottom-nav a i{font-size:21px;line-height:1}
.bottom-nav a.active{color:var(--brand)}
.bottom-nav .nav-badge{position:absolute;top:0;right:4px;min-width:18px;height:18px;line-height:18px;text-align:center;border-radius:999px;background:var(--brand);color:#fff;font-size:10px;padding:0 4px}
.empty-state{text-align:center;padding:48px 20px;color:#667085}
.empty-state .empty-icon{width:64px;height:64px;margin:0 auto 12px;border-radius:18px;background:#f2f4f7;color:#98a2b3;display:grid;place-items:center;font-size:26px}
@media(max-width:767.98px){.table>:not(caption)>*>*{padding:.72rem .7rem}}
</style>
</head>
<body>
<?php
// Shell gaya aplikasi mobile fintech (ditulis untuk SIM, bukan tiruan merek).
// Navigasi dihitung di sini dari session + path, supaya footer tidak perlu
// menghitung ulang. Bottom nav dirender di header karena posisinya fixed —
// urutan DOM tidak memengaruhi tampilan, dan semua halaman yang memakai
// header+footer otomatis mendapat navigasi yang sama.
// Active: normalisasi path agar tetap benar baik lewat `php spark serve`
// (path = 'jadwal') maupun lewat subfolder public/ XAMPP
// (path = 'pendaftaran-rs/public/jadwal').
$role = (string) session()->get('role');
$nama = (string) session()->get('nama');
$isLoggedIn = (bool) session()->get('isLoggedIn');
$rawPath = '';
try {
    $rawPath = trim((string) service('uri')->getPath(), '/');
} catch (\Throwable) {
    $rawPath = trim((string) (parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? ''), '/');
}
$path = $rawPath;
$knownFirst = ['beranda', 'jadwal', 'login', 'registrasi', 'pendaftaran', 'profil', 'admin', 'dokter', 'api'];
$segments = $rawPath === '' ? [] : explode('/', $rawPath);
foreach ($segments as $i => $seg) {
    if (in_array($seg, $knownFirst, true)) {
        $path = implode('/', array_slice($segments, $i));
        break;
    }
}
// v6: path kosong = root '/' = Beranda, jadi Beranda aktif saat
// membuka '/' maupun '/beranda'.
if ($path === '') {
    $path = 'beranda';
}
$roleLabels = ['admin' => 'Admisi', 'pasien' => 'Pasien', 'dokter' => 'Dokter'];
// Lebar kontainer: halaman admin/dokter lebih lebar karena datanya lebih
// banyak; halaman pasien/tamu sempit ala aplikasi HP. Ditentukan dari path,
// tanpa mengubah controller mana pun.
$isWide = $path === 'admin' || str_starts_with($path, 'admin/') || $path === 'dokter' || str_starts_with($path, 'dokter/');
$shellClass = $isWide ? 'app-shell-wide' : 'app-shell-narrow';
// Badge jumlah antrean aktif pasien: SATU query hitung sederhana (bukan
// N+1), dibungkus try/catch supaya layout tidak pernah pecah bila tabel
// belum tersedia. Definisi aktif sama dengan kartu Antrean Saya: status
// menunggu/dikonfirmasi, tanggal jadwal hari ini atau sesudahnya.
$badgeAntrean = 0;
if ($isLoggedIn && $role === 'pasien') {
    try {
        $dbBadge = \Config\Database::connect();
        $badgeAntrean = (int) $dbBadge->table('pendaftaran pd')
            ->join('jadwal_dokter j', 'j.id_jadwal = pd.id_jadwal')
            ->join('pasien ps', 'ps.id_pasien = pd.id_pasien')
            ->where('ps.id_user', (int) session()->get('id_user'))
            ->whereIn('pd.status', ['menunggu', 'dikonfirmasi'])
            ->where('j.tanggal >=', date('Y-m-d'))
            ->countAllResults();
    } catch (\Throwable) {
        $badgeAntrean = 0;
    }
}
$isActiveNav = static function (string $match, bool $exact = false) use ($path): bool {
    if ($exact) {
        return $path === $match;
    }
    return $path === $match || str_starts_with($path, $match . '/');
};
if (! $isLoggedIn) {
    // v6: Beranda sebagai item pertama (Home tempatnya fitur-fitur).
    $topNav = [
        ['Beranda', 'bi-house-door', '/beranda', 'beranda', false],
        ['Jadwal', 'bi-calendar-check', '/jadwal', 'jadwal', false],
        ['Login', 'bi-box-arrow-in-right', '/login', 'login', false],
        ['Registrasi', 'bi-person-plus', '/registrasi', 'registrasi', false],
    ];
    $bottomNav = $topNav;
} elseif ($role === 'pasien') {
    // v6: Beranda sebagai item pertama; badge Antrean Saya tetap.
    $topNav = [
        ['Beranda', 'bi-house-door', '/beranda', 'beranda', false],
        ['Jadwal', 'bi-calendar-check', '/jadwal', 'jadwal', false],
        ['Antrean Saya', 'bi-ticket-detailed', '/pendaftaran', 'pendaftaran', false],
        ['Profil', 'bi-person', '/profil', 'profil', false],
    ];
    $bottomNav = $topNav;
} elseif ($role === 'admin') {
    $topNav = [
        ['Dashboard', 'bi-grid-1x2', '/admin', 'admin', true],
        ['Poli', 'bi-hospital', '/admin/poli', 'admin/poli', false],
        ['Dokter', 'bi-person-badge', '/admin/dokter', 'admin/dokter', false],
        ['Jadwal', 'bi-calendar-week', '/admin/jadwal', 'admin/jadwal', false],
        ['Pasien', 'bi-people', '/admin/pasien', 'admin/pasien', false],
        ['Pendaftaran', 'bi-ticket-detailed', '/admin/pendaftaran', 'admin/pendaftaran', false],
        ['Rekap', 'bi-clipboard-data', '/admin/rekap', 'admin/rekap', false],
    ];
    $bottomNav = [
        ['Dashboard', 'bi-grid-1x2', '/admin', 'admin', true],
        ['Jadwal', 'bi-calendar-week', '/admin/jadwal', 'admin/jadwal', false],
        ['Pendaftaran', 'bi-ticket-detailed', '/admin/pendaftaran', 'admin/pendaftaran', false],
        ['Rekap', 'bi-clipboard-data', '/admin/rekap', 'admin/rekap', false],
    ];
} else {
    $topNav = [
        ['Dashboard', 'bi-grid-1x2', '/dokter', 'dokter', true],
        ['Pasien Terjadwal', 'bi-people', '/dokter/pasien', 'dokter/pasien', false],
        ['Rekam Medis', 'bi-journal-medical', '/dokter/rekam-medis', 'dokter/rekam-medis', false],
    ];
    $bottomNav = $topNav;
}
?>
<header class="app-header">
    <div class="app-shell <?= $shellClass ?>">
        <div class="brand-row">
            <a href="/" class="d-flex align-items-center gap-2 min-w-0" style="text-decoration:none;color:inherit">
                <div class="brand-mark"><i class="bi bi-heart-pulse"></i></div>
                <div class="min-w-0"><strong>Pendaftaran Pasien</strong><small>RS Politeknik LP3I Jakarta</small></div>
            </a>
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                <?php if ($isLoggedIn): ?>
                    <span class="user-chip"><span class="avatar"><?= esc(strtoupper(substr($nama ?: 'U', 0, 1))) ?></span><span class="user-copy"><strong><?= esc($nama ?: 'Pengguna') ?></strong><small><?= esc($roleLabels[$role] ?? ucfirst($role)) ?></small></span></span>
                    <form action="/logout" method="post" class="m-0"><?= csrf_field() ?><button type="submit" class="btn btn-outline-secondary btn-sm" title="Keluar" aria-label="Keluar"><i class="bi bi-box-arrow-right"></i></button></form>
                <?php else: ?>
                    <a class="btn btn-primary btn-sm" href="/login">Masuk</a>
                <?php endif; ?>
            </div>
        </div>
        <nav class="top-nav d-none d-lg-flex" aria-label="Navigasi utama">
            <?php foreach ($topNav as $item): ?><a href="<?= $item[2] ?>" class="<?= $isActiveNav($item[3], $item[4]) ? 'active' : '' ?>"><?= esc($item[0]) ?><?php if ($item[0] === 'Antrean Saya' && $badgeAntrean > 0): ?><span class="nav-count"><?= $badgeAntrean ?></span><?php endif; ?></a><?php endforeach; ?>
        </nav>
    </div>
</header>
<nav class="bottom-nav d-flex d-lg-none" aria-label="Navigasi bawah">
    <?php foreach ($bottomNav as $item): ?><a href="<?= $item[2] ?>" class="<?= $isActiveNav($item[3], $item[4]) ? 'active' : '' ?>"><i class="bi <?= $item[1] ?>"></i><span><?= esc($item[0]) ?></span><?php if ($item[0] === 'Antrean Saya' && $badgeAntrean > 0): ?><span class="nav-badge"><?= $badgeAntrean ?></span><?php endif; ?></a><?php endforeach; ?>
</nav>
<main class="app-main">
<div class="app-shell <?= $shellClass ?>">
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success" role="alert"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
