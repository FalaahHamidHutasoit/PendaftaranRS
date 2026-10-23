
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RS Politeknik LP3I Jakarta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="card border-0 shadow-sm w-100" style="max-width: 430px;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <h3 class="fw-bold">Login</h3>
                <p class="text-muted mb-0">Aplikasi Pintar Pendaftaran Pasien</p>
                <p class="fw-semibold">Rumah Sakit Politeknik LP3I Jakarta</p>
            </div>

            <?php if (session()->getFlashdata('pesan_sukses')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('pesan_sukses')) ?>
    </div>
<?php endif; ?>

            <form action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Masukkan email"
                        value="<?= old('email') ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted mb-2">
                    Belum memiliki akun pasien?
                </p>
                <a href="<?= base_url('pendaftaran') ?>" class="text-decoration-none">
                    Daftar Pasien Baru
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
