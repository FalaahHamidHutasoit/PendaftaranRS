<?= $this->include('partials/header') ?>
<div class="card"><h2>Data Dokter</h2><p><a class="btn" href="/admin/dokter/tambah">Tambah Dokter</a></p></div>
<div class="card"><h3>Tambah Akun Login Dokter</h3><p class="small">Akun dibuat dengan peran dokter, lalu ditautkan ke data dokter lewat form Tambah/Ubah Dokter di atas. Kata sandi akun baru wajib diganti oleh dokter setelah login pertama.</p>
<form action="/admin/dokter/akun" method="post"><?= csrf_field() ?>
<label>Nama Akun</label><input type="text" name="nama" required>
<label>Email Akun</label><input type="email" name="email" required>
<label>Kata Sandi (minimal 8 karakter)</label><input type="password" name="password" required>
<p><button type="submit">Buat Akun Dokter</button></p></form></div>
<table><tr><th>Nama Dokter</th><th>Spesialisasi</th><th>Poli</th><th>Akun Login</th><th></th></tr>
<?php foreach ($dokter as $r): ?><tr><td><?= esc($r['nama_dokter']) ?></td><td><?= esc($r['spesialisasi']) ?></td><td><?= esc($r['nama_poli']) ?></td><td><?= esc($r['nama_akun'] ?? '-') ?></td>
<td><a href="/admin/dokter/ubah/<?= esc($r['id_dokter']) ?>">Ubah</a>
<form action="/admin/dokter/hapus/<?= esc($r['id_dokter']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="btn btn-danger" type="submit" onclick="return confirm('Hapus dokter ini?')">Hapus</button></form></td></tr>
<?php endforeach; ?></table>
<?= $this->include('partials/footer') ?>
