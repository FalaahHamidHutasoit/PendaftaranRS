<?= $this->include('partials/header') ?>
<div class="card"><h2>Riwayat Pendaftaran Saya</h2></div>
<?php if (! empty($pengingat_besok)): ?>
<div class="card"><h3>Pengingat H-1 — Jadwal Anda Besok</h3>
<?php foreach ($pengingat_besok as $b): ?><p>Antrean <?= esc($b['no_antrean']) ?> — <?= esc($b['nama_dokter']) ?> / <?= esc($b['nama_poli']) ?> — <?= esc($b['tanggal']) ?> pukul <?= esc($b['jam_mulai']) ?>. Harap datang tepat waktu.</p><?php endforeach; ?>
<p class="small">Pengingat ini dihitung dari tanggal jadwal, bukan tanggal daftar. Pengingat lewat email/SMS belum tersedia.</p></div>
<?php endif; ?>
<?php if (empty($pendaftaran)): ?><div class="card">Belum ada pendaftaran.</div>
<?php else: ?>
<table><tr><th>Tanggal</th><th>Dokter / Poli</th><th>Antrean</th><th>Jenis</th><th>Status</th><th></th></tr>
<?php foreach ($pendaftaran as $r): ?><tr>
<td><?= esc($r['tanggal']) ?> <?= esc($r['jam_mulai']) ?></td>
<td><?= esc($r['nama_dokter']) ?> / <?= esc($r['nama_poli']) ?></td>
<td><?= esc($r['no_antrean']) ?></td><td><?= esc($r['jenis_kunjungan']) ?></td><td><?= esc($r['status']) ?></td>
<td><?php if (in_array($r['status'], ['menunggu', 'dikonfirmasi'], true)): ?>
<form action="/pendaftaran/batal/<?= esc($r['id_pendaftaran']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button class="btn btn-danger" type="submit" onclick="return confirm('Batalkan pendaftaran ini?')">Batalkan</button></form>
<?php endif; ?></td>
</tr><?php endforeach; ?></table>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
