
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Dokter - Rumah Sakit Politeknik LP3I Jakarta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #142b4a;
            --teal: #13a89e;
            --background: #f4f7fb;
            --text: #25364b;
            --muted: #8290a3;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        .app-wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: 250px;
            min-width: 250px;
            background: var(--navy);
            color: white;
            padding: 27px 18px;
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px;
            margin-bottom: 42px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 14px;
            background: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .brand-name { font-size: 20px; font-weight: 800; }
        .brand-caption { color: #aabbd0; font-size: 11px; margin-top: 2px; }
        .menu-label { color: #90a4bf; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; padding: 0 12px; margin-bottom: 12px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 7px; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            color: #c1ccda;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            transition: .2s;
        }

        .sidebar-link i { font-size: 18px; }
        .sidebar-link:hover { background: rgba(255,255,255,.08); color: white; }
        .sidebar-link.active { background: var(--teal); color: white; }
        .sidebar-bottom { margin-top: auto; padding-top: 30px; }

        .logout-link { color: #ffc5c5; }
        .logout-link:hover { color: white; background: rgba(220,53,69,.15); }

        .main-content { flex: 1; min-width: 0; padding: 30px 34px; }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 30px;
        }

        .breadcrumb-text { color: var(--muted); font-size: 12px; margin-bottom: 7px; }
        .page-title { font-size: 25px; font-weight: 800; letter-spacing: -.7px; margin: 0; }
        .page-subtitle { color: var(--muted); font-size: 13px; margin: 7px 0 0; }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 9px 13px;
            border: 1px solid #e9eef5;
            border-radius: 13px;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #dff6f3;
            color: #128c84;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }

        .profile-name { font-size: 12px; font-weight: 700; margin: 0; }
        .profile-role { color: var(--muted); font-size: 10px; margin: 3px 0 0; text-transform: capitalize; }

        .summary-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: linear-gradient(115deg, #183859, #176d79);
            border-radius: 17px;
            padding: 25px 27px;
            color: white;
            margin-bottom: 25px;
        }

        .summary-label { color: #b6e8e3; font-size: 11px; font-weight: 700; letter-spacing: 1px; }
        .summary-number { font-size: 32px; font-weight: 800; margin: 5px 0; }
        .summary-description { color: #d0e4ec; font-size: 12px; margin: 0; }
        .summary-icon { font-size: 46px; color: #b0e6df; padding: 0 10px; }

        .panel {
            background: white;
            border: 1px solid #edf1f6;
            border-radius: 15px;
            padding: 23px;
        }

        .section-title { font-size: 16px; font-weight: 800; margin: 0; }
        .section-description { color: var(--muted); font-size: 11px; margin: 5px 0 0; }

        .table { margin-top: 22px; font-size: 12px; }
        .table thead th {
            background: #f3f7fb;
            color: #74849a;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 700;
            padding: 15px 13px;
            border-bottom: 1px solid #e9eef5;
            white-space: nowrap;
        }

        .table tbody td { padding: 15px 13px; border-color: #f0f3f7; }
        .table tbody tr:hover td { background: #fbfdfd; }

        .doctor-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: #e0f7f3;
            color: #119b90;
            font-size: 18px;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .doctor-name { font-weight: 700; color: #263b55; }
        .specialty-badge {
            display: inline-block;
            background: #eaf1ff;
            color: #476dbe;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 700;
        }

        .poli-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e3f8f1;
            color: #19845e;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 700;
        }

        .number-badge {
            display: inline-flex;
            width: 28px;
            height: 28px;
            justify-content: center;
            align-items: center;
            border-radius: 9px;
            background: #f0f3f8;
            color: #62738a;
            font-weight: 700;
        }

        .empty-state { padding: 45px 15px !important; text-align: center; color: var(--muted); }
        .empty-state i { display: block; font-size: 35px; margin-bottom: 12px; color: #aab8c8; }
        .footer-text { text-align: center; color: #9aa6b5; font-size: 10px; margin-top: 25px; }

        @media (max-width: 991px) {
            .sidebar { width: 210px; min-width: 210px; }
            .main-content { padding: 25px 20px; }
        }

        @media (max-width: 767px) {
            .app-wrapper { display: block; }
            .sidebar { width: 100%; min-width: 0; padding: 16px; }
            .brand { margin-bottom: 20px; }
            .menu-label, .sidebar-bottom { display: none; }
            .sidebar-menu { flex-direction: row; flex-wrap: wrap; gap: 7px; }
            .sidebar-link { flex: 1 1 135px; padding: 10px; font-size: 11px; }
            .main-content { padding: 22px 15px; }
            .topbar { align-items: flex-start; }
            .page-title { font-size: 22px; }
            .profile-area { padding: 7px; }
            .profile-name, .profile-role { display: none; }
            .summary-card { padding: 22px 18px; }
            .summary-icon { font-size: 35px; }
            .panel { padding: 16px; }
        }
    </style>
</head>

<body>
<div class="app-wrapper">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <div>
                <div class="brand-name">RS LP3I Jakarta</div>
                <div class="brand-caption">Patient Registration System</div>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="sidebar-menu">
            <a href="<?= base_url('dashboard') ?>" class="sidebar-link">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="<?= base_url('dokter') ?>" class="sidebar-link active">
                <i class="bi bi-person-badge"></i> Data Dokter
            </a>
            <a href="<?= base_url('poli') ?>" class="sidebar-link">
                <i class="bi bi-hospital"></i> Data Poli
            </a>
            <a href="<?= base_url('jadwal') ?>" class="sidebar-link">
                <i class="bi bi-calendar2-week"></i> Jadwal Dokter
            </a>
            <a href="<?= base_url('admin/pasien') ?>" class="sidebar-link">
                <i class="bi bi-people"></i> Data Pasien &amp; BPJS
            </a>
            <a href="<?= base_url('admin/reservasi') ?>" class="sidebar-link">
                <i class="bi bi-clipboard2-check"></i> Reservasi
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form method="post" action="<?= base_url('logout') ?>" class="d-inline m-0" onsubmit="return confirm('Yakin ingin logout?')"><?= csrf_field() ?><button type="submit" class="sidebar-link logout-link" style="font:inherit;cursor:pointer;width:100%;text-align:left;background:none;border:0"><i class="bi bi-box-arrow-left"></i> Keluar dari Sistem</button></form>
        </div>
    </aside>

    <main class="main-content">

        <header class="topbar">
            <div>
                <div class="breadcrumb-text">Rumah Sakit Politeknik LP3I Jakarta / Data Dokter</div>
                <h1 class="page-title">Data Dokter</h1>
                <p class="page-subtitle">
                    Informasi dokter dan poli tempat praktik.
                </p>
            </div>

            <div class="profile-area">
                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <p class="profile-name">
                        <?= esc(session()->get('nama') ?? 'Pengguna') ?>
                    </p>
                    <p class="profile-role">
                        <?= esc(session()->get('role') ?? 'Pengguna') ?>
                    </p>
                </div>
            </div>
        </header>

        <?= view('admin/_flash') ?>

        <section class="summary-card">
            <div>
                <div class="summary-label">
                    <i class="bi bi-activity me-1"></i>
                    DIREKTORI TENAGA MEDIS
                </div>

                <div class="summary-number">
                    <?= count($dokter) ?>
                </div>

                <p class="summary-description">
                    Total dokter yang tercatat dalam sistem.
                </p>
            </div>

            <i class="bi bi-person-vcard summary-icon"></i>
        </section>

        <section class="panel">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="section-title">Daftar Dokter</h2>
                    <p class="section-description">
                        Data dokter beserta spesialisasi dan poli.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/dokter/tambah') ?>"
                       class="btn btn-sm btn-success rounded-3">
                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Dokter
                    </a>
                    <a href="<?= base_url('dashboard') ?>"
                       class="btn btn-sm btn-outline-secondary rounded-3">
                        <i class="bi bi-arrow-left me-1"></i>
                        Dashboard
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Dokter</th>
                            <th>Spesialisasi</th>
                            <th>Poli Praktik</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($dokter)): ?>
                            <?php foreach ($dokter as $i => $d): ?>
                                <tr>
                                    <td>
                                        <span class="number-badge">
                                            <?= $i + 1 ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="doctor-avatar">
                                                <i class="bi bi-person-fill"></i>
                                            </span>
                                            <span class="doctor-name">
                                                <?= esc($d['nama_dokter']) ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="specialty-badge">
                                            <?= esc($d['spesialisasi']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="poli-badge">
                                            <i class="bi bi-hospital"></i>
                                            <?= esc($d['nama_poli']) ?>
                                        </span>
                                    </td>

                                    <td class="text-end text-nowrap">
                                        <a href="<?= base_url('admin/dokter/edit/' . (int) $d['id_dokter']) ?>"
                                           class="btn btn-sm btn-outline-primary rounded-3">
                                            <i class="bi bi-pencil-square"></i> Ubah
                                        </a>
                                        <form method="post"
                                              action="<?= base_url('admin/dokter/hapus/' . (int) $d['id_dokter']) ?>"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus data ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="bi bi-person-x"></i>
                                    <strong>Belum ada data dokter</strong>
                                    <div class="mt-2">
                                        Data dokter belum tersedia di database.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="footer-text">
            Rumah Sakit Politeknik LP3I Jakarta &copy; <?= date('Y') ?> · Sistem Informasi Pendaftaran Pasien
        </footer>

    </main>
</div>
</body>
</html>
