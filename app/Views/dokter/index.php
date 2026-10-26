<?= $this->include('partials/header') ?>
<div class="page-heading"><div><h1>Jadwal Saya</h1><p>Jadwal praktik Anda yang akan datang. Ubah jadwal dari daftar di bawah, lalu lihat pasien terjadwal dan rekam medis Anda.</p></div><div class="page-icon"><i class="bi bi-calendar-week"></i></div></div>
<div class="surface-card p-4 mb-3"><h3 class="h5">Ringkasan Jadwal Saya</h3><p class="mb-0">Jadwal mendatang Anda: <?= count($jadwal) ?>. Ubah jadwal Anda dari tabel di bawah, lalu lihat pasien terjadwal dan rekam medis dari menu di atas.</p></div>
<div class="surface-card p-4 mb-3"><h2>Jadwal Saya</h2><p>Dokter: <?= esc($dokter['nama_dokter']) ?> (<?= esc($dokter['spesialisasi']) ?>)</p>
<div class="quick-grid">
<a class="quick-item" href="/dokter"><span class="qicon"><i class="bi bi-calendar-week"></i></span>Jadwal Saya</a>
<a class="quick-item" href="/dokter/pasien"><span class="qicon"><i class="bi bi-people"></i></span>Pasien Terjadwal</a>
<a class="quick-item" href="/dokter/rekam-medis"><span class="qicon"><i class="bi bi-journal-medical"></i></span>Rekam Medis</a>
</div></div>
<?php if (empty($jadwal)): ?><div class="surface-card p-4 mb-3"><h3>Belum ada jadwal mendatang untuk Anda.</h3><p class="mb-0">Minta admisi menambahkan jadwal untuk Anda, atau periksa kembali nanti.</p></div><?php else: ?>
<div class="surface-card mb-3 overflow-hidden"><div class="table-responsive"><table class="table mb-0 table-striped table-hover align-middle"><tr><th>Tanggal</th><th>Jam</th><th>Kuota</th><th></th></tr>
<?php foreach ($jadwal as $j): ?><tr><td><?= esc($j['tanggal']) ?></td><td><?= esc($j['jam_mulai']) ?> - <?= esc($j['jam_selesai']) ?></td><td><?= esc($j['kuota']) ?></td><td><a href="/dokter/jadwal/ubah/<?= esc($j['id_jadwal']) ?>">Ubah</a></td></tr>
<?php endforeach; ?></table></div></div>
<?php endif; ?>
<?= $this->include('partials/footer') ?>
