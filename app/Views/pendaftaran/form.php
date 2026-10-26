<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Form Pendaftaran</h1><p>Periksa detail jadwal di bawah, lalu isi keluhan Anda untuk mendapat nomor antrean.</p></div><div class="page-icon"><i class="bi bi-pencil-square"></i></div></div>
<div class="surface-card p-4 mb-3">
<h3 class="h5">Detail Jadwal yang Dipilih</h3>
<p class="mb-1"><strong>Pasien:</strong> <?= esc($pasien['no_rm']) ?></p>
<p class="mb-1"><strong>Jadwal:</strong> <?= esc($jadwal['tanggal']) ?>, <?= esc($jadwal['jam_mulai']) ?> - <?= esc($jadwal['jam_selesai']) ?></p>
<p class="mb-0">Sisa kuota jadwal ini: <?php if ((int) $sisa_kuota > 0): ?><span class="badge badge-soft-success"><?= esc($sisa_kuota) ?></span><?php else: ?><span class="badge badge-soft-danger">Habis</span><?php endif; ?></p>
</div>
<?php if ((int) $sisa_kuota <= 0): ?><div class="surface-card p-4 mb-3"><h3>Kuota jadwal ini sudah habis</h3><p class="mb-3">Pendaftaran ke jadwal ini tidak bisa dilanjutkan. Pilih jadwal lain yang masih tersedia.</p><p class="mb-0"><a class="btn btn-primary" href="/jadwal">Kembali ke Jadwal</a></p></div>
<?php else: ?>
<div class="surface-card p-4 mb-3">
<form action="/pendaftaran/simpan" method="post"><?= csrf_field() ?>
<input type="hidden" name="id_jadwal" value="<?= esc($jadwal['id_jadwal']) ?>" class="form-control">
<div class="mb-3"><label class="form-label">Jenis Kunjungan</label><select class="form-select" name="jenis_kunjungan" required><option value="baru">Baru</option><option value="kontrol">Kontrol</option></select></div>
<div class="mb-3"><label class="form-label">Keluhan Awal</label><textarea class="form-control" name="keluhan_awal" required><?= esc(old('keluhan_awal')) ?></textarea></div>
<div class="mb-3"><label class="form-label">Nomor Rujukan (wajib untuk pasien BPJS baru)</label><input class="form-control" type="text" name="no_rujukan" value="<?= esc(old('no_rujukan')) ?>"></div>
<div class="mb-3"><label class="form-label">Faskes Perujuk (wajib untuk pasien BPJS baru)</label><input class="form-control" type="text" name="faskes_perujuk" value="<?= esc(old('faskes_perujuk')) ?>"></div>
<p><button class="btn btn-primary w-100" type="submit">Simpan Pendaftaran</button></p><p><a class="btn btn-outline-secondary w-100" href="/jadwal">Batal</a></p>
<p class="text-muted small mb-0">Setelah disimpan, nomor antrean Anda muncul besar di halaman utama dan di Pendaftaran Saya. Langkah selanjutnya: datang pada tanggal tersebut dan lakukan check-in di loket.</p>
</form></div>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
