<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php $judulHalaman = ($edit ? 'Ubah ' : 'Tambah ') . $judul; ?>
<div class="mb-4">
    <h1 class="title"><?= $edit ? 'Ubah' : 'Tambah' ?> <?= esc($judul) ?></h1>
    <p class="muted mb-0">Lengkapi data berikut lalu simpan.</p>
</div>

<section class="panel" style="max-width:640px">
    <form action="<?= esc($action, 'attr') ?>" method="post">
        <?= csrf_field() ?>

        <?php foreach ($fields as $f): ?>
            <?php
            $n   = $f['name'];
            $val = old($n, $nilai[$n] ?? '');
            $req = !empty($f['required']) ? 'required' : '';
            ?>
            <div class="mb-3">
                <label class="form-label fw-semibold" for="<?= esc($n, 'attr') ?>"><?= esc($f['label']) ?></label>

                <?php if ($f['type'] === 'textarea'): ?>
                    <textarea class="form-control" id="<?= esc($n, 'attr') ?>" name="<?= esc($n, 'attr') ?>" rows="3"
                        <?= isset($f['maxlength']) ? 'maxlength="' . (int) $f['maxlength'] . '"' : '' ?> <?= $req ?>><?= esc($val) ?></textarea>

                <?php elseif ($f['type'] === 'select'): ?>
                    <select class="form-select" id="<?= esc($n, 'attr') ?>" name="<?= esc($n, 'attr') ?>" <?= $req ?>>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($f['options'] as $k => $label): ?>
                            <option value="<?= esc($k, 'attr') ?>" <?= (string) $val === (string) $k ? 'selected' : '' ?>>
                                <?= esc($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                <?php else: ?>
                    <input class="form-control" type="<?= esc($f['type'], 'attr') ?>" id="<?= esc($n, 'attr') ?>"
                        name="<?= esc($n, 'attr') ?>" value="<?= esc($val, 'attr') ?>"
                        <?= isset($f['maxlength']) ? 'maxlength="' . (int) $f['maxlength'] . '"' : '' ?>
                        <?= isset($f['min']) ? 'min="' . (int) $f['min'] . '"' : '' ?>
                        <?= isset($f['max']) ? 'max="' . (int) $f['max'] . '"' : '' ?> <?= $req ?>>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="d-flex gap-2 justify-content-end mt-4">
            <a href="<?= esc($back, 'attr') ?>" class="btn btn-outline-secondary rounded-3">Batal</a>
            <button type="submit" class="btn btn-teal"><i class="bi bi-check2 me-1"></i> Simpan</button>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
