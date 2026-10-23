<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h1 class="title">Data Pasien &amp; Verifikasi BPJS</h1>
    <p class="muted mb-0">Periksa kelengkapan data pasien dan verifikasi nomor BPJS sebelum reservasi dikonfirmasi.</p>
</div>

<section class="panel mb-4">
    <form method="get" action="<?= base_url('admin/pasien') ?>" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Cari</label>
            <input type="search" name="q" class="form-control" placeholder="Nama / No. RM / NIK / No. BPJS" value="<?= esc($fCari, 'attr') ?>">
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold">Jenis</label>
            <select name="jenis" class="form-select">
                <option value="">Semua</option>
                <option value="umum" <?= $fJenis === 'umum' ? 'selected' : '' ?>>Umum</option>
                <option value="bpjs" <?= $fJenis === 'bpjs' ? 'selected' : '' ?>>BPJS</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold">Status BPJS</label>
            <select name="status_bpjs" class="form-select">
                <option value="">Semua</option>
                <?php foreach (['menunggu', 'terverifikasi', 'ditolak'] as $s): ?>
                    <option value="<?= $s ?>" <?= $fStatus === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button class="btn btn-teal">Filter</button>
            <a href="<?= base_url('admin/pasien') ?>" class="btn btn-outline-secondary rounded-3">Reset</a>
        </div>
    </form>
</section>

<section class="panel">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr><th>Pasien</th><th>Kontak &amp; Medis</th><th>Jenis</th><th>BPJS</th><th class="text-end">Verifikasi</th></tr>
            </thead>
            <tbody>
            <?php if (empty($pasien)): ?>
                <tr><td colspan="5" class="text-center muted py-5">Tidak ada data pasien.</td></tr>
            <?php endif; ?>
            <?php foreach ($pasien as $p): ?>
                <?php $bpjs = $p['jenis_pasien'] === 'bpjs'; ?>
                <tr>
                    <td>
                        <div class="fw-semibold"><?= esc($p['nama']) ?></div>
                        <div class="small muted"><?= esc($p['no_rm']) ?> · NIK <?= esc($p['nik']) ?></div>
                    </td>
                    <td class="small">
                        <div><i class="bi bi-telephone me-1"></i><?= esc($p['no_hp']) ?></div>
                        <div>Gol. darah: <strong><?= esc($p['golongan_darah'] === 'tidak_tahu' ? '-' : $p['golongan_darah']) ?></strong></div>
                        <div class="muted">Alergi: <?= esc($p['alergi'] ?: '-') ?></div>
                    </td>
                    <td><span class="badge <?= $bpjs ? 'text-bg-success' : 'text-bg-secondary' ?>"><?= $bpjs ? 'BPJS' : 'UMUM' ?></span></td>
                    <td class="small">
                        <?php if ($bpjs): ?>
                            <div><?= esc($p['no_bpjs']) ?></div>
                            <?php $b = ['menunggu' => 'warning', 'terverifikasi' => 'success', 'ditolak' => 'danger'][$p['status_bpjs']] ?? 'secondary'; ?>
                            <span class="badge text-bg-<?= $b ?>"><?= esc(str_replace('_', ' ', $p['status_bpjs'])) ?></span>
                            <?php if (!empty($p['catatan_bpjs'])): ?>
                                <div class="muted mt-1"><?= esc($p['catatan_bpjs']) ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <?php if ($bpjs): ?>
                            <form method="post" action="<?= base_url('admin/pasien/bpjs/' . (int) $p['id_pasien']) ?>" class="d-flex gap-1 justify-content-end flex-wrap">
                                <?= csrf_field() ?>
                                <input type="text" name="catatan" class="form-control form-control-sm" style="max-width:170px;min-height:31px"
                                       maxlength="255" placeholder="Alasan jika ditolak">
                                <button name="keputusan" value="terverifikasi" class="btn btn-sm btn-success rounded-3"
                                        <?= $p['status_bpjs'] === 'terverifikasi' ? 'disabled' : '' ?>>Verifikasi</button>
                                <button name="keputusan" value="ditolak" class="btn btn-sm btn-outline-danger rounded-3"
                                        <?= $p['status_bpjs'] === 'ditolak' ? 'disabled' : '' ?>>Tolak</button>
                            </form>
                        <?php else: ?>
                            <span class="muted small">Tidak perlu</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>
