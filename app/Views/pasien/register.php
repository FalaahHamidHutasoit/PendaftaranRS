<?= $this->include('partials/header') ?>
<div class="card">
<h2>Registrasi Pasien</h2>
<form action="/registrasi" method="post"><?= csrf_field() ?>
<label>Nama Lengkap</label><input type="text" name="nama" value="<?= esc(old('nama')) ?>" required>
<label>Email</label><input type="email" name="email" value="<?= esc(old('email')) ?>" required>
<label>Kata Sandi (minimal 8 karakter)</label><input type="password" name="password" required>
<label>NIK (16 digit)</label><input type="text" name="nik" value="<?= esc(old('nik')) ?>" required>
<label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="<?= esc(old('tanggal_lahir')) ?>" required>
<label>Jenis Kelamin</label><select name="jenis_kelamin" required><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
<label>Alamat</label><textarea name="alamat" required><?= esc(old('alamat')) ?></textarea>
<label>Jenis Pasien</label><select name="jenis_pasien" required><option value="umum">Umum</option><option value="bpjs">BPJS</option></select>
<label>Nomor BPJS (wajib untuk jalur BPJS)</label><input type="text" name="no_bpjs" value="<?= esc(old('no_bpjs')) ?>">
<label>Nomor HP</label><input type="text" name="no_hp" value="<?= esc(old('no_hp')) ?>">
<label>Golongan Darah</label><select name="golongan_darah"><option value="tidak_tahu">Tidak tahu</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select>
<label>Alergi</label><input type="text" name="alergi" value="<?= esc(old('alergi')) ?>">
<p><button type="submit">Daftar</button></p>
</form>
</div>
<?= $this->include('partials/footer') ?>
