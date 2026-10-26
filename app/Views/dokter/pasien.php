<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Pasien Terjadwal Saya</h1><p>Pasien yang mendaftar ke jadwal Anda, diurutkan tanggal lalu nomor antrean. Rekam medis hanya bisa dibuat setelah status menjadi selesai.</p></div><div class="page-icon"><i class="bi bi-people"></i></div></div>
<div class="surface-card p-4 mb-3"><h3 class="h5">Ringkasan Pasien Terjadwal</h3><p class="mb-0">Total pendaftaran terjadwal Anda (bukan dibatalkan): <?= count($pendaftaran) ?>, diurutkan tanggal lalu nomor antrean. Rekam medis hanya bisa dibuat setelah status pendaftaran menjadi selesai.</p></div>
<div class="surface-card p-4 mb-3"><h2>Pasien Terjadwal Saya</h2></div>
<?php if (empty($pendaftaran)): ?><div class="surface-card p-4 mb-3"><h3>Belum ada pasien terjadwal.</h3><p class="mb-0">Pasien terjadwal muncul di sini setelah pasien mendaftar ke jadwal Anda dan belum dibatalkan.</p></div><?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Tanggal</th><th>Pasien (No. RM)</th><th>Kode Antrean</th><th>Status</th><th>Rekam Medis</th></tr>
<?php foreach ($pendaftaran as $r): ?><tr><td><?= esc($r['tanggal']) ?> <?= esc($r['jam_mulai']) ?></td><td><?= esc($r['nama_pasien']) ?> (<?= esc($r['no_rm']) ?>)</td><td><strong><?= esc($r['kode_antrean'] ?? $r['no_antrean']) ?></strong></td><td><span class="badge <?= $r['status'] === 'selesai' ? 'badge-soft-success' : ($r['status'] === 'dibatalkan' ? 'badge-soft-secondary' : ($r['status'] === 'dikonfirmasi' ? 'badge-soft-primary' : 'badge-soft-warning')) ?>"><?= esc($r['status']) ?></span></td>
<td><?php if ($r['status'] === 'selesai'): ?><a href="/dokter/rekam-medis/buat/<?= esc($r['id_pendaftaran']) ?>">Buat / Lihat</a><?php else: ?>Menunggu status selesai<?php endif; ?></td></tr>
<?php endforeach; ?></table></div></div>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
