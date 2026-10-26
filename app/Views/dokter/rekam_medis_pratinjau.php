<?= $this->include('partials/header') ?>
<?php
// v7: Pratinjau konfirmasi — halaman ini TIDAK menyimpan apa pun.
// Simpan hanya terjadi pada POST konfirmasi kedua (tombol di bawah).
$ttvTampil = [];
foreach ($ttv_ranges as $field => $spec) {
    $val = $nilai[$field] ?? null;
    $ttvTampil[] = esc($spec['label']) . ': ' . ($val === null || $val === '' ? '-' : esc((string) $val) . ' ' . esc($spec['satuan']));
}
$diagTampil = ! empty($nilai['kode_diagnosis'])
    ? esc($nilai['kode_diagnosis']) . ' — ' . esc($diagnosis_list[$nilai['kode_diagnosis']] ?? $nilai['diagnosis'])
    : esc($nilai['diagnosis']);
?>
<div class="page-heading"><div><h1>Pratinjau Rekam Medis</h1><p>Periksa kembali persis apa yang akan disimpan. Bila ada yang salah, kembali dan perbaiki — belum ada yang tersimpan.</p></div><div class="page-icon"><i class="bi bi-eye"></i></div></div>

<div class="surface-card p-4 mb-3">
<h2 class="h5">Kunjungan</h2>
<p class="mb-1"><strong>Pasien:</strong> <?= esc($pendaftaran['nama_pasien']) ?> (<?= esc($pendaftaran['no_rm']) ?>)</p>
<p class="mb-1"><strong>Poli / Dokter:</strong> <?= esc($pendaftaran['nama_poli']) ?> / <?= esc($pendaftaran['nama_dokter']) ?></p>
<p class="mb-1"><strong>Tanggal jadwal:</strong> <?= esc($pendaftaran['tanggal']) ?> pukul <?= esc($pendaftaran['jam_mulai']) ?> - <?= esc($pendaftaran['jam_selesai']) ?></p>
<p class="mb-0"><strong>Kode Antrean:</strong> <?= esc($pendaftaran['kode_antrean'] ?? $pendaftaran['no_antrean']) ?> &nbsp;|&nbsp; <strong>Kode Booking:</strong> <?= esc($pendaftaran['kode_booking'] ?? '-') ?></p>
</div>

<div class="surface-card p-4 mb-3">
<p class="mb-1"><strong>Tanggal Periksa:</strong> <?= esc($nilai['tanggal_periksa']) ?></p>
<h2 class="h5 mt-3">S — Subjektif</h2>
<p class="mb-1"><strong>Keluhan:</strong> <?= esc($nilai['keluhan']) ?></p>
<p class="mb-3"><strong>Alergi:</strong> <?= esc($nilai['alergi'] ?? '-') ?></p>
<h2 class="h5">O — Objektif</h2>
<p class="mb-1"><strong>Tanda Vital:</strong> <?= implode(' &nbsp;|&nbsp; ', $ttvTampil) ?></p>
<p class="mb-3"><strong>Pemeriksaan Fisik:</strong> <?= esc($nilai['pemeriksaan_fisik'] ?? '-') ?></p>
<h2 class="h5">A — Asesmen</h2>
<p class="mb-3"><strong>Diagnosis:</strong> <?= $diagTampil ?></p>
<h2 class="h5">P — Plan</h2>
<p class="mb-1"><strong>Tindakan:</strong> <?= esc($nilai['tindakan'] ?? '-') ?></p>
<p class="mb-1"><strong>Resep:</strong></p>
<?php if (! empty($nilai['resep_lines'])): ?><ul class="mb-1"><?php foreach ($nilai['resep_lines'] as $baris): ?><li><?= esc($baris['obat']) ?> — <?= esc($baris['dosis']) ?> — <?= esc($baris['frekuensi']) ?><?= $baris['jumlah'] !== '' ? ' — ' . esc($baris['jumlah']) : '' ?><?= $baris['aturan'] !== '' ? ' — ' . esc($baris['aturan']) : '' ?></li><?php endforeach; ?></ul>
<?php else: ?><p class="mb-1"><?= esc($nilai['resep'] ?? '-') ?></p><?php endif; ?>
<p class="mb-1"><strong>Rencana Tindak Lanjut:</strong> <?= esc($nilai['rencana'] ?? '-') ?></p>
<p class="mb-0"><strong>Catatan:</strong> <?= esc($nilai['catatan'] ?? '-') ?></p>
</div>

<?php
// Field tersembunyi untuk kedua langkah berikutnya (simpan & kembali).
// Nilai yang sama persis yang ditampilkan di atas dikirim ulang, dan
// validasi server dijalankan lagi di langkah simpan.
$hidden = function () use ($nilai, $pendaftaran) {
    $h = '<input type="hidden" name="id_pendaftaran" value="' . esc($pendaftaran['id_pendaftaran']) . '">';
    $skalar = ['tanggal_periksa', 'keluhan', 'alergi', 'ttv_sistolik', 'ttv_diastolik', 'ttv_nadi', 'ttv_napas', 'ttv_suhu', 'ttv_spo2', 'pemeriksaan_fisik', 'kode_diagnosis', 'diagnosis_bebas', 'tindakan', 'rencana', 'catatan'];
    foreach ($skalar as $f) {
        $h .= '<input type="hidden" name="' . esc($f) . '" value="' . esc((string) ($nilai[$f] ?? '')) . '">';
    }
    $h .= '<input type="hidden" name="tanpa_obat" value="' . (! empty($nilai['tanpa_obat']) ? '1' : '0') . '">';
    foreach (($nilai['resep_lines'] ?? []) as $baris) {
        foreach (['obat', 'dosis', 'frekuensi', 'jumlah', 'aturan'] as $rf) {
            $h .= '<input type="hidden" name="resep_' . $rf . '[]" value="' . esc((string) ($baris[$rf] ?? '')) . '">';
        }
    }
    return $h;
};
?>
<div class="d-grid gap-2 mb-3">
<form action="/dokter/rekam-medis/simpan" method="post"><?= csrf_field() ?><?= $hidden() ?><input type="hidden" name="pratinjau_ok" value="1"><button type="submit" class="btn btn-primary w-100">Simpan Rekam Medis</button></form>
<form action="/dokter/rekam-medis/kembali" method="post"><?= csrf_field() ?><?= $hidden() ?><button type="submit" class="btn btn-outline-primary w-100">Kembali Ubah</button></form>
</div>
<?= $this->include('partials/footer') ?>
