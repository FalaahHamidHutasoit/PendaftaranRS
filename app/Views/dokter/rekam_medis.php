<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Rekam Medis Saya</h1><p>Rekam medis yang Anda buat untuk pendaftaran yang sudah selesai. Membuka detail dicatat ke audit log.</p></div><div class="page-icon"><i class="bi bi-journal-medical"></i></div></div>
<div class="surface-card p-4 mb-3"><h3 class="h5">Ringkasan Rekam Medis Saya</h3><p class="mb-0">Total rekam medis Anda: <?= count($rekam_medis) ?>. Membuka detail rekam medis dicatat ke audit log.</p></div>
<div class="surface-card p-4 mb-3"><h2>Rekam Medis Saya</h2></div>
<?php if (empty($rekam_medis)): ?><div class="surface-card p-4 mb-3"><h3>Belum ada rekam medis.</h3><p class="mb-0">Rekam medis muncul di sini setelah Anda membuat rekam medis untuk pendaftaran yang sudah selesai.</p></div><?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Tanggal Periksa</th><th>Pasien (No. RM)</th><th>Kode Antrean</th><th>Diagnosis</th><th></th></tr>
<?php foreach ($rekam_medis as $r): ?><tr><td><?= esc($r['tanggal_periksa']) ?></td><td><?= esc($r['nama_pasien']) ?> (<?= esc($r['no_rm']) ?>)</td><td><strong><?= esc($r['kode_antrean'] ?? $r['no_antrean']) ?></strong></td><td><?= esc($r['diagnosis']) ?></td><td><a class="btn btn-primary" href="/dokter/rekam-medis/lihat/<?= esc($r['id_rekam_medis']) ?>">Lihat</a></td></tr>
<?php endforeach; ?></table></div></div>
<?php endif; ?>
<p class="text-muted small">Membuka detail rekam medis dicatat ke audit log (siapa, kapan, pendaftaran mana).</p>
<?= $this->include('partials/footer') ?>
