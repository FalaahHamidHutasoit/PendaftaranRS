
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Rumah Sakit Politeknik LP3I Jakarta</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy: #142b4a;
            --navy-light: #203c60;
            --teal: #13a89e;
            --background: #f4f7fb;
            --text: #25364b;
            --muted: #8290a3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
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

        .brand-name {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-caption {
            color: #aabbd0;
            font-size: 11px;
            margin-top: 2px;
        }

        .menu-label {
            color: #90a4bf;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            padding: 0 12px;
            margin-bottom: 12px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

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

        .sidebar-link i {
            font-size: 18px;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, .08);
            color: white;
        }

        .sidebar-link.active {
            background: var(--teal);
            color: white;
            box-shadow: 0 6px 16px rgba(19, 168, 158, .2);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 30px;
        }

        .help-card {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .09);
            border-radius: 13px;
            padding: 16px;
            margin-bottom: 18px;
        }

        .help-card i {
            font-size: 21px;
            color: #54d4c8;
        }

        .help-card p {
            color: #b5c4d6;
            font-size: 11px;
            line-height: 1.7;
            margin: 9px 0 0;
        }

        .logout-link {
            color: #ffc5c5;
        }

        .logout-link:hover {
            color: #fff;
            background: rgba(220, 53, 69, .15);
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 30px 34px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 34px;
        }

        .breadcrumb-text {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 7px;
        }

        .page-title {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.7px;
            margin: 0;
        }

        .page-subtitle {
            color: var(--muted);
            font-size: 13px;
            margin: 7px 0 0;
        }

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

        .profile-name {
            font-size: 12px;
            font-weight: 700;
            margin: 0;
        }

        .profile-role {
            color: var(--muted);
            font-size: 10px;
            margin: 3px 0 0;
            text-transform: capitalize;
        }

        /* WELCOME BANNER */
        .welcome-banner {
            position: relative;
            overflow: hidden;
            background: linear-gradient(115deg, #183859, #176d79);
            border-radius: 19px;
            padding: 29px 30px;
            color: white;
            margin-bottom: 28px;
        }

        .welcome-banner::after {
            content: "";
            position: absolute;
            width: 210px;
            height: 210px;
            border: 35px solid rgba(255, 255, 255, .06);
            border-radius: 50%;
            right: 45px;
            top: -95px;
        }

        .welcome-banner::before {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border: 25px solid rgba(255, 255, 255, .05);
            border-radius: 50%;
            right: -15px;
            bottom: -75px;
        }

        .welcome-label {
            color: #a9e6df;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            margin-bottom: 10px;
        }

        .welcome-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 9px;
            position: relative;
            z-index: 1;
        }

        .welcome-description {
            color: #d0e4ec;
            font-size: 12px;
            margin: 0;
            max-width: 540px;
            line-height: 1.8;
            position: relative;
            z-index: 1;
        }

        .welcome-date {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 11px;
            position: relative;
            z-index: 1;
        }

        /* SECTION */
        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 17px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 800;
            margin: 0;
        }

        .section-description {
            color: var(--muted);
            font-size: 11px;
            margin: 5px 0 0;
        }

        .section-tag {
            color: #718198;
            font-size: 11px;
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 8px;
            padding: 8px 11px;
        }

        /* STAT CARDS */
        .stat-card {
            height: 100%;
            background: white;
            border: 1px solid #edf1f6;
            border-radius: 15px;
            padding: 20px;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(26, 51, 82, .06);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .icon-teal {
            background: #e0f7f3;
            color: #119b90;
        }

        .icon-blue {
            background: #e7efff;
            color: #4c75d9;
        }

        .icon-purple {
            background: #f0e9ff;
            color: #8b65d5;
        }

        .icon-orange {
            background: #fff0df;
            color: #e59a39;
        }

        .icon-pink {
            background: #ffe8ef;
            color: #df6589;
        }

        .stat-type {
            color: #a0acbb;
            font-size: 10px;
        }

        .stat-label {
            color: #7f8ca0;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -.8px;
            line-height: 1.2;
            margin: 0;
            color: #203550;
        }

        .stat-footer {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #94a0b0;
            font-size: 10px;
            margin-top: 13px;
        }

        .stat-footer i {
            color: var(--teal);
            font-size: 13px;
        }

        /* LOWER PANELS */
        .content-panel {
            background: white;
            border: 1px solid #edf1f6;
            border-radius: 15px;
            padding: 23px;
            height: 100%;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px 0;
            text-decoration: none;
            border-bottom: 1px solid #f0f3f7;
        }

        .quick-link:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .quick-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: #e4f7f4;
            color: #129b91;
            font-size: 19px;
            flex-shrink: 0;
        }

        .quick-link:nth-of-type(2) .quick-icon {
            background: #e9efff;
            color: #4c75d9;
        }

        .quick-link:nth-of-type(3) .quick-icon {
            background: #fff0df;
            color: #d99032;
        }

        .quick-link:nth-of-type(4) .quick-icon {
            background: #f0e9ff;
            color: #8b65d5;
        }

        .quick-title {
            color: var(--text);
            font-size: 12px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .quick-description {
            color: var(--muted);
            font-size: 10px;
            margin: 0;
        }

        .quick-arrow {
            color: #a4afbe;
            margin-left: auto;
        }

        .system-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f3f7;
        }

        .system-row:last-child {
            border-bottom: none;
        }

        .system-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: #65758b;
        }

        .system-label i {
            color: #8a9bb0;
            font-size: 16px;
        }

        .system-value {
            font-size: 12px;
            font-weight: 800;
            color: #263b55;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e4f8ef;
            color: #18885b;
            border-radius: 20px;
            padding: 6px 9px;
            font-size: 10px;
            font-weight: 700;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background: #24b47e;
            border-radius: 50%;
        }

        .footer-text {
            text-align: center;
            color: #9aa6b5;
            font-size: 10px;
            margin-top: 30px;
        }

        @media (max-width: 991px) {
            .sidebar {
                width: 210px;
                min-width: 210px;
            }

            .main-content {
                padding: 25px 20px;
            }

            .stat-card {
                padding: 17px;
            }

            .stat-number {
                font-size: 25px;
            }
        }

        @media (max-width: 767px) {
            .app-wrapper {
                display: block;
            }

            .sidebar {
                width: 100%;
                min-width: 0;
                padding: 16px;
            }

            .brand {
                margin-bottom: 20px;
            }

            .menu-label,
            .sidebar-bottom,
            .help-card {
                display: none;
            }

            .sidebar-menu {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 7px;
            }

            .sidebar-link {
                flex: 1 1 135px;
                padding: 10px;
                font-size: 11px;
            }

            .main-content {
                padding: 22px 15px;
            }

            .topbar {
                align-items: flex-start;
                margin-bottom: 24px;
            }

            .page-title {
                font-size: 22px;
            }

            .profile-area {
                padding: 7px;
            }

            .profile-name,
            .profile-role {
                display: none;
            }

            .welcome-banner {
                padding: 23px 20px;
            }

            .welcome-title {
                font-size: 21px;
            }

            .welcome-banner::after {
                right: -100px;
            }
        }
    </style>
