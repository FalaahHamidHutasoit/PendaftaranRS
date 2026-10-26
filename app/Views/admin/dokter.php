<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Data Dokter</h1><p>Kelola data dokter dan akun loginnya. Dokter tanpa akun belum bisa login ke sistem.</p></div><div class="page-icon"><i class="bi bi-person-badge"></i></div></div>
<div class="surface-card p-4 mb-3"><h3 class="h5">Ringkasan Dokter</h3><p class="mb-0">Total dokter: <?= count($dokter) ?>. Buat dulu akun login dokter di bawah, lalu tautkan akun itu ke data dokter lewat form Tambah/Ubah Dokter. Dokter tanpa akun belum bisa login.</p></div>
<div class="surface-card p-4 mb-3"><h2>Data Dokter</h2><p><a class="btn btn-primary" href="/admin/dokter/tambah">Tambah Dokter</a></p></div>
<div class="surface-card p-4 mb-3"><h3>Tambah Akun Login Dokter</h3><p class="text-muted small">Akun dibuat dengan peran dokter, lalu ditautkan ke data dokter lewat form Tambah/Ubah Dokter di atas. Kata sandi akun baru wajib diganti oleh dokter setelah login pertama.</p>
<form action="/admin/dokter/akun" method="post"><?= csrf_field() ?>
<label class="form-label">Nama Akun</label><input type="text" name="nama" required class="form-control">
<label class="form-label">Email Akun</label><input type="email" name="email" required class="form-control">
<label class="form-label">Kata Sandi (minimal 8 karakter)</label><input type="password" name="password" required class="form-control">
<p><button type="submit" class="btn btn-primary">Buat Akun Dokter</button></p></form></div>
<?php if (empty($dokter)): ?><div class="surface-card p-4 mb-3"><h3>Belum ada dokter.</h3><p class="mb-0">Tambah dokter dari tombol di atas, dan buat akun login dokter bila dokter tersebut perlu login.</p></div><?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Nama Dokter</th><th>Spesialisasi</th><th>Poli</th><th>Akun Login</th><th></th></tr>
<?php foreach ($dokter as $r): ?><tr><td><?= esc($r['nama_dokter']) ?></td><td><?= esc($r['spesialisasi']) ?></td><td><?= esc($r['nama_poli']) ?></td><td><?= esc($r['nama_akun'] ?? '-') ?></td>
<td><a href="/admin/dokter/ubah/<?= esc($r['id_dokter']) ?>">Ubah</a>
<form action="/admin/dokter/hapus/<?= esc($r['id_dokter']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="btn btn-danger" type="submit" onclick="return confirm('Hapus dokter ini?')">Hapus</button></form></td></tr>
<?php endforeach; ?></table></div></div>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
