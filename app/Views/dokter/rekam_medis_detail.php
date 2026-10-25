<?= $this->include('partials/header') ?>
<div class="card"><h2>Detail Rekam Medis</h2>
<p>Pasien: <?= esc($rekam_medis['nama_pasien']) ?> (<?= esc($rekam_medis['no_rm']) ?>)</p>
<p>Tanggal praktik: <?= esc($rekam_medis['tanggal']) ?> — Antrean <?= esc($rekam_medis['no_antrean']) ?></p>
<p>Tanggal periksa: <?= esc($rekam_medis['tanggal_periksa']) ?></p>
<p>Diagnosis: <?= esc($rekam_medis['diagnosis']) ?></p>
<p>Tindakan: <?= esc($rekam_medis['tindakan'] ?? '-') ?></p>
<p>Resep: <?= esc($rekam_medis['resep'] ?? '-') ?></p>
<p>Catatan: <?= esc($rekam_medis['catatan'] ?? '-') ?></p>
<p class="small">Akses ke halaman ini telah dicatat ke audit log.</p>
<p><a class="btn" href="/dokter/rekam-medis">Kembali</a></p></div>
<?= $this->include('partials/footer') ?>
