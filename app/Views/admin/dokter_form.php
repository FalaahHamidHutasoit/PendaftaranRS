<?= $this->include('partials/header') ?>
<div class="surface-card p-4 mb-3"><h2><?= $dokter ? 'Ubah Dokter' : 'Tambah Dokter' ?></h2>
<form action="/admin/dokter/simpan" method="post"><?= csrf_field() ?>
<?php if ($dokter): ?><input type="hidden" name="id_dokter" value="<?= esc($dokter['id_dokter']) ?>" class="form-control"><?php endif; ?>
<label class="form-label">Poliklinik</label><select name="id_poli" required class="form-select"><?php foreach ($poli as $pl): ?><option value="<?= esc($pl['id_poli']) ?>" <?= ($dokter && (int) $dokter['id_poli'] === (int) $pl['id_poli']) ? 'selected' : '' ?>><?= esc($pl['nama_poli']) ?></option><?php endforeach; ?></select>
<label class="form-label">Akun Login Dokter (opsional, kosongkan bila belum ada akun)</label><select name="id_user" class="form-select"><option value="">- Tanpa akun -</option><?php foreach ($akun as $a): ?><option value="<?= esc($a['id_user']) ?>" <?= ($dokter && (int) ($dokter['id_user'] ?? 0) === (int) $a['id_user']) ? 'selected' : '' ?>><?= esc($a['nama']) ?> (<?= esc($a['email']) ?>)</option><?php endforeach; ?></select>
<label class="form-label">Nama Dokter</label><input type="text" name="nama_dokter" value="<?= esc($dokter['nama_dokter'] ?? '') ?>" required class="form-control">
<label class="form-label">Spesialisasi</label><input type="text" name="spesialisasi" value="<?= esc($dokter['spesialisasi'] ?? '') ?>" required class="form-control">
<p><button type="submit" class="btn btn-primary">Simpan</button></p></form></div>
<?= $this->include('partials/footer') ?>
