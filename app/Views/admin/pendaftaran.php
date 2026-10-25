<?= $this->include('partials/header') ?>
<div class="card"><h2>Data Pendaftaran</h2><p class="small">Check-in: tombol Check-in hanya berlaku pada hari praktik dan hanya untuk status menunggu. Kolom ubah status adalah koreksi manual admisi (transisi dijaga: menunggu &rarr; dikonfirmasi/dibatalkan, dikonfirmasi &rarr; selesai/dibatalkan, selesai/dibatalkan bersifat final).</p></div>
<table><tr><th>Tanggal</th><th>Pasien (No. RM)</th><th>Dokter</th><th>Antrean</th><th>Status</th><th>Aksi</th></tr>
<?php foreach ($pendaftaran as $r): ?><tr><td><?= esc($r['tanggal']) ?></td><td><?= esc($r['nama_pasien']) ?> (<?= esc($r['no_rm']) ?>)</td><td><?= esc($r['nama_dokter']) ?></td><td><?= esc($r['no_antrean']) ?></td><td><?= esc($r['status']) ?></td>
<td><?php if ($r['status'] === 'menunggu'): ?><form action="/admin/pendaftaran/checkin/<?= esc($r['id_pendaftaran']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button type="submit">Check-in</button></form> <?php endif; ?><form action="/admin/pendaftaran/status/<?= esc($r['id_pendaftaran']) ?>" method="post" style="display:inline"><?= csrf_field() ?>
<select name="status"><option value="menunggu">Menunggu</option><option value="dikonfirmasi">Dikonfirmasi</option><option value="selesai">Selesai</option><option value="dibatalkan">Dibatalkan</option></select>
<button type="submit">Simpan</button></form></td></tr>
<?php endforeach; ?></table>
<?= $this->include('partials/footer') ?>
