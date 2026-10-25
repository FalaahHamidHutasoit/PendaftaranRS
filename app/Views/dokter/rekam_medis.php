<?= $this->include('partials/header') ?>
<div class="card"><h2>Rekam Medis Saya</h2></div>
<table><tr><th>Tanggal Periksa</th><th>Pasien (No. RM)</th><th>Antrean</th><th>Diagnosis</th><th></th></tr>
<?php foreach ($rekam_medis as $r): ?><tr><td><?= esc($r['tanggal_periksa']) ?></td><td><?= esc($r['nama_pasien']) ?> (<?= esc($r['no_rm']) ?>)</td><td><?= esc($r['no_antrean']) ?></td><td><?= esc($r['diagnosis']) ?></td><td><a class="btn" href="/dokter/rekam-medis/lihat/<?= esc($r['id_rekam_medis']) ?>">Lihat</a></td></tr>
<?php endforeach; ?></table>
<p class="small">Membuka detail rekam medis dicatat ke audit log (siapa, kapan, pendaftaran mana).</p>
<?= $this->include('partials/footer') ?>
