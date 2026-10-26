<?php
// Sidebar gaya KAMELA, ditulis ulang untuk SIM (bukan salinan file KAMELA).
// Menu per peran, href pola "/" seperti yang sudah dipakai SIM (bukan
// base_url()), supaya cara akses Raka yang sudah jalan tidak rusak.
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
$knownFirst = ['jadwal', 'login', 'registrasi', 'pendaftaran', 'profil', 'admin', 'dokter', 'api'];
$segments = $rawPath === '' ? [] : explode('/', $rawPath);
foreach ($segments as $i => $seg) {
    if (in_array($seg, $knownFirst, true)) {
        $path = implode('/', array_slice($segments, $i));
        break;
    }
}
$active = static function (string $prefix) use ($path): string {
    return ($path === $prefix || str_starts_with($path, $prefix . '/')) ? 'active' : '';
};
$roleLabels = [
    'admin'  => 'Admisi',
    'pasien' => 'Pasien',
    'dokter' => 'Dokter',
];
// Badge jumlah antrean aktif pasien: SATU query hitung sederhana
// (bukan N+1), dibungkus try/catch supaya layout tidak pernah pecah
// bila tabel belum tersedia. Definisi aktif sama dengan kartu Antrean
// Saya di halaman utama: status menunggu/dikonfirmasi, tanggal jadwal
// hari ini atau sesudahnya.
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
$badgeAntreanHtml = $badgeAntrean > 0
    ? '<span class="badge badge-soft-primary ms-auto" title="Antrean aktif">' . $badgeAntrean . '</span>'
    : '';
?>
<div class="mobile-topbar d-none position-fixed top-0 start-0 end-0 bg-white border-bottom px-3 py-3 align-items-center justify-content-between" style="z-index:1100">
    <strong><i class="bi bi-heart-pulse me-2 text-primary"></i>Pendaftaran Pasien</strong>
    <button class="btn btn-light" type="button" onclick="document.querySelector('.sidebar').classList.toggle('open')" aria-label="Menu"><i class="bi bi-list"></i></button>
</div>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-mark"><i class="bi bi-heart-pulse"></i></div>
        <div><strong>Pendaftaran Pasien</strong><small>RS Politeknik LP3I Jakarta</small></div>
    </div>

    <nav class="sidebar-menu">
        <?php if (! $isLoggedIn): ?>
            <div class="nav-label">Layanan Pasien</div>
            <a class="sidebar-link <?= ($path === '' || $path === 'jadwal') ? 'active' : '' ?>" href="/jadwal"><i class="bi bi-calendar-check-fill"></i><span>Jadwal</span></a>
            <a class="sidebar-link <?= $active('login') ?>" href="/login"><i class="bi bi-box-arrow-in-right"></i><span>Login</span></a>
            <a class="sidebar-link <?= $active('registrasi') ?>" href="/registrasi"><i class="bi bi-person-plus-fill"></i><span>Registrasi Pasien</span></a>
        <?php elseif ($role === 'pasien'): ?>
            <div class="nav-label">Pasien</div>
            <a class="sidebar-link <?= ($path === '' || $path === 'jadwal') ? 'active' : '' ?>" href="/jadwal"><i class="bi bi-calendar-check-fill"></i><span>Jadwal</span></a>
            <a class="sidebar-link <?= $active('pendaftaran') ?>" href="/pendaftaran"><i class="bi bi-ticket-detailed-fill"></i><span>Antrean Saya</span><?= $badgeAntreanHtml ?></a>
            <a class="sidebar-link <?= $active('profil') ?>" href="/profil"><i class="bi bi-person-fill"></i><span>Profil</span></a>
        <?php elseif ($role === 'admin'): ?>
            <div class="nav-label">Admisi</div>
            <a class="sidebar-link <?= $path === 'admin' ? 'active' : '' ?>" href="/admin"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
            <a class="sidebar-link <?= $active('admin/poli') ?>" href="/admin/poli"><i class="bi bi-hospital-fill"></i><span>Poli</span></a>
            <a class="sidebar-link <?= $active('admin/dokter') ?>" href="/admin/dokter"><i class="bi bi-person-badge-fill"></i><span>Dokter</span></a>
            <a class="sidebar-link <?= $active('admin/jadwal') ?>" href="/admin/jadwal"><i class="bi bi-calendar-week-fill"></i><span>Jadwal</span></a>
            <a class="sidebar-link <?= $active('admin/pasien') ?>" href="/admin/pasien"><i class="bi bi-people-fill"></i><span>Pasien</span></a>
            <a class="sidebar-link <?= $active('admin/pendaftaran') ?>" href="/admin/pendaftaran"><i class="bi bi-ticket-detailed-fill"></i><span>Pendaftaran</span></a>
            <a class="sidebar-link <?= $active('admin/rekap') ?>" href="/admin/rekap"><i class="bi bi-clipboard-data-fill"></i><span>Rekap</span></a>
        <?php elseif ($role === 'dokter'): ?>
            <div class="nav-label">Dokter</div>
            <a class="sidebar-link <?= $path === 'dokter' ? 'active' : '' ?>" href="/dokter"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
            <a class="sidebar-link <?= $active('dokter/pasien') ?>" href="/dokter/pasien"><i class="bi bi-people-fill"></i><span>Pasien Terjadwal</span></a>
            <a class="sidebar-link <?= $active('dokter/rekam-medis') ?>" href="/dokter/rekam-medis"><i class="bi bi-journal-medical"></i><span>Rekam Medis</span></a>
        <?php endif; ?>
    </nav>

    <div class="sidebar-user">
        <?php if ($isLoggedIn): ?>
            <div class="avatar"><?= esc(strtoupper(substr($nama ?: 'U', 0, 1))) ?></div>
            <div class="user-copy"><strong><?= esc($nama ?: 'Pengguna') ?></strong><small><?= esc($roleLabels[$role] ?? ucfirst($role)) ?></small></div>
            <form action="/logout" method="post" class="logout-form m-0">
                <?= csrf_field() ?>
                <button type="submit" class="logout-icon" title="Keluar" aria-label="Keluar"><i class="bi bi-box-arrow-right"></i></button>
            </form>
        <?php else: ?>
            <div class="avatar">?</div>
            <div class="user-copy"><strong>Belum login</strong><small>Silakan login atau registrasi</small></div>
            <a class="logout-icon" href="/login" title="Login" aria-label="Login"><i class="bi bi-box-arrow-in-right"></i></a>
        <?php endif; ?>
    </div>
