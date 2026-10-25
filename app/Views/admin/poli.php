<?= $this->include('partials/header') ?>
<div class="card"><h2>Data Poli</h2><p><a class="btn" href="/admin/poli/tambah">Tambah Poli</a></p></div>
<table><tr><th>Nama Poli</th><th>Deskripsi</th><th></th></tr>
<?php foreach ($poli as $r): ?><tr><td><?= esc($r['nama_poli']) ?></td><td><?= esc($r['deskripsi']) ?></td>
<td><a href="/admin/poli/ubah/<?= esc($r['id_poli']) ?>">Ubah</a>
<form action="/admin/poli/hapus/<?= esc($r['id_poli']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="btn btn-danger" type="submit" onclick="return confirm('Hapus poli ini?')">Hapus</button></form></td></tr>
<?php endforeach; ?></table>
<?= $this->include('partials/footer') ?>
