<?= $this->include('partials/header') ?>
<?php $isPasien = session()->get('role') === 'pasien'; ?>
<?php if ($isPasien): ?>
<div class="page-heading"><div><h1>Selamat datang, <?= esc($nama ?: 'Pasien') ?></h1><p>Ini halaman utama Anda — antrean aktif dan jalan pintas ke semua fitur ada di sini.</p></div><div class="page-icon"><i class="bi bi-house-door"></i></div></div>
<?php if (! empty($antrean_aktif ?? [])): ?>
<p class="text-muted small fw-bold text-uppercase mb-2">Antrean Saya</p>
<?php foreach ($antrean_aktif as $a): ?><div class="hero-antrean p-4 mb-3">
<div class="d-flex flex-column flex-md-row gap-3 align-items-start">
<div class="flex-grow-1 min-w-0">
<p class="small mb-1 opacity-75">Kode antrean Anda yang masih aktif</p>
<span class="hero-num"><?= esc($a['kode_antrean'] ?? ('No. ' . $a['no_antrean'])) ?></span>
<p class="mb-1 mt-2"><strong><?= esc($a['nama_dokter']) ?></strong> (<?= esc($a['spesialisasi']) ?>) &mdash; <?= esc($a['nama_poli']) ?></p>
<p class="mb-2"><?= esc($a['tanggal']) ?> pukul <?= esc($a['jam_mulai']) ?> - <?= esc($a['jam_selesai']) ?></p>
<p class="mb-3"><span class="badge hero-badge"><?= esc($a['status'] === 'dikonfirmasi' ? 'Dikonfirmasi · Sudah check-in' : 'Menunggu') ?></span> &nbsp; <span class="small"><?= esc($a['jenis_kunjungan']) ?></span></p>
<?php if ($a['status'] === 'dikonfirmasi'): ?>
<p class="small mb-3">Langkah selanjutnya: Anda sudah check-in. Datang sesuai jadwal dan tunggu dipanggil sesuai kode antrean ini.</p>
<?php else: ?>
<p class="small mb-3">Langkah selanjutnya: datang pada tanggal tersebut dan lakukan check-in di loket. Tunjukkan QR atau kode booking di samping ini saat check-in.</p>
<?php endif; ?>
</div>
<div class="bg-white rounded p-2 text-center flex-shrink-0" style="border-radius:14px">
<div id="qr-<?= esc($a['id_pendaftaran']) ?>"></div>
<p class="mb-0 mt-2 small fw-bold" style="color:#0b63d8">Kode Booking<br><?= esc($a['kode_booking'] ?? '-') ?></p>
<p class="mb-0 small text-muted">Tunjukkan ke admisi saat check-in</p>
</div>
</div>
<p class="mb-0 mt-3"><a class="btn btn-light w-100" href="/pendaftaran">Lihat Detail di Antrean Saya</a></p>
</div><?php endforeach; ?>
<?php if (! empty($antrean_aktif)): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
// v7: QR hanya berisi teks kode booking saja — tanpa NIK, nama,
// diagnosis, atau URL. Bila library gagal dimuat, kode booking teks
// di bawah QR tetap tampil sehingga check-in manual tetap bisa.
(function () {
  if (typeof QRCode === 'undefined') { return; }
  <?php foreach ($antrean_aktif as $a): ?>
  <?php if (! empty($a['kode_booking'])): ?>
  new QRCode(document.getElementById('qr-<?= esc($a['id_pendaftaran']) ?>'), {
    text: <?= json_encode($a['kode_booking']) ?>,
    width: 128, height: 128, correctLevel: QRCode.CorrectLevel.H
  });
  <?php endif; ?>
  <?php endforeach; ?>
})();
</script>
<?php endif; ?>
<?php else: ?>
<div class="hero-empty p-4 mb-3">
<h2 class="h5">Belum ada antrean aktif</h2>
<p class="mb-3 text-muted">Pilih jadwal dokter, daftar, dan nomor antrean Anda akan terpampang di sini sebagai kartu utama selama masih aktif.</p>
<p class="mb-0"><a class="btn btn-primary w-100" href="/jadwal">Pilih Jadwal</a></p>
</div>
<?php endif; ?>
<h2 class="h5 mt-4 mb-2">Fitur</h2>
<div class="quick-grid mb-4">
<a class="quick-item" href="/jadwal"><span class="qicon"><i class="bi bi-calendar-check"></i></span>Daftar Jadwal</a>
<a class="quick-item" href="/pendaftaran"><span class="qicon"><i class="bi bi-ticket-detailed"></i></span>Antrean Saya<?php if (! empty($jumlah_aktif)): ?> <span class="badge badge-soft-primary"><?= esc($jumlah_aktif) ?></span><?php endif; ?></a>
<a class="quick-item" href="/profil"><span class="qicon"><i class="bi bi-person"></i></span>Profil</a>
</div>
<?php else: ?>
<div class="page-heading"><div><h1>Selamat datang di Pendaftaran Pasien</h1><p>Daftar ke jadwal dokter secara online — tanpa antre di loket hanya untuk mendaftar.</p></div><div class="page-icon"><i class="bi bi-house-door"></i></div></div>
<div class="surface-card p-4 mb-4">
<h2 class="h5">Mulai dari sini</h2>
<p class="text-muted mb-3">Lihat jadwal dokter yang tersedia, daftar secara online, lalu datang pada tanggalnya untuk check-in di loket.</p>
<p class="d-grid gap-2 mb-0"><a class="btn btn-primary w-100" href="/jadwal">Lihat Jadwal</a><a class="btn btn-outline-primary w-100" href="/login">Masuk</a><a class="btn btn-outline-secondary w-100" href="/registrasi">Registrasi Pasien Baru</a></p>
</div>
<h2 class="h5 mt-4 mb-2">Fitur</h2>
<div class="quick-grid mb-4">
<a class="quick-item" href="/jadwal"><span class="qicon"><i class="bi bi-calendar-check"></i></span>Lihat Jadwal</a>
<a class="quick-item" href="/login"><span class="qicon"><i class="bi bi-box-arrow-in-right"></i></span>Masuk</a>
<a class="quick-item" href="/registrasi"><span class="qicon"><i class="bi bi-person-plus"></i></span>Registrasi</a>
</div>
<?php endif; ?>
<div class="surface-card p-4 mb-3">
<h2 class="h5">Cara memakai aplikasi ini</h2>
<ol class="mb-0 ps-3">
<li class="mb-2"><strong>Daftar</strong> ke jadwal dokter yang masih tersedia.</li>
<li class="mb-2"><strong>Datang</strong> pada tanggal jadwal Anda.</li>
<li class="mb-2"><strong>Check-in di loket</strong> — tunjukkan QR atau kode booking Anda, admisi mengonfirmasi kehadiran Anda.</li>
<li class="mb-2"><strong>Selesai diperiksa</strong> — kartu antrean Anda hilang dari halaman ini, dan riwayat lengkapnya tetap ada di Antrean Saya.</li>
<li><strong>Rekam medis</strong> dicatat oleh dokter pemeriksa setelah pemeriksaan selesai.</li>
</ol>
</div>
<?= $this->include('partials/footer') ?>
