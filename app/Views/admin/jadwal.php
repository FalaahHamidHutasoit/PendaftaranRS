<?= $this->include('partials/header') ?>
<div class="card"><h2>Data Jadwal Dokter</h2><p><a class="btn" href="/admin/jadwal/tambah">Tambah Jadwal</a></p></div>
<table><tr><th>Tanggal</th><th>Jam</th><th>Dokter</th><th>Poli</th><th>Kuota</th><th></th></tr>
<?php foreach ($jadwal as $r): ?><tr><td><?= esc($r['tanggal']) ?></td><td><?= esc($r['jam_mulai']) ?> - <?= esc($r['jam_selesai']) ?></td><td><?= esc($r['nama_dokter']) ?></td><td><?= esc($r['nama_poli']) ?></td><td><?= esc($r['kuota']) ?></td>
<td><a href="/admin/jadwal/ubah/<?= esc($r['id_jadwal']) ?>">Ubah</a>
<form action="/admin/jadwal/hapus/<?= esc($r['id_jadwal']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="btn btn-danger" type="submit" onclick="return confirm('Hapus jadwal ini?')">Hapus</button></form></td></tr>
<?php endforeach; ?></table>
<?= $this->include('partials/footer') ?>
