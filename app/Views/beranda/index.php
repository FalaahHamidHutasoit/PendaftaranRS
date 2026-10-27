<?= $this->include('partials/header') ?>
<?php $isPasien = session()->get('role') === 'pasien'; ?>
<?php if ($isPasien): ?>
<div class="page-heading"><div><h1>Selamat datang, <?= esc($nama ?: 'Pasien') ?></h1><p>Ini halaman utama Anda — antrean aktif dan jalan pintas ke semua fitur ada di sini.</p></div><div class="page-icon"><i class="bi bi-house-door"></i></div></div>
<?php if (! empty($antrean_aktif ?? [])): ?>
<p class="text-muted small fw-bold text-uppercase mb-2">Antrean Saya</p>
<?php $bulanId = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember']; ?>
<?php foreach ($antrean_aktif as $a): ?><?php $tsJadwal = strtotime($a['tanggal'] ?? ''); $tglId = $tsJadwal ? date('d', $tsJadwal) . ' ' . $bulanId[(int) date('n', $tsJadwal)] . ' ' . date('Y', $tsJadwal) : ($a['tanggal'] ?? ''); $jamId = substr((string) ($a['jam_mulai'] ?? ''), 0, 5) . '–' . substr((string) ($a['jam_selesai'] ?? ''), 0, 5); ?><div class="hero-antrean p-4 mb-3">
<div class="d-flex flex-row gap-3 align-items-center">
<div class="flex-grow-1 min-w-0">
<p class="mb-2"><span class="badge hero-badge"><?= esc($a['status'] === 'dikonfirmasi' ? 'Dikonfirmasi · Sudah check-in' : 'Menunggu') ?></span></p>
<span class="hero-num"><?= esc($a['kode_antrean'] ?? ('No. ' . $a['no_antrean'])) ?></span>
<p class="mb-0 mt-2"><?= esc($a['nama_poli']) ?> &middot; <?= esc($tglId) ?> &middot; <?= esc($jamId) ?></p>
</div>
<button type="button" class="btn btn-light flex-shrink-0 d-flex flex-column align-items-center px-3 py-2" data-bs-toggle="modal" data-bs-target="#qrModal-<?= esc($a['id_pendaftaran']) ?>" aria-label="Tampilkan QR check-in" title="Tampilkan QR check-in"><i class="bi bi-qr-code-scan fs-3"></i><span class="small">QR</span></button>
</div>
<p class="mb-0 mt-3"><a class="btn btn-light w-100" href="/pendaftaran">Lihat Detail di Antrean Saya</a></p>
</div>
<div class="modal fade" id="qrModal-<?= esc($a['id_pendaftaran']) ?>" tabindex="-1" aria-labelledby="qrModalLabel-<?= esc($a['id_pendaftaran']) ?>" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm"><div class="modal-content text-dark">
<div class="modal-header"><h5 class="modal-title" id="qrModalLabel-<?= esc($a['id_pendaftaran']) ?>">QR Check-in</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
<div class="modal-body text-center">
<div id="qr-modal-<?= esc($a['id_pendaftaran']) ?>" class="d-flex justify-content-center"></div>
<p class="mb-0 mt-3 fw-bold">Kode Booking<br><span style="font-size:1.25rem"><?= esc($a['kode_booking'] ?? '-') ?></span></p>
<p class="mb-0 small text-muted">Tunjukkan QR ini ke admisi saat check-in. Bila QR tidak terbaca, sebutkan kode booking di atas.</p>
</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Tutup</button></div>
</div></div>
</div><?php endforeach; ?>
<?php if (! empty($antrean_aktif)): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
// QR hero v9: di hero hanya ikon QR; QR besar hanya ada di dalam
// modal yang dibuka lewat ikon itu. Isi QR tetap teks kode booking
// saja — tanpa NIK, nama, diagnosis, atau URL. Bila library gagal
// dimuat, kode booking teks di dalam modal tetap tampil sehingga
// check-in manual tetap bisa.
(function () {
  if (typeof QRCode === 'undefined') { return; }
  <?php foreach ($antrean_aktif as $a): ?>
  <?php if (! empty($a['kode_booking'])): ?>
  new QRCode(document.getElementById('qr-modal-<?= esc($a['id_pendaftaran']) ?>'), {
    text: <?= json_encode($a['kode_booking']) ?>,
    width: 200, height: 200, correctLevel: QRCode.CorrectLevel.H
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
