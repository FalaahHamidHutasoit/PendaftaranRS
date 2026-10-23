<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h1 class="title">Kelola Reservasi</h1>
    <p class="muted mb-0">Konfirmasi, selesaikan, atau batalkan reservasi pasien.</p>
</div>

<section class="panel mb-4">
    <form method="get" action="<?= base_url('admin/reservasi') ?>" class="row g-2 align-items-end">
        <div class="col-sm-4 col-md-3">
            <label class="form-label small fw-semibold">Tanggal praktik</label>
            <input type="date" name="tanggal" class="form-control" value="<?= esc($fTanggal, 'attr') ?>">
        </div>
        <div class="col-sm-4 col-md-3">
            <label class="form-label small fw-semibold">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua</option>
                <?php foreach (['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'] as $s): ?>
                    <option value="<?= $s ?>" <?= $fStatus === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button class="btn btn-teal">Filter</button>
            <a href="<?= base_url('admin/reservasi') ?>" class="btn btn-outline-secondary rounded-3">Reset</a>
        </div>
    </form>
</section>

<section class="panel">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Antrean</th><th>Pasien</th><th>Dokter / Poli</th><th>Jadwal</th>
                    <th>Keluhan</th><th>Status</th><th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($reservasi)): ?>
                <tr><td colspan="7" class="text-center muted py-5">Tidak ada reservasi.</td></tr>
            <?php endif; ?>
            <?php foreach ($reservasi as $r): ?>
                <tr>
                    <td><strong>#<?= (int) $r['no_antrean'] ?></strong></td>
                    <td>
                        <div class="fw-semibold"><?= esc($r['nama_pasien']) ?></div>
                        <div class="small muted"><?= esc($r['no_rm']) ?></div>
                        <span class="badge <?= $r['jenis_pasien'] === 'bpjs' ? 'text-bg-success' : 'text-bg-secondary' ?>">
                            <?= strtoupper(esc($r['jenis_pasien'])) ?>
                        </span>
                        <?php if ($r['jenis_pasien'] === 'bpjs'): ?>
                            <span class="small muted"><?= esc($r['no_bpjs']) ?></span>
                            <div class="small">
                                <span class="muted">BPJS:</span>
                                <strong class="<?= $r['status_bpjs'] === 'terverifikasi' ? 'text-success' : 'text-danger' ?>">
                                    <?= esc(str_replace('_', ' ', $r['status_bpjs'])) ?>
                                </strong>
                            </div>
                            <div class="small muted">Rujukan: <?= esc($r['no_rujukan'] ?? '-') ?></div>
                            <?php if (!empty($r['faskes_perujuk'])): ?>
                                <div class="small muted"><?= esc($r['faskes_perujuk']) ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="fw-semibold"><?= esc($r['nama_dokter']) ?></div>
                        <div class="small muted"><?= esc($r['nama_poli']) ?></div>
                    </td>
                    <td>
                        <?= date('d-m-Y', strtotime($r['tanggal'])) ?><br>
                        <span class="small muted"><?= esc(substr($r['jam_mulai'], 0, 5)) ?>–<?= esc(substr($r['jam_selesai'], 0, 5)) ?></span>
                    </td>
                    <td style="max-width:240px" class="small"><?= esc(mb_strimwidth($r['keluhan_awal'], 0, 120, '…')) ?></td>
                    <td><span class="badge-st st-<?= esc($r['status'], 'attr') ?>"><?= esc($r['status']) ?></span></td>
                    <td class="text-end text-nowrap">
                        <?php
                        $aksi = [
                            'menunggu'     => ['dikonfirmasi' => ['Konfirmasi', 'btn-primary'], 'dibatalkan' => ['Batalkan', 'btn-outline-danger']],
                            'dikonfirmasi' => ['selesai' => ['Selesai', 'btn-success'], 'dibatalkan' => ['Batalkan', 'btn-outline-danger']],
                        ][$r['status']] ?? [];
                        ?>
                        <?php foreach ($aksi as $st => [$label, $cls]): ?>
                            <form method="post" action="<?= base_url('admin/reservasi/status/' . (int) $r['id_reservasi']) ?>" class="d-inline"
                                  <?= $st === 'dibatalkan' ? 'onsubmit="return confirm(\'Batalkan reservasi ini?\')"' : '' ?>>
                                <?= csrf_field() ?>
                                <input type="hidden" name="status" value="<?= $st ?>">
                                <button class="btn btn-sm <?= $cls ?> rounded-3"><?= $label ?></button>
                            </form>
                        <?php endforeach; ?>
                        <?php if (!$aksi): ?><span class="muted small">—</span><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>
