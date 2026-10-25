<?= $this->include('partials/header') ?>
<div class="card"><h2><?= $dokter ? 'Ubah Dokter' : 'Tambah Dokter' ?></h2>
<form action="/admin/dokter/simpan" method="post"><?= csrf_field() ?>
<?php if ($dokter): ?><input type="hidden" name="id_dokter" value="<?= esc($dokter['id_dokter']) ?>"><?php endif; ?>
<label>Poliklinik</label><select name="id_poli" required><?php foreach ($poli as $pl): ?><option value="<?= esc($pl['id_poli']) ?>" <?= ($dokter && (int) $dokter['id_poli'] === (int) $pl['id_poli']) ? 'selected' : '' ?>><?= esc($pl['nama_poli']) ?></option><?php endforeach; ?></select>
<label>Akun Login Dokter (opsional, kosongkan bila belum ada akun)</label><select name="id_user"><option value="">- Tanpa akun -</option><?php foreach ($akun as $a): ?><option value="<?= esc($a['id_user']) ?>" <?= ($dokter && (int) ($dokter['id_user'] ?? 0) === (int) $a['id_user']) ? 'selected' : '' ?>><?= esc($a['nama']) ?> (<?= esc($a['email']) ?>)</option><?php endforeach; ?></select>
<label>Nama Dokter</label><input type="text" name="nama_dokter" value="<?= esc($dokter['nama_dokter'] ?? '') ?>" required>
<label>Spesialisasi</label><input type="text" name="spesialisasi" value="<?= esc($dokter['spesialisasi'] ?? '') ?>" required>
<p><button type="submit">Simpan</button></p></form></div>
<?= $this->include('partials/footer') ?>
