<?= $this->include('partials/header') ?>
<div class="card"><h2>Data Pasien &amp; Verifikasi BPJS</h2></div>
<table><tr><th>No. RM</th><th>Nama</th><th>Jalur</th><th>Status BPJS</th><th>Verifikasi</th></tr>
<?php foreach ($pasien as $r): ?><tr><td><?= esc($r['no_rm']) ?></td><td><?= esc($r['nama']) ?></td><td><?= esc($r['jenis_pasien']) ?></td><td><?= esc($r['status_bpjs']) ?></td>
<td><?php if ($r['jenis_pasien'] === 'bpjs'): ?>
<form action="/admin/pasien/bpjs/<?= esc($r['id_pasien']) ?>" method="post"><?= csrf_field() ?>
<select name="status_bpjs"><option value="menunggu">Menunggu</option><option value="terverifikasi">Terverifikasi</option><option value="ditolak">Ditolak</option></select>
<input type="text" name="catatan_bpjs" placeholder="Catatan (opsional)">
<button type="submit">Simpan</button></form>
<?php else: ?>-<?php endif; ?></td></tr>
<?php endforeach; ?></table>
<?= $this->include('partials/footer') ?>
