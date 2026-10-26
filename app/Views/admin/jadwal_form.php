<?= $this->include('partials/header') ?>
<div class="surface-card p-4 mb-3"><h2><?= $jadwal ? 'Ubah Jadwal' : 'Tambah Jadwal' ?></h2>
<form action="/admin/jadwal/simpan" method="post"><?= csrf_field() ?>
<?php if ($jadwal): ?><input type="hidden" name="id_jadwal" value="<?= esc($jadwal['id_jadwal']) ?>" class="form-control"><?php endif; ?>
<label class="form-label">Dokter</label><select name="id_dokter" required class="form-select"><?php foreach ($dokter as $d): ?><option value="<?= esc($d['id_dokter']) ?>" <?= ($jadwal && (int) $jadwal['id_dokter'] === (int) $d['id_dokter']) ? 'selected' : '' ?>><?= esc($d['nama_dokter']) ?></option><?php endforeach; ?></select>
<label class="form-label">Tanggal</label><input type="date" name="tanggal" value="<?= esc($jadwal['tanggal'] ?? '') ?>" required class="form-control">
<label class="form-label">Jam Mulai</label><input type="time" name="jam_mulai" value="<?= esc($jadwal['jam_mulai'] ?? '') ?>" required class="form-control">
<label class="form-label">Jam Selesai</label><input type="time" name="jam_selesai" value="<?= esc($jadwal['jam_selesai'] ?? '') ?>" required class="form-control">
<label class="form-label">Kuota</label><input type="number" name="kuota" min="1" value="<?= esc($jadwal['kuota'] ?? 20) ?>" required class="form-control">
<p><button type="submit" class="btn btn-primary">Simpan</button></p></form></div>
<?= $this->include('partials/footer') ?>
