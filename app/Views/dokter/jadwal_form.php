<?= $this->include('partials/header') ?>
<div class="surface-card p-4 mb-3"><h2>Ubah Jadwal Saya</h2>
<form action="/dokter/jadwal/simpan" method="post"><?= csrf_field() ?>
<input type="hidden" name="id_jadwal" value="<?= esc($jadwal['id_jadwal']) ?>" class="form-control">
<label class="form-label">Tanggal</label><input type="date" name="tanggal" value="<?= esc($jadwal['tanggal']) ?>" required class="form-control">
<label class="form-label">Jam Mulai</label><input type="time" name="jam_mulai" value="<?= esc($jadwal['jam_mulai']) ?>" required class="form-control">
<label class="form-label">Jam Selesai</label><input type="time" name="jam_selesai" value="<?= esc($jadwal['jam_selesai']) ?>" required class="form-control">
<label class="form-label">Kuota</label><input type="number" name="kuota" min="1" value="<?= esc($jadwal['kuota']) ?>" required class="form-control">
<p><button type="submit" class="btn btn-primary">Simpan</button></p></form></div>
<?= $this->include('partials/footer') ?>
