<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Antrean &amp; Riwayat Saya</h1><p>Nomor antrean, status, dan langkah selanjutnya untuk setiap pendaftaran Anda.</p></div><div class="page-icon"><i class="bi bi-ticket-detailed"></i></div></div>
<?php if (! empty($pengingat_besok)): ?>
<div class="alert alert-info" role="alert"><h3 class="h5">Pengingat H-1 &mdash; Jadwal Anda Besok</h3>
<?php foreach ($pengingat_besok as $b): ?><p class="mb-1">Kode antrean <strong><?= esc($b['kode_antrean'] ?? $b['no_antrean']) ?></strong> &mdash; <?= esc($b['nama_dokter']) ?> / <?= esc($b['nama_poli']) ?> &mdash; <?= esc($b['tanggal']) ?> pukul <?= esc($b['jam_mulai']) ?>.</p><?php endforeach; ?>
<p class="mb-0 small">Langkah selanjutnya: datang tepat waktu besok dan lakukan check-in di loket. Pengingat ini dihitung dari tanggal jadwal, bukan tanggal daftar. Pengingat lewat email/SMS belum tersedia.</p></div>
<?php endif; ?>
<?php if (empty($pendaftaran)): ?>
<div class="surface-card p-4 mb-3"><h3>Belum ada pendaftaran</h3><p class="mb-3">Anda belum mendaftar ke jadwal mana pun. Pilih jadwal dulu, dan nomor antrean Anda akan muncul di halaman utama.</p><p class="mb-0"><a class="btn btn-primary" href="/jadwal">Pilih Jadwal</a></p></div>
<?php else: ?>
<?php foreach ($pendaftaran as $r): ?><div class="surface-card p-4 mb-3">
<div class="d-flex justify-content-between align-items-start">
<div>
<?php if (in_array($r['status'], ['menunggu', 'dikonfirmasi'], true)): ?><span class="antrean-tebal">Kode Antrean <?= esc($r['kode_antrean'] ?? $r['no_antrean']) ?></span><?php else: ?><span class="text-muted">Kode Antrean <?= esc($r['kode_antrean'] ?? $r['no_antrean']) ?></span><?php endif; ?>
<h3 class="h5 mt-2 mb-1"><?= esc($r['nama_dokter']) ?> &mdash; <?= esc($r['nama_poli']) ?></h3>
<p class="mb-1"><?= esc($r['tanggal']) ?> pukul <?= esc($r['jam_mulai']) ?> &nbsp;|&nbsp; Jenis: <?= esc($r['jenis_kunjungan']) ?></p>
<p class="mb-1 small"><strong>Kode Booking (untuk check-in):</strong> <?= esc($r['kode_booking'] ?? '-') ?></p>
</div>
<span class="badge <?= $r['status'] === 'selesai' ? 'badge-soft-success' : ($r['status'] === 'dibatalkan' ? 'badge-soft-secondary' : ($r['status'] === 'dikonfirmasi' ? 'badge-soft-primary' : 'badge-soft-warning')) ?>"><?= esc($r['status']) ?></span>
</div>
<?php if ($r['status'] === 'menunggu'): ?><p class="text-muted small mb-2">Langkah selanjutnya: datang pada tanggal tersebut dan lakukan check-in di loket. Tunjukkan QR atau kode booking Anda.</p>
<?php elseif ($r['status'] === 'dikonfirmasi'): ?><p class="text-muted small mb-2">Anda sudah check-in. Tunggu panggilan sesuai kode antrean Anda.</p>
<?php elseif ($r['status'] === 'selesai'): ?><p class="text-muted small mb-2">Pemeriksaan selesai. Rekam medis Anda dicatat oleh dokter pemeriksa.</p>
<?php else: ?><p class="text-muted small mb-2">Pendaftaran ini dibatalkan dan kuotanya sudah kembali tersedia.</p><?php endif; ?>
<?php if (in_array($r['status'], ['menunggu', 'dikonfirmasi'], true)): ?>
<form action="/pendaftaran/batal/<?= esc($r['id_pendaftaran']) ?>" method="post"><?= csrf_field() ?><button class="btn btn-outline-danger" type="submit" onclick="return confirm('Batalkan pendaftaran ini?')">Batalkan Pendaftaran Ini</button></form>
<?php endif; ?>
</div><?php endforeach; ?>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
