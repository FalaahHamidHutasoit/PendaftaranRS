<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Data Pasien &amp; Verifikasi BPJS</h1><p>Lihat data pasien dan verifikasi BPJS-nya. Hanya pasien jalur BPJS yang perlu diverifikasi di sini.</p></div><div class="page-icon"><i class="bi bi-people"></i></div></div>
<div class="surface-card p-4 mb-3"><h3 class="h5">Ringkasan Pasien &amp; Verifikasi BPJS</h3><p class="mb-0">Total pasien: <?= count($pasien) ?>. Hanya pasien jalur BPJS yang bisa diverifikasi di sini; pasien jalur umum tidak perlu verifikasi. Setelah terverifikasi, pasien bisa mendaftar seperti biasa.</p></div>
<div class="surface-card p-4 mb-3"><h2>Data Pasien &amp; Verifikasi BPJS</h2></div>
<?php if (empty($pasien)): ?><div class="surface-card p-4 mb-3"><h3>Belum ada pasien.</h3><p class="mb-0">Pasien muncul di sini setelah registrasi. Verifikasi BPJS hanya untuk pasien jalur BPJS.</p></div><?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>No. RM</th><th>Nama</th><th>Jalur</th><th>Status BPJS</th><th>Verifikasi</th></tr>
<?php foreach ($pasien as $r): ?><tr><td><?= esc($r['no_rm']) ?></td><td><?= esc($r['nama']) ?></td><td><?= esc($r['jenis_pasien']) ?></td><td><span class="badge <?= $r['status_bpjs'] === 'terverifikasi' ? 'badge-soft-success' : ($r['status_bpjs'] === 'ditolak' ? 'badge-soft-danger' : ($r['status_bpjs'] === 'menunggu' ? 'badge-soft-warning' : 'badge-soft-secondary')) ?>"><?= esc($r['status_bpjs']) ?></span></td>
<td><?php if ($r['jenis_pasien'] === 'bpjs'): ?>
<form action="/admin/pasien/bpjs/<?= esc($r['id_pasien']) ?>" method="post"><?= csrf_field() ?>
<select name="status_bpjs" class="form-select"><option value="menunggu">Menunggu</option><option value="terverifikasi">Terverifikasi</option><option value="ditolak">Ditolak</option></select>
<input type="text" name="catatan_bpjs" placeholder="Catatan (opsional)" class="form-control">
<button type="submit" class="btn btn-primary">Simpan</button></form>
<?php else: ?>-<?php endif; ?></td></tr>
<?php endforeach; ?></table></div></div>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
