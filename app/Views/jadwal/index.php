<?= $this->include('partials/header') ?>
<div class="card">
<h2>Jadwal Dokter Mendatang</h2>
<p class="small">Sisa kuota = kuota jadwal dikurangi pendaftaran yang statusnya bukan dibatalkan.</p>
</div>
<?php if (empty($jadwal)): ?><div class="card">Belum ada jadwal mendatang.</div>
<?php else: ?>
<table><tr><th>Tanggal</th><th>Jam</th><th>Poliklinik</th><th>Dokter</th><th>Kuota</th><th>Sisa</th><th></th></tr>
<?php foreach ($jadwal as $j): ?><tr>
<td><?= esc($j['tanggal']) ?></td><td><?= esc($j['jam_mulai']) ?> - <?= esc($j['jam_selesai']) ?></td>
<td><?= esc($j['nama_poli']) ?></td><td><?= esc($j['nama_dokter']) ?> (<?= esc($j['spesialisasi']) ?>)</td>
<td><?= esc($j['kuota']) ?></td><td><?= esc($j['sisa_kuota']) ?></td>
<td><?php if ((int) $j['sisa_kuota'] > 0): ?><a class="btn" href="/pendaftaran/buat/<?= esc($j['id_jadwal']) ?>">Daftar</a><?php else: ?>Penuh<?php endif; ?></td>
</tr><?php endforeach; ?></table>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
