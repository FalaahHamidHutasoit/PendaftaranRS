<?= $this->include('partials/header') ?>
<div class="card"><h2>Buat Rekam Medis</h2>
<p>Pasien: <?= esc($pendaftaran['nama_pasien']) ?> (<?= esc($pendaftaran['no_rm']) ?>), tanggal jadwal: <?= esc($pendaftaran['tanggal']) ?>.</p>
<form action="/dokter/rekam-medis/simpan" method="post"><?= csrf_field() ?>
<input type="hidden" name="id_pendaftaran" value="<?= esc($pendaftaran['id_pendaftaran']) ?>">
<label>Tanggal Periksa</label><input type="date" name="tanggal_periksa" value="<?= esc(date('Y-m-d')) ?>" required>
<label>Diagnosis</label><textarea name="diagnosis" required><?= esc(old('diagnosis')) ?></textarea>
<label>Tindakan</label><textarea name="tindakan"><?= esc(old('tindakan')) ?></textarea>
<label>Resep</label><textarea name="resep"><?= esc(old('resep')) ?></textarea>
<label>Catatan</label><textarea name="catatan"><?= esc(old('catatan')) ?></textarea>
<p><button type="submit">Simpan Rekam Medis</button></p></form></div>
<?= $this->include('partials/footer') ?>
