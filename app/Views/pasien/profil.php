<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pasien | RS Politeknik LP3I Jakarta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --primary:#087f8c; --navy:#183447; --muted:#82919c; --bg:#f5f8fa; --border:#e8eef1; }
        body { background:var(--bg); color:var(--navy); font-family:'DM Sans',sans-serif; font-size:14px; }
        .navbar-custom { background:#fff; border-bottom:1px solid var(--border); padding:14px 0; }
        .brand { color:var(--navy); font-weight:800; font-size:20px; text-decoration:none; }
        .brand i { background:var(--primary); color:#fff; border-radius:12px; padding:8px 10px; margin-right:9px; }
        .panel { background:#fff; border:1px solid var(--border); border-radius:18px; padding:26px; box-shadow:0 8px 28px rgba(24,52,71,.04); }
        .form-control, .form-select { min-height:44px; border-radius:11px; border-color:var(--border); }
        .btn-main { background:var(--primary); color:#fff; border:0; border-radius:11px; font-weight:700; padding:11px 20px; }
        .btn-main:hover { background:#075c66; color:#fff; }
        .ro { background:#fbfcfd; border:1px solid var(--border); border-radius:11px; padding:10px 14px; }
        .ro small { display:block; color:var(--muted); font-size:12px; }
        .ro strong { font-weight:700; }
    </style>
</head>
<body>
<?= view('pasien/_navbar', ['aktif' => 'profil']) ?>

<main class="container py-4" style="max-width:820px">
    <h1 class="h3 fw-bold mb-1">Profil Pasien</h1>
    <p class="text-secondary mb-4">Data awal rekam medis kamu. Pastikan kontak dan riwayat alergi selalu benar.</p>

    <?= view('admin/_flash') ?>

    <?php
    $bpjs = $pasien['jenis_pasien'] === 'bpjs';
    $badge = ['menunggu' => 'warning', 'terverifikasi' => 'success', 'ditolak' => 'danger', 'tidak_berlaku' => 'secondary'][$pasien['status_bpjs']] ?? 'secondary';
    ?>

    <section class="panel mb-4">
        <div class="row g-3">
            <div class="col-md-6"><div class="ro"><small>Nama</small><strong><?= esc($pasien['nama']) ?></strong></div></div>
            <div class="col-md-6"><div class="ro"><small>No. Rekam Medis</small><strong><?= esc($pasien['no_rm']) ?></strong></div></div>
            <div class="col-md-6"><div class="ro"><small>NIK</small><strong><?= esc($pasien['nik']) ?></strong></div></div>
            <div class="col-md-6"><div class="ro"><small>Email</small><strong><?= esc($pasien['email']) ?></strong></div></div>
            <div class="col-md-4"><div class="ro"><small>Tanggal Lahir</small><strong><?= date('d-m-Y', strtotime($pasien['tanggal_lahir'])) ?></strong></div></div>
            <div class="col-md-4"><div class="ro"><small>Jenis Kelamin</small><strong><?= $pasien['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></strong></div></div>
            <div class="col-md-4"><div class="ro"><small>Jenis Pasien</small><strong><?= $bpjs ? 'BPJS' : 'Umum' ?></strong></div></div>
        </div>
    </section>

    <section class="panel">
        <form method="post" action="<?= base_url('profil') ?>">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" inputmode="numeric" minlength="9" maxlength="15"
                           value="<?= esc(old('no_hp', $pasien['no_hp']), 'attr') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select" required>
                        <?php $gdNow = old('golongan_darah', $pasien['golongan_darah']); ?>
                        <?php foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gd): ?>
                            <option value="<?= $gd ?>" <?= $gdNow === $gd ? 'selected' : '' ?>><?= $gd ?></option>
                        <?php endforeach; ?>
                        <option value="tidak_tahu" <?= $gdNow === 'tidak_tahu' ? 'selected' : '' ?>>Tidak tahu</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Riwayat Alergi</label>
                    <input type="text" name="alergi" class="form-control" maxlength="255"
                           value="<?= esc(old('alergi', $pasien['alergi'] ?? ''), 'attr') ?>"
                           placeholder="Kosongkan jika tidak ada">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" maxlength="255" required><?= esc(old('alamat', $pasien['alamat'])) ?></textarea>
                </div>

                <?php if ($bpjs): ?>
                    <div class="col-12"><hr class="my-1"></div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor BPJS</label>
                        <input type="text" name="no_bpjs" class="form-control" inputmode="numeric" maxlength="13"
                               value="<?= esc(old('no_bpjs', $pasien['no_bpjs']), 'attr') ?>"
                               <?= $pasien['status_bpjs'] === 'terverifikasi' ? 'readonly' : '' ?>>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block">Status Verifikasi BPJS</label>
                        <span class="badge text-bg-<?= $badge ?> fs-6"><?= esc(ucfirst(str_replace('_', ' ', $pasien['status_bpjs']))) ?></span>
                    </div>
                    <?php if (!empty($pasien['catatan_bpjs'])): ?>
                        <div class="col-12">
                            <div class="alert alert-warning mb-0"><strong>Catatan petugas:</strong> <?= esc($pasien['catatan_bpjs']) ?></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-main"><i class="bi bi-check2 me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
