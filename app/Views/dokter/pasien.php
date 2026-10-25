<?= $this->include('partials/header') ?>
<div class="card"><h2>Pasien Terjadwal Saya</h2></div>
<table><tr><th>Tanggal</th><th>Pasien (No. RM)</th><th>Antrean</th><th>Status</th><th>Rekam Medis</th></tr>
<?php foreach ($pendaftaran as $r): ?><tr><td><?= esc($r['tanggal']) ?> <?= esc($r['jam_mulai']) ?></td><td><?= esc($r['nama_pasien']) ?> (<?= esc($r['no_rm']) ?>)</td><td><?= esc($r['no_antrean']) ?></td><td><?= esc($r['status']) ?></td>
<td><?php if ($r['status'] === 'selesai'): ?><a href="/dokter/rekam-medis/buat/<?= esc($r['id_pendaftaran']) ?>">Buat / Lihat</a><?php else: ?>Menunggu status selesai<?php endif; ?></td></tr>
<?php endforeach; ?></table>
<?= $this->include('partials/footer') ?>
