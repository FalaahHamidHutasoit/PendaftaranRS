<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Jadwal Dokter</h1><p>Pilih jadwal dokter yang masih tersedia. Nomor antrean aktif Anda ada di Beranda.</p></div><div class="page-icon"><i class="bi bi-calendar-check"></i></div></div>
<h2 class="h5 mt-1 mb-1" id="daftar-jadwal">Jadwal Dokter Mendatang</h2>
<p class="text-muted small mb-3">Pilih jadwal, lihat sisa kuotanya, lalu daftar. Sisa kuota = kuota jadwal dikurangi pendaftaran yang statusnya bukan dibatalkan.</p>
<?php if (empty($jadwal)): ?>
<div class="surface-card p-4 mb-3"><h3 class="h5">Belum ada jadwal mendatang</h3><p class="mb-0">Saat ini belum ada jadwal yang bisa dipilih. Silakan kembali lagi nanti atau hubungi admisi.</p></div>
<?php else: ?>
<?php foreach ($jadwal as $j): ?><div class="surface-card p-3 mb-3">
<div class="d-flex gap-3">
<div class="list-icon"><i class="bi bi-calendar-check"></i></div>
<div class="flex-grow-1 min-w-0">
<p class="text-muted small mb-1"><?= esc($j['tanggal']) ?> &bull; <?= esc($j['jam_mulai']) ?> - <?= esc($j['jam_selesai']) ?></p>
<h3 class="h6 mb-1"><?= esc($j['nama_dokter']) ?> <small class="text-muted">(<?= esc($j['spesialisasi']) ?>)</small></h3>
<p class="mb-2 small"><?= esc($j['nama_poli']) ?></p>
<p class="mb-0">Sisa kuota: <?php if ((int) $j['sisa_kuota'] > 0): ?><span class="badge badge-soft-success"><?= esc($j['sisa_kuota']) ?> dari <?= esc($j['kuota']) ?></span><?php else: ?><span class="badge badge-soft-secondary">Penuh (0 dari <?= esc($j['kuota']) ?>)</span><?php endif; ?></p>
</div>
</div>
<?php if ((int) $j['sisa_kuota'] > 0): ?><p class="mt-3 mb-0"><a class="btn btn-primary w-100" href="/pendaftaran/buat/<?= esc($j['id_jadwal']) ?>">Daftar ke Jadwal Ini</a></p><?php else: ?><p class="text-muted small mb-0 mt-3">Jadwal ini sudah penuh. Pilih jadwal lain.</p><?php endif; ?>
</div><?php endforeach; ?>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
