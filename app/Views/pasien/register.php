<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Registrasi Pasien</h1><p>Daftar sekali di sini. Setelah itu Anda bisa memilih jadwal dan mendapat nomor antrean tanpa antre di loket untuk mendaftar.</p></div><div class="page-icon"><i class="bi bi-person-plus"></i></div></div>
<div class="surface-card p-4 mb-3">
<form action="/registrasi" method="post"><?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Nama Lengkap</label><input class="form-control" type="text" name="nama" value="<?= esc(old('nama')) ?>" required></div>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= esc(old('email')) ?>" required></div>
<div class="mb-3"><label class="form-label">Kata Sandi (minimal 8 karakter)</label><input class="form-control" type="password" name="password" required></div>
<div class="mb-3"><label class="form-label">NIK (16 digit)</label><input class="form-control" type="text" name="nik" value="<?= esc(old('nik')) ?>" required></div>
<div class="mb-3"><label class="form-label">Tanggal Lahir</label><input class="form-control" type="date" name="tanggal_lahir" value="<?= esc(old('tanggal_lahir')) ?>" required></div>
<div class="mb-3"><label class="form-label">Jenis Kelamin</label><select class="form-select" name="jenis_kelamin" required><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
<div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" name="alamat" required><?= esc(old('alamat')) ?></textarea></div>
<div class="mb-3"><label class="form-label">Jenis Pasien</label><select class="form-select" name="jenis_pasien" required><option value="umum">Umum</option><option value="bpjs">BPJS</option></select></div>
<div class="mb-3"><label class="form-label">Nomor BPJS (wajib untuk jalur BPJS)</label><input class="form-control" type="text" name="no_bpjs" value="<?= esc(old('no_bpjs')) ?>"></div>
<div class="mb-3"><label class="form-label">Nomor HP</label><input class="form-control" type="text" name="no_hp" value="<?= esc(old('no_hp')) ?>"></div>
<div class="mb-3"><label class="form-label">Golongan Darah</label><select class="form-select" name="golongan_darah"><option value="tidak_tahu">Tidak tahu</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select></div>
<div class="mb-3"><label class="form-label">Alergi</label><input class="form-control" type="text" name="alergi" value="<?= esc(old('alergi')) ?>"></div>
<p><button class="btn btn-primary" type="submit">Daftar</button></p>
<p class="text-muted small mb-0">Setelah daftar, langkah selanjutnya: login, pilih jadwal, dan nomor antrean Anda akan muncul di halaman utama.</p>
</form></div>
<?= $this->include('partials/footer') ?>
