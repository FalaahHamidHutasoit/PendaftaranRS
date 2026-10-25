<?= $this->include('partials/header') ?>
<div class="card"><h2>Ubah Jadwal Saya</h2>
<form action="/dokter/jadwal/simpan" method="post"><?= csrf_field() ?>
<input type="hidden" name="id_jadwal" value="<?= esc($jadwal['id_jadwal']) ?>">
<label>Tanggal</label><input type="date" name="tanggal" value="<?= esc($jadwal['tanggal']) ?>" required>
<label>Jam Mulai</label><input type="time" name="jam_mulai" value="<?= esc($jadwal['jam_mulai']) ?>" required>
<label>Jam Selesai</label><input type="time" name="jam_selesai" value="<?= esc($jadwal['jam_selesai']) ?>" required>
<label>Kuota</label><input type="number" name="kuota" min="1" value="<?= esc($jadwal['kuota']) ?>" required>
<p><button type="submit">Simpan</button></p></form></div>
<?= $this->include('partials/footer') ?>
