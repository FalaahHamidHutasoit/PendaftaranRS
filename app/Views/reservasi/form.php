
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Reservasi | Rumah Sakit Politeknik LP3I Jakarta</title>

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
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 15px 0;
        }

        .brand {
            color: var(--navy);
            font-size: 21px;
            font-weight: 800;
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            margin-right: 9px;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-size: 20px;
        }

        .page-content {
            max-width: 900px;
            margin: auto;
            padding: 35px 20px 55px;
        }

        .eyebrow {
            color: var(--primary);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .page-title {
            margin: 8px 0;
            font-size: clamp(26px, 4vw, 34px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .muted {
            color: var(--muted);
            line-height: 1.8;
        }

        .panel {
            padding: 26px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: white;
            box-shadow: 0 8px 28px rgba(24, 52, 71, .04);
        }

        .doctor-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 55px;
            height: 55px;
            flex-shrink: 0;
            border-radius: 16px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 26px;
        }

        .doctor-name {
            font-size: 18px;
            font-weight: 800;
        }

        .info-box {
            height: 100%;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fbfcfd;
        }

        .info-label {
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 12px;
        }

        .info-value {
            font-weight: 700;
        }

        .form-label {
            margin-bottom: 8px;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            min-height: 46px;
            border-color: var(--border);
            border-radius: 11px;
            font-size: 14px;
        }

        textarea.form-control {
            min-height: 120px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(8, 127, 140, .1);
        }

        .btn-primary-custom {
            padding: 12px 18px;
            border: 0;
            border-radius: 11px;
            background: var(--primary);
            color: white;
            font-weight: 700;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: white;
        }

        .btn-back {
            padding: 12px 18px;
            border: 1px solid var(--border);
            border-radius: 11px;
            color: var(--navy);
            font-weight: 700;
        }

        .btn-back:hover {
            background: #f4f7f8;
        }

        @media (max-width: 576px) {
            .page-content {
                padding: 25px 14px 40px;
            }

            .panel {
                padding: 19px;
            }
        }
    </style>
</head>

<body>

<?= view('pasien/_navbar', ['aktif' => 'jadwal']) ?>

<main class="page-content">

    <div class="mb-4">
        <div class="eyebrow">Pendaftaran online</div>
        <h1 class="page-title">Formulir Reservasi</h1>
        <p class="muted mb-0">
            Periksa jadwal dokter dan lengkapi informasi kunjunganmu.
        </p>
    </div>

    <?php if (session()->getFlashdata('pesan_error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('pesan_error')) ?>
        </div>
    <?php endif; ?>

    <!-- INFORMASI JADWAL -->
    <section class="panel mb-4">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="doctor-icon">
                <i class="bi bi-person-badge"></i>
            </div>

            <div>
                <div class="doctor-name">
                    <?= esc($jadwal['nama_dokter']) ?>
                </div>
                <div class="muted">
                    <?= esc($jadwal['nama_poli']) ?>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-sm-6">
                <div class="info-box">
                    <div class="info-label">
                        <i class="bi bi-calendar3 me-1"></i>
                        Tanggal praktik
                    </div>
                    <div class="info-value">
                        <?= date('d F Y', strtotime($jadwal['tanggal'])) ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="info-box">
                    <div class="info-label">
                        <i class="bi bi-clock me-1"></i>
                        Jam praktik
                    </div>
                    <div class="info-value">
                        <?= esc(substr($jadwal['jam_mulai'], 0, 5)) ?>
                        –
                        <?= esc(substr($jadwal['jam_selesai'], 0, 5)) ?>
                        WIB
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="info-box">
                    <div class="info-label">
                        <i class="bi bi-people me-1"></i>
                        Ketersediaan kuota
                    </div>
                    <div class="info-value text-success">
                        <?= (int) $sisa ?> slot tersedia
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FORM AWAL -->
    <section class="panel">
        <h2 class="h5 fw-bold mb-1">Informasi Kunjungan</h2>
        <p class="muted mb-4">
            Lengkapi informasi berikut untuk melanjutkan pendaftaran.
        </p>

        <form action="<?= base_url('reservasi/simpan') ?>"
              method="post">

            <?= csrf_field() ?>

            <input type="hidden"
                   name="id_jadwal"
                   value="<?= (int) $jadwal['id_jadwal'] ?>">

            <div class="mb-4">
                <label for="jenis_kunjungan" class="form-label">
                    Jenis Kunjungan
                </label>

                <select name="jenis_kunjungan"
                        id="jenis_kunjungan"
                        class="form-select"
                        required>
                    <option value="">Pilih jenis kunjungan</option>
                    <option value="baru">Pasien Baru</option>
                    <option value="kontrol">Pasien Kontrol</option>
                </select>

                <div class="form-text">
                    Pilih sesuai kondisi kunjunganmu ke rumah sakit.
                </div>
            </div>

            <?php if ($pasien['jenis_pasien'] === 'bpjs'): ?>
                <div class="alert alert-info">
                    <i class="bi bi-shield-check me-1"></i>
                    Kamu terdaftar sebagai <strong>pasien BPJS</strong>
                    (status verifikasi:
                    <strong><?= esc(str_replace('_', ' ', $pasien['status_bpjs'])) ?></strong>).
                    <?php if ($pasien['status_bpjs'] !== 'terverifikasi'): ?>
                        Reservasi tetap dapat dibuat, namun baru dikonfirmasi setelah BPJS kamu diverifikasi petugas.
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="no_rujukan" class="form-label">Nomor Rujukan / Surat Kontrol</label>
                    <input type="text" name="no_rujukan" id="no_rujukan" class="form-control"
                           maxlength="30" value="<?= esc(old('no_rujukan'), 'attr') ?>" required>
                    <div class="form-text">Dari FKTP (puskesmas/klinik) untuk kunjungan baru, atau surat kontrol dari dokter untuk kontrol.</div>
                </div>

                <div class="mb-4">
                    <label for="faskes_perujuk" class="form-label">Faskes Perujuk</label>
                    <input type="text" name="faskes_perujuk" id="faskes_perujuk" class="form-control"
                           maxlength="100" value="<?= esc(old('faskes_perujuk'), 'attr') ?>"
                           placeholder="Contoh: Puskesmas Kecamatan Jatinegara">
                    <div class="form-text">Wajib diisi untuk kunjungan pasien baru.</div>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <label for="keluhan_awal" class="form-label">
                    Keluhan Awal
                </label>

                <textarea name="keluhan_awal"
                          id="keluhan_awal"
                          class="form-control"
                          rows="4"
                          maxlength="1000"
                          placeholder="Jelaskan keluhan atau tujuan kunjunganmu..."
                          required></textarea>

                <div class="form-text">
                    Maksimal 1.000 karakter.
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                <a href="<?= base_url('reservasi') ?>"
                   class="btn btn-back text-center">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary-custom">
                    Lanjutkan Pendaftaran
                    <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>

        </form>
    </section>

    <footer class="text-center muted small mt-4">
        Rumah Sakit Politeknik LP3I Jakarta — Pendaftaran Pasien
    </footer>

</main>

</body>
</html>
