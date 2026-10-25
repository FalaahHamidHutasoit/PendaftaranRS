<?= $this->include('partials/header') ?>
<div class="card"><h2>Dashboard Admisi</h2>
<p>Pasien: <?= esc($total_pasien) ?> &nbsp; Dokter: <?= esc($total_dokter) ?> &nbsp; Jadwal mendatang: <?= esc($total_jadwal) ?> &nbsp; Pendaftaran menunggu: <?= esc($menunggu) ?></p>
<p><a class="btn" href="/admin/poli">Poli</a> <a class="btn" href="/admin/dokter">Dokter</a> <a class="btn" href="/admin/jadwal">Jadwal</a> <a class="btn" href="/admin/pasien">Pasien</a> <a class="btn" href="/admin/pendaftaran">Pendaftaran</a> <a class="btn" href="/admin/rekap">Rekap</a></p>
</div>
<div class="card"><h3>Pendaftaran Terbaru</h3>
<table><tr><th>No. RM</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Status</th></tr>
<?php foreach ($terbaru as $r): ?><tr><td><?= esc($r['no_rm']) ?></td><td><?= esc($r['nama_pasien'] ?? '') ?></td><td><?= esc($r['nama_dokter']) ?></td><td><?= esc($r['tanggal']) ?></td><td><?= esc($r['status']) ?></td></tr><?php endforeach; ?></table>
</div>
<?= $this->include('partials/footer') ?>
