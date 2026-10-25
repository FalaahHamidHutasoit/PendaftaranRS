<?= $this->include('partials/header') ?>
<div class="card">
<h2>Form Pendaftaran</h2>
<p><strong>Pasien:</strong> <?= esc($pasien['no_rm']) ?> &nbsp; <strong>Sisa kuota jadwal ini:</strong> <?= esc($sisa_kuota) ?></p>
<p class="small">Jadwal: <?= esc($jadwal['tanggal']) ?>, <?= esc($jadwal['jam_mulai']) ?> - <?= esc($jadwal['jam_selesai']) ?>.</p>
<?php if ((int) $sisa_kuota <= 0): ?><p>Kuota jadwal ini sudah habis.</p>
<?php else: ?>
<form action="/pendaftaran/simpan" method="post"><?= csrf_field() ?>
<input type="hidden" name="id_jadwal" value="<?= esc($jadwal['id_jadwal']) ?>">
<label>Jenis Kunjungan</label><select name="jenis_kunjungan" required><option value="baru">Baru</option><option value="kontrol">Kontrol</option></select>
<label>Keluhan Awal</label><textarea name="keluhan_awal" required><?= esc(old('keluhan_awal')) ?></textarea>
<label>Nomor Rujukan (wajib untuk pasien BPJS baru)</label><input type="text" name="no_rujukan" value="<?= esc(old('no_rujukan')) ?>">
<label>Faskes Perujuk (wajib untuk pasien BPJS baru)</label><input type="text" name="faskes_perujuk" value="<?= esc(old('faskes_perujuk')) ?>">
<p><button type="submit">Simpan Pendaftaran</button></p>
</form>
<?php endif; ?>
</div>
<?= $this->include('partials/footer') ?>
