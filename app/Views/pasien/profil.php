<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Profil Pasien</h1><p>Data diri, nomor RM, jalur, dan status BPJS Anda. Ubah data kontak dari formulir di bawah.</p></div><div class="page-icon"><i class="bi bi-person"></i></div></div>
<div class="surface-card p-4 mb-3">
<h3 class="h5">Data Diri &amp; Status BPJS</h3>
<p class="mb-1"><strong>Nomor RM:</strong> <?= esc($pasien['no_rm']) ?> &nbsp;|&nbsp; <strong>NIK:</strong> <?= esc($pasien['nik']) ?></p>
<p class="mb-0"><strong>Jalur:</strong> <?= esc($pasien['jenis_pasien']) ?> &nbsp;|&nbsp; <strong>Status BPJS:</strong> <span class="badge <?= $pasien['status_bpjs'] === 'terverifikasi' ? 'badge-soft-success' : ($pasien['status_bpjs'] === 'ditolak' ? 'badge-soft-danger' : ($pasien['status_bpjs'] === 'menunggu' ? 'badge-soft-warning' : 'badge-soft-secondary')) ?>"><?= esc($pasien['status_bpjs']) ?></span></p>
<?php if ($pasien['jenis_pasien'] === 'bpjs' && $pasien['status_bpjs'] === 'menunggu'): ?><p class="text-muted small mt-2 mb-0">Status BPJS Anda masih menunggu verifikasi admisi. Setelah terverifikasi, Anda bisa mendaftar seperti biasa.</p><?php endif; ?>
</div>
<div class="surface-card p-4 mb-3">
<h3 class="h5">Ubah Data Kontak</h3>
<form action="/profil/simpan" method="post"><?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" name="alamat" required><?= esc($pasien['alamat']) ?></textarea></div>
<div class="mb-3"><label class="form-label">Nomor HP</label><input class="form-control" type="text" name="no_hp" value="<?= esc($pasien['no_hp']) ?>"></div>
<div class="mb-3"><label class="form-label">Golongan Darah</label><input class="form-control" type="text" name="golongan_darah" value="<?= esc($pasien['golongan_darah']) ?>"></div>
<div class="mb-3"><label class="form-label">Alergi</label><input class="form-control" type="text" name="alergi" value="<?= esc($pasien['alergi']) ?>"></div>
<p><button class="btn btn-primary w-100" type="submit">Simpan Profil</button></p><p><a class="btn btn-outline-secondary w-100" href="/jadwal">Kembali ke Jadwal</a></p>
</form></div>
<?= $this->include('partials/footer') ?>
