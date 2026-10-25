<?= $this->include('partials/header') ?>
<div class="card">
<h2>Login</h2>
<form action="/login" method="post"><?= csrf_field() ?>
<label>Email</label><input type="email" name="email" value="<?= esc(old('email')) ?>" required>
<label>Kata Sandi</label><input type="password" name="password" required>
<p><button type="submit">Masuk</button></p>
</form>
<p class="small">Belum punya akun pasien? <a href="/registrasi">Registrasi di sini</a>.</p>
</div>
<?= $this->include('partials/footer') ?>
