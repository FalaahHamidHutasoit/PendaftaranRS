<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Rekap Admisi</h1><p>Jumlah pendaftaran per status dan per poli, plus pasien BPJS yang masih menunggu verifikasi.</p></div><div class="page-icon"><i class="bi bi-clipboard-data"></i></div></div>
<div class="surface-card p-4 mb-3">
<h2>Rekap Admisi</h2>
<p class="mb-1">Total pendaftaran aktif (bukan dibatalkan): <strong><?= esc($total_aktif) ?></strong></p>
<p class="mb-0">Pasien BPJS menunggu verifikasi: <strong><?= esc($bpjs_menunggu) ?></strong> &mdash; verifikasi dari halaman Data Pasien.</p>
</div>
<div class="surface-card p-4 mb-3"><h3>Per Status</h3>
<?php if (empty($per_status)): ?><p class="mb-0">Belum ada data per status.</p>
<?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Status</th><th>Jumlah</th></tr>
<?php foreach ($per_status as $r): ?><tr><td><span class="badge <?= $r['status'] === 'selesai' ? 'badge-soft-success' : ($r['status'] === 'dibatalkan' ? 'badge-soft-secondary' : ($r['status'] === 'dikonfirmasi' ? 'badge-soft-primary' : 'badge-soft-warning')) ?>"><?= esc($r['status']) ?></span></td><td><?= esc($r['jumlah']) ?></td></tr><?php endforeach; ?></table></div></div>
<?php endif; ?></div>
<div class="surface-card p-4 mb-3"><h3>Per Poli (tidak termasuk yang dibatalkan)</h3>
<?php if (empty($per_poli)): ?><p class="mb-0">Belum ada data per poli.</p>
<?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Poli</th><th>Jumlah</th></tr>
<?php foreach ($per_poli as $r): ?><tr><td><?= esc($r['nama_poli']) ?></td><td><?= esc($r['jumlah']) ?></td></tr><?php endforeach; ?></table></div></div>
<?php endif; ?></div>
<?= $this->include('partials/footer') ?>
