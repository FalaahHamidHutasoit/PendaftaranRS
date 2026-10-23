
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien Baru - RS Politeknik LP3I Jakarta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="mb-4">
                <a href="<?= base_url('login') ?>" class="btn btn-outline-secondary btn-sm mb-3">
                    &larr; Kembali ke Login
                </a>

                <h2 class="fw-bold">Pendaftaran Pasien Baru</h2>
                <p class="text-muted">
                    Silakan isi identitas diri untuk membuat data pasien rumah sakit.
                </p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                <?php if (session()->getFlashdata('pesan_sukses')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('pesan_sukses')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('pesan_error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('pesan_error')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

                    <form action="<?= base_url('pendaftaran') ?>" method="post">
                        <?= csrf_field() ?>

                        <h5 class="mb-3">Informasi Akun</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                placeholder="Masukkan nama lengkap"
                                value="<?= esc(old('nama'), 'attr') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="contoh@email.com"
                                   value="<?= esc(old('email'), 'attr') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Buat password untuk login" minlength="8" required>
                            <div class="form-text">Minimal 8 karakter.</div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Identitas Pasien</h5>

                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control"
                                   placeholder="Masukkan 16 digit NIK"
                                   inputmode="numeric" minlength="16" maxlength="16"
                                   value="<?= esc(old('nik'), 'attr') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                   max="<?= date('Y-m-d') ?>" value="<?= esc(old('tanggal_lahir'), 'attr') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control"
                                   placeholder="Contoh: 081234567890" inputmode="numeric"
                                   minlength="9" maxlength="15"
                                   value="<?= esc(old('no_hp'), 'attr') ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <?php foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gd): ?>
                                        <option value="<?= $gd ?>" <?= old('golongan_darah') === $gd ? 'selected' : '' ?>><?= $gd ?></option>
                                    <?php endforeach; ?>
                                    <option value="tidak_tahu" <?= old('golongan_darah') === 'tidak_tahu' ? 'selected' : '' ?>>Tidak tahu</option>
                                </select>
                            </div>
                            <div class="col-md-7 mb-3">
                                <label class="form-label">Riwayat Alergi <span class="text-muted">(opsional)</span></label>
                                <input type="text" name="alergi" class="form-control" maxlength="255"
                                       placeholder="Contoh: obat penisilin, kacang"
                                       value="<?= esc(old('alergi'), 'attr') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"
                                      placeholder="Masukkan alamat lengkap" required><?= esc(old('alamat')) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Pasien</label>
                            <select name="jenis_pasien" id="jenis_pasien"
                                    class="form-select" required>
                                <option value="">-- Pilih Jenis Pasien --</option>
                                <option value="umum" <?= old('jenis_pasien') === 'umum' ? 'selected' : '' ?>>Pasien Umum</option>
                                <option value="bpjs" <?= old('jenis_pasien') === 'bpjs' ? 'selected' : '' ?>>Pasien BPJS</option>
                            </select>
                        </div>

                        <div class="mb-4" id="kolom_bpjs" <?= old('jenis_pasien') === 'bpjs' ? '' : 'hidden' ?>>
                            <label class="form-label">Nomor BPJS</label>
                            <input type="text" name="no_bpjs" id="no_bpjs"
                                   class="form-control" placeholder="13 digit nomor BPJS"
                                   inputmode="numeric" maxlength="13" value="<?= esc(old('no_bpjs'), 'attr') ?>">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Daftar Pasien
                            </button>
                        </div>

                        <p class="text-muted small mt-3 mb-0">
                            Data yang diisi akan digunakan untuk proses pendaftaran pasien.
                        </p>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const jenisPasien = document.getElementById('jenis_pasien');
    const kolomBpjs = document.getElementById('kolom_bpjs');
    const nomorBpjs = document.getElementById('no_bpjs');

    function aturBpjs() {
        const pasienBPJS = jenisPasien.value === 'bpjs';

        kolomBpjs.hidden = !pasienBPJS;
        nomorBpjs.required = pasienBPJS;

        if (!pasienBPJS) {
            nomorBpjs.value = '';
        }
    }

    jenisPasien.addEventListener('change', aturBpjs);
    aturBpjs();
</script>

</body>
</html>
