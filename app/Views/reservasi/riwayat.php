
<?php
function formatTanggalRiwayat($tanggal)
{
    return date('d M Y', strtotime($tanggal));
}

function formatJamRiwayat($jam)
{
    return date('H.i', strtotime($jam));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Reservasi | Rumah Sakit Politeknik LP3I Jakarta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #102a43;
            --teal: #0d9488;
            --muted: #64748b;
            --border: #e7edf3;
            --surface: #f5f8fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--surface);
            color: var(--navy);
            font-family: 'DM Sans', sans-serif;
        }

        .navbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            color: var(--navy);
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-icon {
            display: inline-flex;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            border-radius: 12px;
            background: #dff8f3;
            color: var(--teal);
        }

        .nav-link {
            color: #64748b;
            font-weight: 600;
            margin-right: 8px;
        }

        .nav-link.active,
        .nav-link:hover {
            color: var(--teal);
        }

        .page-container {
            max-width: 1150px;
            margin: 0 auto;
            padding: 38px 20px 60px;
        }

        .page-heading {
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--teal);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .page-heading h1 {
            margin: 8px 0;
            font-size: clamp(27px, 4vw, 36px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .page-heading p {
            margin: 0;
            color: var(--muted);
        }

        .summary-card,
        .history-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(16, 42, 67, .035);
        }

        .summary-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            height: 100%;
        }

        .summary-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 14px;
            background: #e0f7f3;
            color: var(--teal);
            font-size: 22px;
        }

        .summary-label {
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
        }

        .summary-value {
            margin-top: 3px;
            font-size: 25px;
            font-weight: 800;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 32px 0 16px;
        }

        .section-heading h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
        }

        .history-card {
            padding: 24px;
            margin-bottom: 18px;
        }

        .doctor-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            border-radius: 16px;
            background: #e4f5f3;
            color: var(--teal);
            font-size: 25px;
        }

        .doctor-name {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .doctor-poli {
            color: var(--teal);
            font-size: 13px;
            font-weight: 700;
        }

        .queue-box {
            min-width: 105px;
            padding: 12px 16px;
            border: 1px dashed #a5dcd4;
            border-radius: 14px;
            background: #f0fdfa;
            text-align: center;
        }

        .queue-label {
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .queue-number {
            color: var(--teal);
            font-size: 28px;
            font-weight: 800;
            line-height: 1.2;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .info-item {
            display: flex;
            gap: 10px;
            min-width: 0;
        }

        .info-item i {
            color: var(--teal);
            font-size: 18px;
        }

        .info-label {
            color: var(--muted);
            font-size: 12px;
        }

        .info-value {
            margin-top: 3px;
            font-size: 14px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .complaint {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #f8fafc;
        }

        .complaint-label {
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
        }

        .complaint-text {
            font-size: 14px;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            text-transform: capitalize;
        }

        .status-menunggu {
            background: #fff7df;
            color: #9a6700;
        }

        .status-dikonfirmasi {
            background: #e0f2fe;
            color: #075985;
        }

        .status-selesai {
            background: #dcfce7;
            color: #166534;
        }

        .status-dibatalkan {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            padding: 55px 20px;
            text-align: center;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
        }

        .empty-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 76px;
            height: 76px;
            margin-bottom: 18px;
            border-radius: 24px;
            background: #e0f7f3;
            color: var(--teal);
            font-size: 34px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 800;
        }

        .empty-state p {
            color: var(--muted);
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 17px;
            border: 0;
            border-radius: 11px;
            background: var(--teal);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            background: #0f766e;
            color: #fff;
        }

        .btn-outline-custom {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            color: var(--navy);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-outline-custom:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--navy);
            font-size: 13px;
            font-weight: 700;
        }

        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e0f7f3;
            color: var(--teal);
        }

        @media (max-width: 576px) {
            .page-container {
                padding: 28px 14px 40px;
            }

            .history-card {
                padding: 18px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .queue-box {
                min-width: 80px;
                padding: 10px;
            }

            .queue-number {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<?= view('pasien/_navbar', ['aktif' => 'riwayat']) ?>

<main class="page-container">

    <?= view('admin/_flash') ?>


    <div class="page-heading">
        <div class="eyebrow">Layanan Pasien</div>
        <h1>Riwayat Reservasi</h1>
        <p>Pantau jadwal kunjungan, nomor antrean, dan status pendaftaranmu.</p>
    </div>

    <?php
    $totalRiwayat = count($riwayat);
    $totalMenunggu = 0;
    $totalSelesai = 0;

    foreach ($riwayat as $item) {
        if ($item['status'] === 'menunggu' || $item['status'] === 'dikonfirmasi') {
            $totalMenunggu++;
        }

        if ($item['status'] === 'selesai') {
            $totalSelesai++;
        }
    }
    ?>

    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-journal-medical"></i></div>
                <div>
                    <div class="summary-label">Total Reservasi</div>
                    <div class="summary-value"><?= $totalRiwayat ?></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-clock-history"></i></div>
                <div>
                    <div class="summary-label">Menunggu / Dikonfirmasi</div>
                    <div class="summary-value"><?= $totalMenunggu ?></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-check-circle"></i></div>
                <div>
                    <div class="summary-label">Selesai</div>
                    <div class="summary-value"><?= $totalSelesai ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-heading">
        <h2>Daftar Kunjungan</h2>
        <a class="btn-outline-custom" href="<?= base_url('reservasi') ?>">
            <i class="bi bi-plus-lg"></i> Buat Reservasi
        </a>
    </div>

    <?php if (empty($riwayat)): ?>

        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-calendar2-x"></i></div>
            <h3>Belum Ada Reservasi</h3>
            <p>Kamu belum memiliki riwayat pendaftaran dokter.</p>
            <a class="btn-primary-custom" href="<?= base_url('reservasi') ?>">
                <i class="bi bi-search"></i> Cari Jadwal Dokter
            </a>
        </div>

    <?php else: ?>

        <?php foreach ($riwayat as $item): ?>
            <?php
            $status = strtolower($item['status'] ?? 'menunggu');
            $statusClass = in_array(
                $status,
                ['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'],
                true
            ) ? 'status-' . $status : 'status-menunggu';
            ?>

            <article class="history-card">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="doctor-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div>
                            <div class="doctor-name">
                                <?= esc($item['nama_dokter']) ?>
                            </div>
                            <div class="doctor-poli">
                                <i class="bi bi-hospital me-1"></i>
                                <?= esc($item['nama_poli']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-md-column align-items-center align-items-md-end justify-content-between gap-2">
                        <span class="status <?= esc($statusClass) ?>">
                            <i class="bi bi-circle-fill" style="font-size:7px"></i>
                            <?= esc($status) ?>
                        </span>

                        <div class="queue-box">
                            <div class="queue-label">No. Antrean</div>
                            <div class="queue-number">
                                <?= esc($item['no_antrean']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <i class="bi bi-calendar-event"></i>
                        <div>
                            <div class="info-label">Tanggal Kunjungan</div>
                            <div class="info-value">
                                <?= formatTanggalRiwayat($item['tanggal']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="bi bi-clock"></i>
                        <div>
                            <div class="info-label">Jam Praktik</div>
                            <div class="info-value">
                                <?= formatJamRiwayat($item['jam_mulai']) ?>
                                – <?= formatJamRiwayat($item['jam_selesai']) ?> WIB
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="bi bi-clipboard2-pulse"></i>
                        <div>
                            <div class="info-label">Jenis Kunjungan</div>
                            <div class="info-value">
                                <?= esc(ucfirst($item['jenis_kunjungan'])) ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="bi bi-calendar-plus"></i>
                        <div>
                            <div class="info-label">Tanggal Pendaftaran</div>
                            <div class="info-value">
                                <?= formatTanggalRiwayat($item['tanggal_daftar']) ?>
                                <?= date('H.i', strtotime($item['tanggal_daftar'])) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="complaint">
                    <div class="complaint-label">
                        <i class="bi bi-chat-left-text me-1"></i> Keluhan Awal
                    </div>
                    <div class="complaint-text">
                        <?= esc($item['keluhan_awal'] ?: 'Tidak ada keluhan yang dicatat.') ?>
                    </div>
                </div>

                <?php if (in_array($status, ['menunggu', 'dikonfirmasi'], true) && $item['tanggal'] > date('Y-m-d')): ?>
                    <form method="post"
                          action="<?= base_url('reservasi/batal/' . (int) $item['id_reservasi']) ?>"
                          class="mt-3 text-end"
                          onsubmit="return confirm('Batalkan reservasi ini?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-x-circle me-1"></i> Batalkan Reservasi
                        </button>
                    </form>
                <?php endif; ?>
            </article>

        <?php endforeach; ?>

    <?php endif; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
