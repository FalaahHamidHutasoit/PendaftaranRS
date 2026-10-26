<?= $this->include('partials/header') ?>
<div class="surface-card p-4 mb-3"><h2><?= $poli ? 'Ubah Poli' : 'Tambah Poli' ?></h2>
<form action="/admin/poli/simpan" method="post"><?= csrf_field() ?>
<?php if ($poli): ?><input type="hidden" name="id_poli" value="<?= esc($poli['id_poli']) ?>" class="form-control"><?php endif; ?>
<label class="form-label">Nama Poli</label><input type="text" name="nama_poli" value="<?= esc($poli['nama_poli'] ?? old('nama_poli')) ?>" required class="form-control">
<label class="form-label">Kode Antrean (1 huruf)</label><input type="text" name="kode_antrean" value="<?= esc($poli['kode_antrean'] ?? old('kode_antrean')) ?>" required maxlength="1" class="form-control" style="text-transform:uppercase">
<p class="text-muted small">Satu huruf A-Z, unik antar poli, dipakai sebagai huruf depan kode antrean (mis. U untuk Poli Umum sehingga antreannya tampil U012).</p>
<label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control"><?= esc($poli['deskripsi'] ?? old('deskripsi')) ?></textarea>
<p><button type="submit" class="btn btn-primary">Simpan</button></p></form></div>
<?= $this->include('partials/footer') ?>
