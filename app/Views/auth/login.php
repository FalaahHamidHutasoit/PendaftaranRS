<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Login</h1><p>Masuk untuk mendaftar ke jadwal, melihat nomor antrean, dan mengelola pendaftaran Anda.</p></div><div class="page-icon"><i class="bi bi-box-arrow-in-right"></i></div></div>
<div class="surface-card p-4 mb-3">
<form action="/login" method="post"><?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= esc(old('email')) ?>" required></div>
<div class="mb-3"><label class="form-label">Kata Sandi</label><input class="form-control" type="password" name="password" required></div>
<p><button class="btn btn-primary w-100" type="submit">Masuk</button></p>
</form>
<p class="mb-0">Belum punya akun pasien? <a href="/registrasi">Registrasi di sini</a>, lalu login dan pilih jadwal.</p>
</div>
<?= $this->include('partials/footer') ?>
