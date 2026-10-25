<?= $this->include('partials/header') ?>
<div class="card">
<h2>Profil Pasien</h2>
<p><strong>Nomor RM:</strong> <?= esc($pasien['no_rm']) ?> &nbsp; <strong>NIK:</strong> <?= esc($pasien['nik']) ?></p>
<p><strong>Jalur:</strong> <?= esc($pasien['jenis_pasien']) ?> &nbsp; <strong>Status BPJS:</strong> <?= esc($pasien['status_bpjs']) ?></p>
<form action="/profil/simpan" method="post"><?= csrf_field() ?>
<label>Alamat</label><textarea name="alamat" required><?= esc($pasien['alamat']) ?></textarea>
<label>Nomor HP</label><input type="text" name="no_hp" value="<?= esc($pasien['no_hp']) ?>">
<label>Golongan Darah</label><input type="text" name="golongan_darah" value="<?= esc($pasien['golongan_darah']) ?>">
<label>Alergi</label><input type="text" name="alergi" value="<?= esc($pasien['alergi']) ?>">
<p><button type="submit">Simpan Profil</button></p>
</form>
</div>
<?= $this->include('partials/footer') ?>
