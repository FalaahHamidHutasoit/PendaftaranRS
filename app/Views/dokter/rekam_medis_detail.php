<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Detail Rekam Medis</h1><p>Hasil pemeriksaan pasien dalam format SOAP. Koreksi tidak menghapus nilai lama — lihat riwayat revisi di bawah.</p></div><div class="page-icon"><i class="bi bi-journal-medical"></i></div></div>
<div class="surface-card p-4 mb-3">
<p class="mb-1"><strong>Pasien:</strong> <?= esc($rekam_medis['nama_pasien']) ?> (<?= esc($rekam_medis['no_rm']) ?>)</p>
<p class="mb-1"><strong>Tanggal praktik:</strong> <?= esc($rekam_medis['tanggal']) ?> &mdash; <strong>Kode Antrean:</strong> <?= esc($rekam_medis['kode_antrean'] ?? $rekam_medis['no_antrean']) ?> &nbsp;|&nbsp; <strong>Kode Booking:</strong> <?= esc($rekam_medis['kode_booking'] ?? '-') ?></p>
<p class="mb-1"><strong>Tanggal periksa:</strong> <?= esc($rekam_medis['tanggal_periksa']) ?></p>
<h2 class="h5 mt-3">S — Subjektif</h2>
<p class="mb-1"><strong>Keluhan:</strong> <?= esc($rekam_medis['keluhan'] ?? '-') ?></p>
<p class="mb-3"><strong>Alergi:</strong> <?= esc($rekam_medis['alergi'] ?? '-') ?></p>
<h2 class="h5">O — Objektif</h2>
<p class="mb-1"><strong>Tanda Vital:</strong>
<?php
$ttv = [];
foreach (['ttv_sistolik' => 'Sistolik (mmHg)', 'ttv_diastolik' => 'Diastolik (mmHg)', 'ttv_nadi' => 'Nadi (x/menit)', 'ttv_napas' => 'Napas (x/menit)', 'ttv_suhu' => 'Suhu (°C)', 'ttv_spo2' => 'SpO2 (%)'] as $f => $label) {
    $ttv[] = esc($label) . ': ' . (($rekam_medis[$f] ?? null) === null || $rekam_medis[$f] === '' ? '-' : esc((string) $rekam_medis[$f]));
}
echo implode(' &nbsp;|&nbsp; ', $ttv);
?>
</p>
<p class="mb-3"><strong>Pemeriksaan Fisik:</strong> <?= esc($rekam_medis['pemeriksaan_fisik'] ?? '-') ?></p>
<h2 class="h5">A — Asesmen</h2>
<p class="mb-3"><strong>Diagnosis:</strong> <?= ! empty($rekam_medis['kode_diagnosis']) ? esc($rekam_medis['kode_diagnosis']) . ' — ' : '' ?><?= esc($rekam_medis['diagnosis']) ?></p>
<h2 class="h5">P — Plan</h2>
<p class="mb-1"><strong>Tindakan:</strong> <?= esc($rekam_medis['tindakan'] ?? '-') ?></p>
<p class="mb-1"><strong>Resep:</strong><br><?= nl2br(esc($rekam_medis['resep'] ?? '-')) ?></p>
<p class="mb-1"><strong>Rencana Tindak Lanjut:</strong> <?= esc($rekam_medis['rencana'] ?? '-') ?></p>
<p class="mb-3"><strong>Catatan:</strong> <?= esc($rekam_medis['catatan'] ?? '-') ?></p>
<p class="text-muted small">Akses ke halaman ini telah dicatat ke audit log.</p>
<p class="mb-0 d-flex gap-2 flex-wrap"><a class="btn btn-primary" href="/dokter/rekam-medis/ubah/<?= esc($rekam_medis['id_rekam_medis']) ?>">Koreksi Rekam Medis</a><a class="btn btn-outline-primary" href="/dokter/rekam-medis">Kembali ke Rekam Medis Saya</a></p></div>

<div class="surface-card p-4 mb-3">
<h2 class="h5">Riwayat Revisi (Koreksi)</h2>
<p class="text-muted small">Nilai lama tidak pernah dihapus. Setiap koreksi tercatat: field apa, nilai lama &rarr; nilai baru, alasan, siapa, kapan. Tidak ada tombol hapus rekam medis.</p>
<?php if (empty($revisi ?? [])): ?><p class="mb-0">Belum ada koreksi untuk rekam medis ini.</p>
<?php else: ?>
<?php
$labels = ['tanggal_periksa' => 'Tanggal periksa', 'keluhan' => 'Keluhan (S)', 'alergi' => 'Alergi', 'ttv_sistolik' => 'Tekanan darah sistolik', 'ttv_diastolik' => 'Tekanan darah diastolik', 'ttv_nadi' => 'Nadi', 'ttv_napas' => 'Laju napas', 'ttv_suhu' => 'Suhu tubuh', 'ttv_spo2' => 'SpO2', 'pemeriksaan_fisik' => 'Pemeriksaan fisik (O)', 'kode_diagnosis' => 'Kode diagnosis', 'diagnosis' => 'Diagnosis (A)', 'tindakan' => 'Tindakan (P)', 'resep' => 'Resep (P)', 'rencana' => 'Rencana tindak lanjut (P)', 'catatan' => 'Catatan'];
foreach ($revisi as $rv): ?>
<div class="border rounded p-3 mb-2">
<p class="mb-1"><strong><?= esc($labels[$rv['field']] ?? $rv['field']) ?></strong>: <?= ($rv['nilai_lama'] ?? '') === '' ? '— (kosong)' : esc($rv['nilai_lama']) ?> &rarr; <?= ($rv['nilai_baru'] ?? '') === '' ? '— (kosong)' : esc($rv['nilai_baru']) ?></p>
<p class="mb-1 small"><strong>Alasan:</strong> <?= esc($rv['alasan']) ?></p>
<p class="mb-0 small text-muted">Oleh <?= esc($rv['nama_pengubah'] ?? 'pengguna') ?> pada <?= esc($rv['created_at']) ?></p>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
<?= $this->include('partials/footer') ?>