</head>

<body>
<div class="app-wrapper">

    <!-- SIDEBAR -->
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
            <a href="<?= base_url('dashboard') ?>"
               class="sidebar-link active">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>

            <a href="<?= base_url('dokter') ?>"
               class="sidebar-link">
                <i class="bi bi-person-badge"></i>
                Data Dokter
            </a>

            <a href="<?= base_url('poli') ?>"
               class="sidebar-link">
                <i class="bi bi-hospital"></i>
                Data Poli
            </a>

            <a href="<?= base_url('jadwal') ?>"
               class="sidebar-link">
                <i class="bi bi-calendar2-week"></i>
                Jadwal Dokter
            </a>

            <a href="<?= base_url('admin/pasien') ?>" class="sidebar-link">

                <i class="bi bi-people"></i> Data Pasien &amp; BPJS

            </a>

            <a href="<?= base_url('admin/reservasi') ?>"
               class="sidebar-link">
                <i class="bi bi-clipboard2-check"></i>
                Reservasi
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="help-card">
                <i class="bi bi-shield-check"></i>
                <p>
                    Kelola informasi pendaftaran dan jadwal
                    layanan rumah sakit melalui satu dashboard.
                </p>
            </div>

            <form method="post" action="<?= base_url('logout') ?>" class="d-inline m-0" onsubmit="return confirm('Yakin ingin logout?')"><?= csrf_field() ?><button type="submit" class="sidebar-link logout-link" style="font:inherit;cursor:pointer;width:100%;text-align:left;background:none;border:0"><i class="bi bi-box-arrow-left"></i>
                Keluar dari Sistem</button></form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="topbar">
            <div>
                <div class="breadcrumb-text">
                    Rumah Sakit Politeknik LP3I Jakarta <span class="mx-1">/</span> Dashboard
                </div>

                <h1 class="page-title">Dashboard Overview</h1>

                <p class="page-subtitle">
                    Pantau data dan aktivitas pendaftaran rumah sakit.
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

        <!-- WELCOME BANNER -->
        <section class="welcome-banner">
            <div class="welcome-label">
                <i class="bi bi-stars me-1"></i>
                PUSAT INFORMASI
            </div>

            <h2 class="welcome-title">
                Halo, <?= esc(session()->get('nama') ?? 'Pengguna') ?>!
            </h2>

            <p class="welcome-description">
                Selamat datang di dashboard Rumah Sakit Politeknik LP3I Jakarta.
                Kelola data dokter, poli, jadwal, dan reservasi
                pasien dengan lebih mudah melalui satu sistem.
            </p>

            <div class="welcome-date">
                <i class="bi bi-calendar3"></i>
                <?= date('d-m-Y') ?>
            </div>
        </section>

        <!-- STATISTICS -->
        <section class="mb-4">
            <div class="section-heading">
                <div>
                    <h2 class="section-title">Ringkasan Data</h2>
                    <p class="section-description">
                        Informasi keseluruhan data yang tersimpan.
                    </p>
                </div>

                <span class="section-tag">
                    <i class="bi bi-bar-chart-line me-1"></i>
                    Statistik Sistem
                </span>
            </div>

            <div class="row g-3">

                <!-- TOTAL PASIEN -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon icon-teal">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <span class="stat-type">PASIEN</span>
                        </div>

                        <div class="stat-label">Total Pasien</div>

                        <h3 class="stat-number">
                            <?= esc($totalPasien) ?>
                        </h3>

                        <div class="stat-footer">
                            <i class="bi bi-database-check"></i>
                            Data pasien terdaftar
                        </div>
                    </div>
                </div>

                <!-- TOTAL DOKTER -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon icon-blue">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                            <span class="stat-type">TENAGA MEDIS</span>
                        </div>

                        <div class="stat-label">Total Dokter</div>

                        <h3 class="stat-number">
                            <?= esc($totalDokter) ?>
                        </h3>

                        <div class="stat-footer">
                            <i class="bi bi-database-check"></i>
                            Data dokter tersimpan
                        </div>
                    </div>
                </div>

                <!-- TOTAL POLI -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon icon-purple">
                                <i class="bi bi-hospital-fill"></i>
                            </div>
                            <span class="stat-type">LAYANAN</span>
                        </div>

                        <div class="stat-label">Total Poli</div>

                        <h3 class="stat-number">
                            <?= esc($totalPoli) ?>
                        </h3>

                        <div class="stat-footer">
                            <i class="bi bi-database-check"></i>
                            Poli yang tersedia
                        </div>
                    </div>
                </div>

                <!-- TOTAL JADWAL -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon icon-orange">
                                <i class="bi bi-calendar2-week-fill"></i>
                            </div>
                            <span class="stat-type">JADWAL</span>
                        </div>

                        <div class="stat-label">Jadwal Dokter</div>

                        <h3 class="stat-number">
                            <?= esc($totalJadwal) ?>
                        </h3>

                        <div class="stat-footer">
                            <i class="bi bi-database-check"></i>
                            Jadwal tersimpan
                        </div>
                    </div>
                </div>

                <!-- TOTAL RESERVASI -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-icon icon-pink">
                                <i class="bi bi-clipboard2-check-fill"></i>
                            </div>
                            <span class="stat-type">PENDAFTARAN</span>
                        </div>

                        <div class="stat-label">Total Reservasi</div>

                        <h3 class="stat-number">
                            <?= esc($totalReservasi) ?>
                        </h3>

                        <div class="stat-footer">
                            <i class="bi bi-database-check"></i>
                            Data reservasi tersimpan
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- QUICK ACCESS AND SYSTEM SUMMARY -->
        <section>
            <div class="row g-3">

                <!-- QUICK ACCESS -->
                <div class="col-12 col-lg-7">
                    <div class="content-panel">
                        <div class="section-heading">
                            <div>
                                <h2 class="section-title">Akses Cepat</h2>
                                <p class="section-description">
                                    Buka halaman pengelolaan data.
                                </p>
                            </div>

                            <i class="bi bi-arrow-up-right-circle text-secondary fs-5"></i>
                        </div>

                        <a href="<?= base_url('dokter') ?>" class="quick-link">
                            <div class="quick-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>

                            <div>
                                <p class="quick-title">Data Dokter</p>
                                <p class="quick-description">
                                    Lihat daftar dokter dan spesialisasi.
                                </p>
                            </div>

                            <i class="bi bi-chevron-right quick-arrow"></i>
                        </a>

                        <a href="<?= base_url('poli') ?>" class="quick-link">
                            <div class="quick-icon">
                                <i class="bi bi-hospital"></i>
                            </div>

                            <div>
                                <p class="quick-title">Data Poli</p>
                                <p class="quick-description">
                                    Lihat daftar poli rumah sakit.
                                </p>
                            </div>

                            <i class="bi bi-chevron-right quick-arrow"></i>
                        </a>

                        <a href="<?= base_url('jadwal') ?>" class="quick-link">
                            <div class="quick-icon">
                                <i class="bi bi-calendar2-week"></i>
                            </div>

                            <div>
                                <p class="quick-title">Jadwal Dokter</p>
                                <p class="quick-description">
                                    Periksa jadwal praktik dokter.
                                </p>
                            </div>

                            <i class="bi bi-chevron-right quick-arrow"></i>
                        </a>

                        <a href="<?= base_url('admin/reservasi') ?>" class="quick-link">
                            <div class="quick-icon">
                                <i class="bi bi-clipboard2-check"></i>
                            </div>

                            <div>
                                <p class="quick-title">Reservasi Pasien</p>
                                <p class="quick-description">
                                    Buka halaman reservasi pasien.
                                </p>
                            </div>

                            <i class="bi bi-chevron-right quick-arrow"></i>
                        </a>
                    </div>
                </div>

                <!-- SYSTEM SUMMARY -->
                <div class="col-12 col-lg-5">
                    <div class="content-panel">
                        <div class="section-heading">
                            <div>
                                <h2 class="section-title">Informasi Sistem</h2>
                                <p class="section-description">
                                    Ringkasan data saat ini.
                                </p>
                            </div>
                        </div>

                        <div class="system-row">
                            <div class="system-label">
                                <i class="bi bi-people"></i>
                                Data Pasien
                            </div>

                            <span class="system-value">
                                <?= esc($totalPasien) ?>
                            </span>
                        </div>

                        <div class="system-row">
                            <div class="system-label">
                                <i class="bi bi-person-vcard"></i>
                                Tenaga Medis
                            </div>

                            <span class="system-value">
                                <?= esc($totalDokter) ?>
                            </span>
                        </div>

                        <div class="system-row">
                            <div class="system-label">
                                <i class="bi bi-hospital"></i>
                                Layanan Poli
                            </div>

                            <span class="system-value">
                                <?= esc($totalPoli) ?>
                            </span>
                        </div>

                        <div class="system-row">
                            <div class="system-label">
                                <i class="bi bi-calendar-check"></i>
                                Jadwal Tersimpan
                            </div>

                            <span class="system-value">
                                <?= esc($totalJadwal) ?>
                            </span>
                        </div>

                        <div class="system-row">
                            <div class="system-label">
                                <i class="bi bi-clipboard-check"></i>
                                Reservasi Tersimpan
                            </div>

                            <span class="system-value">
                                <?= esc($totalReservasi) ?>
                            </span>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-info-circle text-success"></i>
                                <span class="fw-bold" style="font-size: 12px;">
                                    Tentang dashboard
                                </span>
                            </div>

                            <p class="text-secondary mb-0"
                               style="font-size: 11px; line-height: 1.8;">
                                Angka di halaman ini diambil dari database
                                melalui controller Dashboard. Data akan
                                mengikuti perubahan yang tersimpan di sistem.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <footer class="footer-text">
            Rumah Sakit Politeknik LP3I Jakarta &copy; <?= date('Y') ?> · Sistem Informasi Pendaftaran Pasien
        </footer>

    </main>
</div>
</body>
</html>
