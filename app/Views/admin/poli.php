<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Data Poli</h1><p>Kelola poliklinik yang mengelompokkan dokter dan jadwal. Tambah poli baru, lalu tautkan dokter ke poli tersebut.</p></div><div class="page-icon"><i class="bi bi-hospital"></i></div></div>
<div class="surface-card p-4 mb-3"><h3 class="h5">Ringkasan Poli</h3><p class="mb-0">Total poli: <?= count($poli) ?>. Poli dipakai untuk mengelompokkan dokter dan jadwal. Tambah poli baru dari tombol di bawah, lalu tautkan dokter ke poli tersebut.</p></div>
<div class="surface-card p-4 mb-3"><h2>Data Poli</h2><p><a class="btn btn-primary" href="/admin/poli/tambah">Tambah Poli</a></p></div>
<?php if (empty($poli)): ?><div class="surface-card p-4 mb-3"><h3>Belum ada poli.</h3><p class="mb-0">Tambah poli baru dari tombol di atas, lalu tautkan dokter ke poli tersebut.</p></div><?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Nama Poli</th><th>Kode Antrean</th><th>Deskripsi</th><th></th></tr>
<?php foreach ($poli as $r): ?><tr><td><?= esc($r['nama_poli']) ?></td><td><strong><?= esc($r['kode_antrean'] ?? '-') ?></strong></td><td><?= esc($r['deskripsi']) ?></td>
<td><a href="/admin/poli/ubah/<?= esc($r['id_poli']) ?>">Ubah</a>
<form action="/admin/poli/hapus/<?= esc($r['id_poli']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="btn btn-danger" type="submit" onclick="return confirm('Hapus poli ini?')">Hapus</button></form></td></tr>
<?php endforeach; ?></table></div></div>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
