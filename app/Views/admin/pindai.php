<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Pindai / Cari Kode Booking</h1><p>Verifikasi kedatangan pasien untuk check-in: pindai QR, ketik kode, atau pakai pemindai USB.</p></div><div class="page-icon"><i class="bi bi-qr-code-scan"></i></div></div>

<div class="surface-card p-4 mb-3">
<h2 class="h5">Kode Booking</h2>
<p class="text-muted small mb-3">QR pasien hanya berisi kode booking ini (tanpa NIK, nama, atau diagnosis). Ketik kode, tempel hasil pindai pemindai USB lalu tekan Enter, atau tekan tombol pindai kamera di bawah.</p>
<form action="/admin/pendaftaran/pindai" method="get" id="form-pindai" class="d-flex gap-2">
<input type="text" name="kode" id="input-kode" value="<?= esc($kode ?? '') ?>" class="form-control" placeholder="Mis. 7K4P9X2Q" autofocus style="text-transform:uppercase" aria-label="Kode booking">
<button type="submit" class="btn btn-primary">Cari</button>
</form>
<p class="mt-3 mb-0"><button type="button" class="btn btn-outline-primary" id="btn-pindai">Pindai QR dengan Kamera</button></p>
<div id="reader" class="mt-3" style="display:none"></div>
<p id="pesan-pindai" class="text-danger small mt-2 mb-0" style="display:none"></p>
<p class="text-muted small mt-3 mb-0">Bila kamera tidak tersedia atau izin ditolak, form ketik di atas tetap jalan. Bila kode booking hilang, cari di Data Pendaftaran berdasarkan nama pasien + tanggal + kode antrean.</p>
</div>

<?php if (! empty($pesan)): ?><div class="alert alert-warning" role="alert"><?= esc($pesan) ?></div><?php endif; ?>

<?php if (! empty($hasil)): ?>
<div class="surface-card p-4 mb-3">
<h2 class="h5">Hasil Verifikasi</h2>
<p class="mb-1"><strong>Pasien:</strong> <?= esc($hasil['nama_pasien']) ?> (<?= esc($hasil['no_rm']) ?>)</p>
<p class="mb-1"><strong>Poli / Dokter:</strong> <?= esc($hasil['nama_poli']) ?> / <?= esc($hasil['dokter'] ?? $hasil['nama_dokter']) ?></p>
<p class="mb-1"><strong>Tanggal / Jam:</strong> <?= esc($hasil['tanggal']) ?> pukul <?= esc($hasil['jam_mulai']) ?> - <?= esc($hasil['jam_selesai']) ?></p>
<p class="mb-1"><strong>Kode Antrean:</strong> <?= esc($hasil['kode_antrean'] ?? $hasil['no_antrean']) ?> &nbsp;|&nbsp; <strong>Kode Booking:</strong> <?= esc($hasil['kode_booking'] ?? '-') ?></p>
<p class="mb-3"><strong>Status:</strong> <span class="badge <?= $hasil['status'] === 'selesai' ? 'badge-soft-success' : ($hasil['status'] === 'dibatalkan' ? 'badge-soft-secondary' : ($hasil['status'] === 'dikonfirmasi' ? 'badge-soft-primary' : 'badge-soft-warning')) ?>"><?= esc($hasil['status']) ?></span></p>
<?php if (empty($pesan) && $hasil['status'] === 'menunggu'): ?>
<p class="text-muted small">Periksa kecocokan nama di atas dengan yang disebut pasien, lalu konfirmasi check-in.</p>
<form action="/admin/pendaftaran/pindai-checkin/<?= esc($hasil['id_pendaftaran']) ?>" method="post"><?= csrf_field() ?><button type="submit" class="btn btn-primary w-100">Konfirmasi Check-in</button></form>
<?php else: ?>
<p class="mb-0"><a class="btn btn-outline-primary" href="/admin/pendaftaran">Kembali ke Data Pendaftaran</a></p>
<?php endif; ?>
</div>
<?php endif; ?>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
// Kamera HANYA diminta saat tombol ditekan (Html5Qrcode.start di dalam
// handler klik), bukan saat halaman dimuat. Bila library gagal dimuat
// atau kamera ditolak, form ketik di atas tetap jalan.
(function () {
  var btn = document.getElementById('btn-pindai');
  var readerEl = document.getElementById('reader');
  var pesanEl = document.getElementById('pesan-pindai');
  var inputEl = document.getElementById('input-kode');
  var formEl = document.getElementById('form-pindai');
  var scanner = null;
  var jalan = false;
  function gagal(msg) {
    pesanEl.textContent = msg;
    pesanEl.style.display = 'block';
    readerEl.style.display = 'none';
    jalan = false;
  }
  btn.addEventListener('click', function () {
    if (jalan) { return; }
    if (typeof Html5Qrcode === 'undefined') {
      gagal('Pustaka pemindai gagal dimuat (butuh internet). Silakan ketik kode booking di atas.');
      return;
    }
    readerEl.style.display = 'block';
    pesanEl.style.display = 'none';
    jalan = true;
    scanner = new Html5Qrcode('reader');
    scanner.start(
      { facingMode: 'environment' },
      { fps: 10, qrbox: { width: 220, height: 220 } },
      function (teks) {
        inputEl.value = teks.trim().toUpperCase();
        scanner.stop().catch(function () {});
        jalan = false;
        formEl.submit();
      },
      function () { /* abaikan frame tanpa QR */ }
    ).catch(function () {
      gagal('Kamera tidak tersedia atau izin kamera ditolak. Silakan ketik kode booking di atas.');
    });
  });
})();
</script>
<?= $this->include('partials/footer') ?>
