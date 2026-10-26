<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Data Jadwal Dokter</h1><p>Jadwal menentukan kuota dan antrean pasien. Tambah jadwal baru supaya pasien bisa memilih dan mendaftar.</p></div><div class="page-icon"><i class="bi bi-calendar-week"></i></div></div>
<div class="surface-card p-4 mb-3"><h3 class="h5">Ringkasan Jadwal</h3><p class="mb-0">Total jadwal (semua tanggal): <?= count($jadwal) ?>. Jadwal menentukan kuota dan antrean pasien. Tambah jadwal baru dari tombol di bawah.</p></div>
<div class="surface-card p-4 mb-3"><h2>Data Jadwal Dokter</h2><p><a class="btn btn-primary" href="/admin/jadwal/tambah">Tambah Jadwal</a></p></div>
<?php if (empty($jadwal)): ?><div class="surface-card p-4 mb-3"><h3>Belum ada jadwal.</h3><p class="mb-0">Tambah jadwal dari tombol di atas supaya pasien bisa memilih dan mendaftar.</p></div><?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Tanggal</th><th>Jam</th><th>Dokter</th><th>Poli</th><th>Kuota</th><th></th></tr>
<?php foreach ($jadwal as $r): ?><tr><td><?= esc($r['tanggal']) ?></td><td><?= esc($r['jam_mulai']) ?> - <?= esc($r['jam_selesai']) ?></td><td><?= esc($r['nama_dokter']) ?></td><td><?= esc($r['nama_poli']) ?></td><td><?= esc($r['kuota']) ?></td>
<td><a href="/admin/jadwal/ubah/<?= esc($r['id_jadwal']) ?>">Ubah</a>
<form action="/admin/jadwal/hapus/<?= esc($r['id_jadwal']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="btn btn-danger" type="submit" onclick="return confirm('Hapus jadwal ini?')">Hapus</button></form></td></tr>
<?php endforeach; ?></table></div></div>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