</aside>
<style>
.sidebar{position:fixed;left:0;top:0;width:268px;height:100vh;background:#111827;color:#fff;display:flex;flex-direction:column;z-index:1050;transition:.25s ease;box-shadow:12px 0 32px rgba(15,23,42,.08)}
.sidebar-brand{height:78px;padding:0 20px;display:flex;align-items:center;gap:12px;border-bottom:1px solid rgba(255,255,255,.08)}
.brand-mark{width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:grid;place-items:center;font-size:20px;box-shadow:0 8px 20px rgba(37,99,235,.28)}
.sidebar-brand strong{display:block;font-size:16px;letter-spacing:-.02em;line-height:1.15}.sidebar-brand small{display:block;color:#94a3b8;font-size:10px;margin-top:2px}
.sidebar-menu{flex:1;overflow-y:auto;padding:18px 12px}.nav-label{padding:14px 11px 7px;color:#64748b;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.12em}
.sidebar-link{display:flex;align-items:center;gap:11px;padding:10px 12px;margin:2px 0;border-radius:10px;color:#cbd5e1;text-decoration:none;font-size:13px;font-weight:600;transition:.18s}.sidebar-link i{width:20px;font-size:16px;flex:0 0 auto}.sidebar-link:hover{background:#1f2937;color:#fff}.sidebar-link.active{background:#2563eb;color:#fff;box-shadow:0 6px 16px rgba(37,99,235,.22)}
.sidebar-user{display:flex;align-items:center;gap:10px;padding:16px;border-top:1px solid rgba(255,255,255,.08);background:#0f172a}.avatar{width:38px;height:38px;border-radius:11px;background:#263449;display:grid;place-items:center;font-weight:800;flex:0 0 auto}.user-copy{min-width:0;flex:1}.user-copy strong,.user-copy small{display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.user-copy strong{font-size:12px}.user-copy small{font-size:10px;color:#94a3b8;margin-top:2px}.logout-form{display:flex}.logout-icon{appearance:none;background:transparent;border:0;cursor:pointer;color:#94a3b8;font-size:18px;padding:7px;text-decoration:none}.logout-icon:hover{color:#fff}
</style>
