<?php
/** Navbar bersama untuk semua halaman pasien. Pakai: view('pasien/_navbar', ['aktif' => 'jadwal|riwayat|profil']) */
$aktif = $aktif ?? '';
$nama  = session()->get('nama') ?? 'Pasien';
$menu  = [
    'jadwal'  => ['reservasi', 'bi-calendar2-check', 'Jadwal Dokter'],
    'riwayat' => ['riwayat-reservasi', 'bi-clock-history', 'Riwayat'],
    'profil'  => ['profil', 'bi-person-vcard', 'Profil'],
];
?>
<style>
    .pn { position: sticky; top: 0; z-index: 1030; background: #fff; border-bottom: 1px solid #e8eef1; font-family: 'DM Sans', sans-serif; font-size: 14px; }
    .pn-in { max-width: 1140px; margin: 0 auto; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; }
    .pn-brand { display: flex; align-items: center; gap: 10px; color: #183447; font-weight: 800; font-size: 20px; text-decoration: none; }
    .pn-brand span { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 12px; background: #087f8c; color: #fff; font-size: 19px; }
    .pn-links { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .pn-link { display: inline-flex; align-items: center; gap: 6px; padding: 9px 14px; border-radius: 10px; color: #5b6b78; font-weight: 600; text-decoration: none; }
    .pn-link:hover { background: #f1f6f7; color: #183447; }
    .pn-link.active { background: #e6f6f6; color: #087f8c; }
    .pn-user { display: flex; align-items: center; gap: 10px; }
    .pn-avatar { width: 36px; height: 36px; border-radius: 50%; background: #087f8c; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; }
    .pn-name { font-weight: 700; font-size: 13px; line-height: 1.2; color: #183447; }
    .pn-role { font-size: 11px; color: #82919c; }
    .pn-out { border: 1px solid #f2c4c4; background: #fff; color: #c0392b; border-radius: 10px; padding: 8px 12px; font: inherit; font-weight: 600; cursor: pointer; }
    .pn-out:hover { background: #fdf0f0; }
    @media (max-width: 767px) { .pn-links { order: 3; width: 100%; } .pn-link { flex: 1; justify-content: center; padding: 9px 6px; } .pn-user .pn-meta { display: none; } }
</style>
<nav class="pn">
    <div class="pn-in">
        <a href="<?= base_url('reservasi') ?>" class="pn-brand"><span><i class="bi bi-heart-pulse-fill"></i></span>RS LP3I Jakarta</a>

        <div class="pn-links">
            <?php foreach ($menu as $k => [$url, $icon, $label]): ?>
                <a href="<?= base_url($url) ?>" class="pn-link <?= $aktif === $k ? 'active' : '' ?>">
                    <i class="bi <?= $icon ?>"></i> <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="pn-user">
            <div class="pn-avatar"><?= esc(strtoupper(mb_substr($nama, 0, 1))) ?></div>
            <div class="pn-meta">
                <div class="pn-name"><?= esc($nama) ?></div>
                <div class="pn-role">Pasien</div>
            </div>
            <form method="post" action="<?= base_url('logout') ?>" class="m-0"
                  onsubmit="return confirm('Yakin ingin logout?')">
                <?= csrf_field() ?>
                <button type="submit" class="pn-out" title="Keluar"><i class="bi bi-box-arrow-right"></i> Keluar</button>
            </form>
        </div>
    </div>
</nav>
