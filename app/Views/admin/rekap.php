<?= $this->include('partials/header') ?>
<div class="card"><h2>Rekap Admisi</h2>
<p>Total pendaftaran aktif (bukan dibatalkan): <?= esc($total_aktif) ?> &nbsp;|&nbsp; Pasien BPJS menunggu verifikasi: <?= esc($bpjs_menunggu) ?></p></div>
<div class="card"><h3>Per Status</h3>
<table><tr><th>Status</th><th>Jumlah</th></tr>
<?php foreach ($per_status as $r): ?><tr><td><?= esc($r['status']) ?></td><td><?= esc($r['jumlah']) ?></td></tr><?php endforeach; ?></table></div>
<div class="card"><h3>Per Poli (tidak termasuk yang dibatalkan)</h3>
<table><tr><th>Poli</th><th>Jumlah</th></tr>
<?php foreach ($per_poli as $r): ?><tr><td><?= esc($r['nama_poli']) ?></td><td><?= esc($r['jumlah']) ?></td></tr><?php endforeach; ?></table></div>
<?= $this->include('partials/footer') ?>
