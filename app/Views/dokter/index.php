<?= $this->include('partials/header') ?>
<div class="card"><h2>Jadwal Saya</h2><p>Dokter: <?= esc($dokter['nama_dokter']) ?> (<?= esc($dokter['spesialisasi']) ?>)</p>
<p><a class="btn" href="/dokter/pasien">Pasien Terjadwal</a> <a class="btn" href="/dokter/rekam-medis">Rekam Medis Saya</a></p></div>
<table><tr><th>Tanggal</th><th>Jam</th><th>Kuota</th><th></th></tr>
<?php foreach ($jadwal as $j): ?><tr><td><?= esc($j['tanggal']) ?></td><td><?= esc($j['jam_mulai']) ?> - <?= esc($j['jam_selesai']) ?></td><td><?= esc($j['kuota']) ?></td><td><a href="/dokter/jadwal/ubah/<?= esc($j['id_jadwal']) ?>">Ubah</a></td></tr>
<?php endforeach; ?></table>
<?= $this->include('partials/footer') ?>
