<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Dashboard Admisi</h1><p>Ringkasan hari ini dan jalan pintas ke semua tugas admisi: poli, dokter, jadwal, pasien, dan pendaftaran.</p></div><div class="page-icon"><i class="bi bi-grid-1x2"></i></div></div>
<div class="surface-card p-4 mb-3">
<h3 class="h5">Ringkasan Hari Ini</h3>
<p class="text-muted mb-3">Anda di sini: ringkasan hari ini dan jalan pintas ke semua tugas admisi.</p>
<div class="row text-center">
<div class="col-6 col-md-3 mb-2"><div class="border rounded p-3"><div class="fs-3 fw-bold"><?= esc($total_pasien) ?></div><div class="text-muted small">Pasien</div></div></div>
<div class="col-6 col-md-3 mb-2"><div class="border rounded p-3"><div class="fs-3 fw-bold"><?= esc($total_dokter) ?></div><div class="text-muted small">Dokter</div></div></div>
<div class="col-6 col-md-3 mb-2"><div class="border rounded p-3"><div class="fs-3 fw-bold"><?= esc($total_jadwal) ?></div><div class="text-muted small">Jadwal Mendatang</div></div></div>
<div class="col-6 col-md-3 mb-2"><div class="border rounded p-3"><div class="fs-3 fw-bold"><?= esc($menunggu) ?></div><div class="text-muted small">Pendaftaran Menunggu</div></div></div>
</div>
<div class="quick-grid mt-3">
<a class="quick-item" href="/admin/poli"><span class="qicon"><i class="bi bi-hospital"></i></span>Poli</a>
<a class="quick-item" href="/admin/dokter"><span class="qicon"><i class="bi bi-person-badge"></i></span>Dokter</a>
<a class="quick-item" href="/admin/jadwal"><span class="qicon"><i class="bi bi-calendar-week"></i></span>Jadwal</a>
<a class="quick-item" href="/admin/pasien"><span class="qicon"><i class="bi bi-people"></i></span>Pasien</a>
<a class="quick-item" href="/admin/pendaftaran"><span class="qicon"><i class="bi bi-ticket-detailed"></i></span>Pendaftaran</a>
<a class="quick-item" href="/admin/rekap"><span class="qicon"><i class="bi bi-clipboard-data"></i></span>Rekap</a>
</div>
</div>
<div class="surface-card p-4 mb-3">
<h3>Pendaftaran Terbaru</h3>
<?php if (empty($terbaru)): ?><p class="mb-0">Belum ada pendaftaran. Pendaftaran pertama pasien akan muncul di sini.</p>
<?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>No. RM</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Status</th></tr>
<?php foreach ($terbaru as $r): ?><tr><td><?= esc($r['no_rm']) ?></td><td><?= esc($r['nama_pasien'] ?? '') ?></td><td><?= esc($r['nama_dokter']) ?></td><td><?= esc($r['tanggal']) ?></td><td><span class="badge <?= $r['status'] === 'selesai' ? 'badge-soft-success' : ($r['status'] === 'dibatalkan' ? 'badge-soft-secondary' : ($r['status'] === 'dikonfirmasi' ? 'badge-soft-primary' : 'badge-soft-warning')) ?>"><?= esc($r['status']) ?></span></td></tr><?php endforeach; ?></table></div></div>
<p class="mb-0"><a class="btn btn-primary" href="/admin/pendaftaran">Kelola Semua Pendaftaran</a></p>
<?php endif; ?>
</div>
<?= $this->include('partials/footer') ?>
