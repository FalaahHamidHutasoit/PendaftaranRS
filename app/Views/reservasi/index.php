
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Dokter | Rumah Sakit Politeknik LP3I Jakarta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #087f8c;
            --primary-dark: #075c66;
            --primary-soft: #e6f6f6;
            --navy: #183447;
            --muted: #82919c;
            --background: #f5f8fa;
            --border: #e8eef1;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--navy);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        a {
            text-decoration: none;
        }

        .navbar-custom {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
        }

        .brand {
            color: var(--navy);
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -.8px;
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            margin-right: 8px;
            border-radius: 12px;
            color: #fff;
            background: var(--primary);
            font-size: 20px;
        }

        .nav-link-custom {
            color: #71818c;
            font-weight: 600;
            padding: 10px 14px;
            border-radius: 10px;
            transition: .2s;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .user-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #d9f0ed;
            color: var(--primary-dark);
            font-weight: 800;
        }

        .page-content {
            max-width: 1240px;
            margin: 0 auto;
            padding: 38px 24px 56px;
        }

        .eyebrow {
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 11px;
            font-weight: 800;
        }

        .page-title {
            font-size: clamp(27px, 3vw, 35px);
            font-weight: 800;
            letter-spacing: -1.2px;
            margin: 8px 0;
        }

        .page-subtitle {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .online-badge {
            background: #e5f7ee;
            color: #16845b;
            border-radius: 50px;
            padding: 9px 13px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .stat-card {
            height: 100%;
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: #fff;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(24, 52, 71, .06);
        }

        .stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 14px;
            font-size: 20px;
        }

        .icon-blue {
            background: #e9f2ff;
            color: #3677d8;
        }

        .icon-green {
            background: #e5f7ee;
            color: #16845b;
        }

        .icon-gray {
            background: #eef1f4;
            color: #687782;
        }

        .stat-label {
            margin-top: 19px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
        }

        .stat-number {
            font-size: 31px;
            line-height: 1.3;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .search-box,
        .filter-select {
            min-height: 44px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            color: var(--navy);
            font-size: 13px;
        }

        .search-box:focus,
        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(8, 127, 140, .10);
        }

        .doctor-card {
            height: 100%;
            padding: 22px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 19px;
            transition: .2s ease;
        }

        .doctor-card:hover {
            border-color: #b6dfe0;
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(24, 52, 71, .07);
        }

        .doctor-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            border-radius: 17px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 27px;
        }

        .doctor-name {
            margin: 0 0 5px;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.5;
        }

        .specialty {
            display: inline-block;
            border-radius: 8px;
            padding: 6px 9px;
            background: #f0f6f8;
            color: #56717e;
            font-size: 11px;
            font-weight: 700;
        }

        .card-divider {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid var(--border);
            opacity: 1;
        }

        .detail-row {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            margin-bottom: 15px;
        }

        .detail-icon {
            width: 19px;
            color: var(--primary);
            font-size: 16px;
            text-align: center;
        }

        .detail-label {
            margin-bottom: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .detail-value {
            color: var(--navy);
            font-size: 13px;
            font-weight: 700;
        }

        .quota-label {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .quota-label span:first-child {
            color: var(--muted);
        }

        .quota-label strong {
            color: var(--primary-dark);
        }

        .progress {
            height: 6px;
            border-radius: 20px;
            background: #edf1f3;
        }

        .progress-bar {
            border-radius: 20px;
            background: var(--primary);
        }

        .btn-book {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 11px;
            background: var(--primary);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-book:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        .btn-full {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 11px;
            background: #edf0f2;
            color: #7b8790;
            font-size: 13px;
            font-weight: 700;
            cursor: not-allowed;
        }

        .empty-state {
            padding: 55px 20px;
            border: 1px dashed #ccd9df;
            border-radius: 18px;
            background: #fff;
            text-align: center;
        }

        .empty-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 66px;
            height: 66px;
            margin-bottom: 18px;
            border-radius: 20px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 27px;
        }

        .footer {
            padding-top: 22px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 767px) {
            .page-content {
                padding: 27px 16px 40px;
            }

            .navbar-custom {
                padding: 12px 0;
            }

            .stat-card {
                padding: 17px;
            }

            .stat-number {
                font-size: 27px;
            }

            .doctor-card {
                padding: 19px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<?= view('pasien/_navbar', ['aktif' => 'jadwal']) ?>

<main class="page-content">

    <!-- HEADER -->
    <section class="mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="eyebrow">Layanan kesehatan digital</div>
                <h1 class="page-title">Temukan Dokter Terbaikmu</h1>
                <p class="page-subtitle mb-0">
                    Pilih jadwal praktik dokter dan rencanakan kunjungan
                    kesehatanmu dengan mudah.
                </p>
            </div>

            <span class="online-badge">
                <i class="bi bi-shield-check me-1"></i>
                Reservasi Online
            </span>
        </div>
    </section>

    <!-- FLASH MESSAGE -->
    <?php if (session()->getFlashdata('pesan_sukses')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= esc(session()->getFlashdata('pesan_sukses')) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('pesan_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <?= esc(session()->getFlashdata('pesan_error')) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- HITUNG STATISTIK -->
    <?php
        $totalJadwal = count($jadwal);
        $jadwalTersedia = 0;
        $jadwalPenuh = 0;

        foreach ($jadwal as $item) {
            $sisa = max(
                0,
                (int) $item['kuota'] - (int) $item['terisi']
            );

            if ($sisa > 0) {
                $jadwalTersedia++;
            } else {
                $jadwalPenuh++;
            }
        }
    ?>

    <!-- STATISTIK -->
    <section class="row g-3 mb-5">

        <div class="col-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <div class="stat-label">Total Jadwal</div>
                <div class="stat-number"><?= $totalJadwal ?></div>
                <div class="text-secondary small mt-1">
                    Jadwal terdaftar
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-label">Jadwal Tersedia</div>
                <div class="stat-number text-success"><?= $jadwalTersedia ?></div>
                <div class="text-secondary small mt-1">
                    Masih bisa dipilih
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon icon-gray">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <div class="stat-label">Jadwal Penuh</div>
                <div class="stat-number"><?= $jadwalPenuh ?></div>
                <div class="text-secondary small mt-1">
                    Kuota telah habis
                </div>
            </div>
        </div>

    </section>

    <!-- DAFTAR DOKTER -->
    <section>

        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
            <div>
                <h2 class="section-title mb-1">Jadwal Dokter</h2>
                <p class="text-secondary mb-0">
                    Pilih poli dan waktu yang sesuai untukmu.
                </p>
            </div>

            <div class="text-secondary small">
                <i class="bi bi-clock me-1"></i>
                Waktu praktik sesuai jadwal
            </div>
        </div>

        <!-- PENCARIAN DAN FILTER -->
        <div class="row g-3 mb-4">
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"
                          style="border-color: var(--border); border-radius: 12px 0 0 12px;">
                        <i class="bi bi-search text-secondary"></i>
                    </span>

                    <input
                        type="text"
                        id="searchDokter"
                        class="form-control search-box border-start-0"
                        style="border-radius: 0 12px 12px 0;"
                        placeholder="Cari nama dokter atau poli..."
                    >
                </div>
            </div>

            <div class="col-md-5">
                <select id="filterPoli" class="form-select filter-select">
                    <option value="">Semua Poli</option>

                    <?php
                        $daftarPoli = array_unique(
                            array_column($jadwal, 'nama_poli')
                        );
                        sort($daftarPoli);
                    ?>

                    <?php foreach ($daftarPoli as $namaPoli): ?>
                        <option value="<?= esc($namaPoli) ?>">
                            <?= esc($namaPoli) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if (empty($jadwal)): ?>

            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-calendar2-x"></i>
                </div>

                <h5 class="fw-bold">Belum Ada Jadwal Dokter</h5>

                <p class="text-secondary mb-0">
                    Belum ada jadwal praktik yang tersedia untuk tanggal
                    hari ini dan seterusnya.
                </p>
            </div>

        <?php else: ?>

            <div class="row g-4" id="daftarJadwal">

                <?php foreach ($jadwal as $item): ?>

                    <?php
                        $sisa = max(
                            0,
                            (int) $item['kuota'] - (int) $item['terisi']
                        );

                        $persentaseTerisi = (int) $item['kuota'] > 0
                            ? min(
                                100,
                                round(
                                    ((int) $item['terisi'] / (int) $item['kuota']) * 100
                                )
                            )
                            : 100;
                    ?>

                    <div
                        class="col-md-6 col-xl-4 jadwal-item"
                        data-nama="<?= esc(strtolower($item['nama_dokter']), 'attr') ?>"
                        data-poli="<?= esc($item['nama_poli'], 'attr') ?>"
                        data-search="<?= esc(strtolower($item['nama_dokter'] . ' ' . $item['nama_poli']), 'attr') ?>"
                    >

                        <article class="doctor-card">

                            <!-- IDENTITAS DOKTER -->
                            <div class="d-flex align-items-center gap-3">
                                <div class="doctor-avatar">
                                    <i class="bi bi-person-badge"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <h3 class="doctor-name">
                                        <?= esc($item['nama_dokter']) ?>
                                    </h3>

                                    <span class="specialty">
                                        <?= esc($item['nama_poli']) ?>
                                    </span>
                                </div>
                            </div>

                            <hr class="card-divider">

                            <!-- TANGGAL -->
                            <div class="detail-row">
                                <div class="detail-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>

                                <div>
                                    <div class="detail-label">
                                        Tanggal praktik
                                    </div>

                                    <div class="detail-value">
                                        <?= date(
                                            'd F Y',
                                            strtotime($item['tanggal'])
                                        ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- JAM -->
                            <div class="detail-row">
                                <div class="detail-icon">
                                    <i class="bi bi-clock"></i>
                                </div>

                                <div>
                                    <div class="detail-label">
                                        Jam praktik
                                    </div>

                                    <div class="detail-value">
                                        <?= esc(substr($item['jam_mulai'], 0, 5)) ?>
                                        –
                                        <?= esc(substr($item['jam_selesai'], 0, 5)) ?>
                                        WIB
                                    </div>
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="detail-row">
                                <div class="detail-icon">
                                    <i class="bi bi-people"></i>
                                </div>

                                <div>
                                    <div class="detail-label">
                                        Ketersediaan slot
                                    </div>

                                    <div class="detail-value">
                                        <?php if ($sisa > 0): ?>
                                            <span class="text-success">
                                                <?= $sisa ?> slot tersedia
                                            </span>
                                        <?php else: ?>
                                            <span class="text-danger">
                                                Kuota telah penuh
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- PROGRESS KUOTA -->
                            <div class="mt-4 mb-4">
                                <div class="quota-label">
                                    <span>Kuota terisi</span>

                                    <strong>
                                        <?= (int) $item['terisi'] ?>
                                        / <?= (int) $item['kuota'] ?> pasien
                                    </strong>
                                </div>

                                <div class="progress">
                                    <div
                                        class="progress-bar"
                                        role="progressbar"
                                        style="width: <?= $persentaseTerisi ?>%;"
                                        aria-valuenow="<?= $persentaseTerisi ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    ></div>
                                </div>
                            </div>

                            <!-- TOMBOL -->
                            <?php if ($sisa > 0): ?>

                                <a
                                    href="<?= base_url('reservasi/form/' . $item['id_jadwal']) ?>"
                                    class="btn btn-book"
                                >
                                    Pilih Jadwal
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>

                            <?php else: ?>

                                <button class="btn-full" disabled>
                                    <i class="bi bi-lock me-1"></i>
                                    Kuota Penuh
                                </button>

                            <?php endif; ?>

                        </article>

                    </div>

                <?php endforeach; ?>

            </div>

            <!-- HASIL PENCARIAN KOSONG -->
            <div id="hasilKosong" class="empty-state mt-3 d-none">
                <div class="empty-icon">
                    <i class="bi bi-search"></i>
                </div>

                <h5 class="fw-bold">Jadwal Tidak Ditemukan</h5>

                <p class="text-secondary mb-0">
                    Coba gunakan kata kunci lain atau pilih poli berbeda.
                </p>
            </div>

        <?php endif; ?>

    </section>

    <!-- FOOTER -->
    <footer class="footer mt-5 d-flex flex-wrap justify-content-between gap-2">
        <span>
            <i class="bi bi-heart-pulse me-1"></i>
            Rumah Sakit Politeknik LP3I Jakarta — Pendaftaran Pasien
        </span>

        <span>
            Layanan kesehatan yang lebih mudah dan teratur.
        </span>
    </footer>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const searchInput = document.getElementById('searchDokter');
    const filterPoli = document.getElementById('filterPoli');
    const jadwalItems = document.querySelectorAll('.jadwal-item');
    const hasilKosong = document.getElementById('hasilKosong');

    function filterJadwal() {
        const keyword = searchInput.value.toLowerCase().trim();
        const poliDipilih = filterPoli.value;
        let jumlahTampil = 0;

        jadwalItems.forEach(function(item) {
            const dataSearch = item.dataset.search || '';
            const dataPoli = item.dataset.poli || '';

            const cocokNama = dataSearch.includes(keyword);
            const cocokPoli = !poliDipilih || dataPoli === poliDipilih;
            const tampil = cocokNama && cocokPoli;

            item.classList.toggle('d-none', !tampil);

            if (tampil) {
                jumlahTampil++;
            }
        });

        if (hasilKosong) {
            hasilKosong.classList.toggle('d-none', jumlahTampil > 0);
        }
    }

    searchInput.addEventListener('input', filterJadwal);
    filterPoli.addEventListener('change', filterJadwal);
</script>

</body>
</html>
