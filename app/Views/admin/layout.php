<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($judulHalaman ?? 'Admin') ?> - Rumah Sakit Politeknik LP3I Jakarta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --navy:#142b4a; --teal:#13a89e; --background:#f4f7fb; --text:#25364b; --muted:#8290a3; }
        body { margin:0; background:var(--background); color:var(--text); font-family:'DM Sans',sans-serif; }
        .shell { display:flex; min-height:100vh; }
        .side { width:250px; background:var(--navy); color:#fff; padding:24px 16px; display:flex; flex-direction:column; position:sticky; top:0; height:100vh; }
        .side .brand { font-weight:800; font-size:20px; margin-bottom:28px; padding:0 8px; }
        .side a, .side button { display:flex; gap:10px; align-items:center; color:#c9d4e3; text-decoration:none; padding:11px 12px; border-radius:10px; margin-bottom:4px; font-weight:600; font-size:14px; }
        .side button { width:100%; background:none; border:0; text-align:left; font-family:inherit; cursor:pointer; }
        .side a:hover, .side button:hover, .side a.active { background:rgba(255,255,255,.1); color:#fff; }
        .side a.active { box-shadow: inset 3px 0 0 var(--teal); }
        .side .bottom { margin-top:auto; }
        .main { flex:1; padding:32px; min-width:0; }
        .panel { background:#fff; border-radius:18px; padding:24px; box-shadow:0 8px 28px rgba(20,43,74,.05); }
        h1.title { font-size:26px; font-weight:800; margin:0 0 4px; }
        .form-control, .form-select { border-radius:11px; min-height:44px; }
        .btn-teal { background:var(--teal); color:#fff; border:0; border-radius:11px; font-weight:700; padding:10px 18px; }
        .btn-teal:hover { background:#0f8d85; color:#fff; }
        .muted { color:var(--muted); }
        .badge-st { padding:6px 11px; border-radius:20px; font-size:12px; font-weight:800; text-transform:capitalize; }
        .st-menunggu{background:#fff7df;color:#9a6700}.st-dikonfirmasi{background:#e0f2fe;color:#075985}
        .st-selesai{background:#dcfce7;color:#166534}.st-dibatalkan{background:#fee2e2;color:#991b1b}
        @media (max-width: 860px) { .shell{flex-direction:column} .side{width:100%;height:auto;position:static} .main{padding:18px} }
    </style>
</head>
<body>
<div class="shell">
    <aside class="side">
        <div class="brand"><i class="bi bi-heart-pulse-fill me-2"></i>RS LP3I Jakarta</div>
        <?php $a = $active ?? ''; ?>
        <a href="<?= base_url('dashboard') ?>" class="<?= $a === 'dashboard' ? 'active' : '' ?>"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="<?= base_url('dokter') ?>" class="<?= $a === 'dokter' ? 'active' : '' ?>"><i class="bi bi-person-badge"></i> Data Dokter</a>
        <a href="<?= base_url('poli') ?>" class="<?= $a === 'poli' ? 'active' : '' ?>"><i class="bi bi-hospital"></i> Data Poli</a>
        <a href="<?= base_url('jadwal') ?>" class="<?= $a === 'jadwal' ? 'active' : '' ?>"><i class="bi bi-calendar2-week"></i> Jadwal Dokter</a>
        <a href="<?= base_url('admin/pasien') ?>" class="<?= $a === 'pasien' ? 'active' : '' ?>"><i class="bi bi-people"></i> Data Pasien &amp; BPJS</a>
        <a href="<?= base_url('admin/reservasi') ?>" class="<?= $a === 'reservasi' ? 'active' : '' ?>"><i class="bi bi-clipboard2-check"></i> Kelola Reservasi</a>
        <div class="bottom">
            <form method="post" action="<?= base_url('logout') ?>" class="d-inline m-0" onsubmit="return confirm('Yakin ingin logout?')"><?= csrf_field() ?><button type="submit" class="" style="font:inherit;cursor:pointer"><i class="bi bi-box-arrow-left"></i> Keluar dari Sistem</button></form>
        </div>
    </aside>
    <main class="main">
        <?= view('admin/_flash') ?>
        <?= $this->renderSection('content') ?>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
