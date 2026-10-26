<?= $this->include('partials/header') ?>
<?php
// v7: formulir SOAP mode-aware (buat = pratinjau dulu, ubah = koreksi
// beraudit dengan alasan wajib). Header kunjungan read-only: identitas
// dan konteks TIDAK diketik ulang dokter, melainkan diambil dari booking.
$v = static function (string $k) use ($nilai): string {
    $val = $nilai[$k] ?? '';
    if ($val === null) { return ''; }
    if (is_bool($val)) { return $val ? '1' : ''; }
    return (string) $val;
};
$barisResep = $nilai['resep_lines'] ?? [];
if ($barisResep === [] && empty($nilai['tanpa_obat'])) {
    $barisResep = [['obat' => '', 'dosis' => '', 'frekuensi' => '', 'jumlah' => '', 'aturan' => '']];
}
$kodeTerpilih = $v('kode_diagnosis') !== '' ? $v('kode_diagnosis') : (! empty($nilai['diagnosis_bebas']) ? 'LAINNYA' : '');
?>
<div class="page-heading"><div><h1><?= $mode === 'ubah' ? 'Koreksi Rekam Medis' : 'Buat Rekam Medis' ?></h1><p>Formulir SOAP. Header kunjungan terisi otomatis dari booking dan tidak bisa diubah di sini.</p></div><div class="page-icon"><i class="bi bi-journal-medical"></i></div></div>

<?php if (! empty($errors)): ?><div class="alert alert-danger" role="alert"><strong>Periksa kembali isian berikut:</strong><ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

<?php if (! empty($pendaftaran)): ?>
<div class="surface-card p-4 mb-3">
<h2 class="h5">Kunjungan (otomatis dari booking, tidak bisa diedit)</h2>
<p class="mb-1"><strong>Pasien:</strong> <?= esc($pendaftaran['nama_pasien']) ?> (<?= esc($pendaftaran['no_rm']) ?>)</p>
<p class="mb-1"><strong>Poli / Dokter:</strong> <?= esc($pendaftaran['nama_poli']) ?> / <?= esc($pendaftaran['nama_dokter']) ?></p>
<p class="mb-1"><strong>Tanggal jadwal:</strong> <?= esc($pendaftaran['tanggal']) ?> pukul <?= esc($pendaftaran['jam_mulai']) ?> - <?= esc($pendaftaran['jam_selesai']) ?></p>
<p class="mb-0"><strong>Kode Antrean:</strong> <?= esc($pendaftaran['kode_antrean'] ?? $pendaftaran['no_antrean']) ?> &nbsp;|&nbsp; <strong>Kode Booking:</strong> <?= esc($pendaftaran['kode_booking'] ?? '-') ?></p>
</div>
<?php endif; ?>

<div class="surface-card p-4 mb-3">
<form action="<?= esc($aksi) ?>" method="post"><?= csrf_field() ?>
<?php if ($mode === 'buat'): ?><input type="hidden" name="id_pendaftaran" value="<?= esc($pendaftaran['id_pendaftaran']) ?>"><?php endif; ?>

<label class="form-label">Tanggal Periksa</label>
<input type="date" name="tanggal_periksa" value="<?= esc($v('tanggal_periksa')) ?>" required class="form-control mb-3">

<h2 class="h5 mt-2">S — Subjektif (keluhan pasien)</h2>
<label class="form-label">Keluhan / Anamnesis</label>
<textarea name="keluhan" required class="form-control mb-2" rows="3"><?= esc($v('keluhan')) ?></textarea>
<p class="text-muted small">Untuk pendaftaran baru, kolom ini sudah diisi dari keluhan awal pasien — periksa dan perbaiki bila perlu.</p>
<label class="form-label">Alergi (opsional)</label>
<input type="text" name="alergi" value="<?= esc($v('alergi')) ?>" class="form-control mb-3" placeholder="Mis. alergi penisilin; kosongkan bila tidak ada data">

<h2 class="h5 mt-2">O — Objektif (tanda vital &amp; pemeriksaan fisik)</h2>
<p class="text-muted small">Tanda vital opsional, tapi bila diisi harus angka dalam rentang kewajaran (pesan error spesifik per field bila di luar rentang).</p>
<div class="row">
<?php foreach ($ttv_ranges as $field => $spec): ?>
<div class="col-6 col-md-4 mb-3">
<label class="form-label"><?= esc($spec['label']) ?> (<?= esc($spec['satuan']) ?>)</label>
<input type="number" step="any" name="<?= esc($field) ?>" value="<?= esc($v($field)) ?>" class="form-control" placeholder="<?= esc($spec['min']) ?>-<?= esc($spec['max']) ?>">
</div>
<?php endforeach; ?>
</div>
<label class="form-label">Pemeriksaan Fisik (opsional)</label>
<textarea name="pemeriksaan_fisik" class="form-control mb-3" rows="3"><?= esc($v('pemeriksaan_fisik')) ?></textarea>

