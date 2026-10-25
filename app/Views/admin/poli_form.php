<?= $this->include('partials/header') ?>
<div class="card"><h2><?= $poli ? 'Ubah Poli' : 'Tambah Poli' ?></h2>
<form action="/admin/poli/simpan" method="post"><?= csrf_field() ?>
<?php if ($poli): ?><input type="hidden" name="id_poli" value="<?= esc($poli['id_poli']) ?>"><?php endif; ?>
<label>Nama Poli</label><input type="text" name="nama_poli" value="<?= esc($poli['nama_poli'] ?? old('nama_poli')) ?>" required>
<label>Deskripsi</label><textarea name="deskripsi"><?= esc($poli['deskripsi'] ?? old('deskripsi')) ?></textarea>
<p><button type="submit">Simpan</button></p></form></div>
<?= $this->include('partials/footer') ?>