<h2 class="h5 mt-2">A — Asesmen (diagnosis)</h2>
<label class="form-label">Diagnosis (ICD-10 terkurasi)</label>
<select name="kode_diagnosis" class="form-select mb-2">
<option value="">— Pilih diagnosis —</option>
<?php foreach ($diagnosis_list as $kode => $label): ?><option value="<?= esc($kode) ?>" <?= $kodeTerpilih === $kode ? 'selected' : '' ?>><?= esc($kode) ?> — <?= esc($label) ?></option><?php endforeach; ?>
<option value="LAINNYA" <?= $kodeTerpilih === 'LAINNYA' ? 'selected' : '' ?>>Lainnya — tulis diagnosis sendiri</option>
</select>
<label class="form-label">Diagnosis Lainnya (diisi bila memilih Lainnya)</label>
<textarea name="diagnosis_bebas" class="form-control mb-3" rows="2"><?= esc($v('diagnosis_bebas')) ?></textarea>

<h2 class="h5 mt-2">P — Plan (tindakan, resep, tindak lanjut)</h2>
<label class="form-label">Tindakan (opsional)</label>
<textarea name="tindakan" class="form-control mb-3" rows="2"><?= esc($v('tindakan')) ?></textarea>

<label class="form-label">Resep (baris terstruktur)</label>
<div id="resep-rows">
<?php foreach ($barisResep as $baris): ?>
<div class="row resep-row mb-2">
<div class="col-12 col-md-3 mb-2"><input type="text" name="resep_obat[]" value="<?= esc($baris['obat']) ?>" class="form-control" placeholder="Nama obat"></div>
<div class="col-6 col-md-2 mb-2"><input type="text" name="resep_dosis[]" value="<?= esc($baris['dosis']) ?>" class="form-control" placeholder="Dosis (mis. 500 mg)"></div>
<div class="col-6 col-md-2 mb-2"><input type="text" name="resep_frekuensi[]" value="<?= esc($baris['frekuensi']) ?>" class="form-control" placeholder="Frekuensi (mis. 3x1)"></div>
<div class="col-6 col-md-2 mb-2"><input type="text" name="resep_jumlah[]" value="<?= esc($baris['jumlah']) ?>" class="form-control" placeholder="Jumlah (mis. 10 tablet)"></div>
<div class="col-6 col-md-3 mb-2"><input type="text" name="resep_aturan[]" value="<?= esc($baris['aturan']) ?>" class="form-control" placeholder="Aturan pakai (mis. sesudah makan)"></div>
</div>
<?php endforeach; ?>
</div>
<p><button type="button" class="btn btn-outline-primary btn-sm" id="btn-tambah-resep">Tambah Baris Resep</button></p>
<div class="form-check mb-3">
<input type="checkbox" name="tanpa_obat" value="1" class="form-check-input" id="cek-tanpa-obat" <?= ! empty($nilai['tanpa_obat']) ? 'checked' : '' ?>>
<label class="form-check-label" for="cek-tanpa-obat">Tanpa obat (bila dicentang, baris resep diabaikan dan tersimpan sebagai "Tanpa obat")</label>
</div>

<label class="form-label">Rencana Tindak Lanjut (opsional)</label>
<textarea name="rencana" class="form-control mb-3" rows="2" placeholder="Mis. kontrol 3 hari lagi, dirujuk ke poli lain, perlu pemeriksaan lab."><?= esc($v('rencana')) ?></textarea>
<label class="form-label">Catatan (opsional)</label>
<textarea name="catatan" class="form-control mb-3" rows="2"><?= esc($v('catatan')) ?></textarea>

<?php if ($mode === 'ubah'): ?>
<label class="form-label">Alasan Koreksi (wajib)</label>
<textarea name="alasan" required class="form-control mb-3" rows="2" placeholder="Jelaskan mengapa rekam medis ini dikoreksi. Alasan ini tersimpan bersama nilai lama dan nilai baru di riwayat revisi."></textarea>
<p class="text-muted small">Nilai lama tidak dihapus: setiap field yang berubah dicatat (nilai lama &rarr; nilai baru, siapa, kapan, alasan) dan dapat dilihat di halaman detail.</p>
<?php endif; ?>

<p class="mb-0">
<?php if ($mode === 'buat'): ?><button type="submit" class="btn btn-primary w-100">Lihat Pratinjau Sebelum Simpan</button>
<?php else: ?><button type="submit" class="btn btn-primary w-100">Simpan Koreksi</button><?php endif; ?>
</p>
</form></div>

<script>
(function () {
  var btn = document.getElementById('btn-tambah-resep');
  var wadah = document.getElementById('resep-rows');
  if (! btn || ! wadah) { return; }
  btn.addEventListener('click', function () {
    var row = document.createElement('div');
    row.className = 'row resep-row mb-2';
    row.innerHTML = '<div class="col-12 col-md-3 mb-2"><input type="text" name="resep_obat[]" class="form-control" placeholder="Nama obat"></div>'
      + '<div class="col-6 col-md-2 mb-2"><input type="text" name="resep_dosis[]" class="form-control" placeholder="Dosis (mis. 500 mg)"></div>'
      + '<div class="col-6 col-md-2 mb-2"><input type="text" name="resep_frekuensi[]" class="form-control" placeholder="Frekuensi (mis. 3x1)"></div>'
      + '<div class="col-6 col-md-2 mb-2"><input type="text" name="resep_jumlah[]" class="form-control" placeholder="Jumlah (mis. 10 tablet)"></div>'
      + '<div class="col-6 col-md-3 mb-2"><input type="text" name="resep_aturan[]" class="form-control" placeholder="Aturan pakai (mis. sesudah makan)"></div>';
    wadah.appendChild(row);
  });
})();
</script>
<?= $this->include('partials/footer') ?>
