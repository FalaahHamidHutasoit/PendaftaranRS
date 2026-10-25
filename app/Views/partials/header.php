<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Aplikasi Pendaftaran Pasien</title>
<style>
body{font-family:system-ui,Arial,sans-serif;margin:0;background:#f4f6f8;color:#222}
header{background:#1f3864;color:#fff;padding:14px 20px}
header a{color:#fff;text-decoration:none;margin-right:14px}
main{max-width:960px;margin:20px auto;padding:0 16px 40px}
.card{background:#fff;border:1px solid #ddd;border-radius:8px;padding:18px;margin-bottom:16px}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{border:1px solid #ddd;padding:8px;text-align:left;font-size:14px}
th{background:#eef2f7}
label{display:block;margin:10px 0 4px;font-weight:600}
input,select,textarea{width:100%;padding:9px;border:1px solid #bbb;border-radius:6px;box-sizing:border-box}
button,.btn{display:inline-block;background:#1f3864;color:#fff;border:0;border-radius:6px;padding:9px 16px;cursor:pointer;text-decoration:none}
.btn-danger{background:#a33333}
.flash{padding:10px 14px;border-radius:6px;margin-bottom:14px}
.flash-error{background:#fde8e8;border:1px solid #e5a3a3}
.flash-success{background:#e6f4ea;border:1px solid #a3d9b1}
.small{color:#666;font-size:13px}
</style>
</head>
<body>
<header>
<a href="/jadwal"><strong>Pendaftaran Pasien</strong></a>
<?php $role = session()->get('role'); ?>
<?php if (session()->get('isLoggedIn')): ?>
  <?php if ($role === 'pasien'): ?><a href="/pendaftaran">Pendaftaran Saya</a><a href="/profil">Profil</a><?php endif; ?>
  <?php if ($role === 'admin'): ?><a href="/admin">Admin</a><?php endif; ?>
  <?php if ($role === 'dokter'): ?><a href="/dokter">Dokter</a><?php endif; ?>
  <form action="/logout" method="post" style="display:inline"><?= csrf_field() ?><button type="submit" style="background:none;border:0;color:#fff;cursor:pointer;font-size:inherit;padding:0">Keluar (<?= esc(session()->get('nama')) ?>)</button></form>
<?php else: ?>
  <a href="/login">Login</a><a href="/registrasi">Registrasi Pasien</a>
<?php endif; ?>
</header>
<main>
<?php if (session()->getFlashdata('error')): ?><div class="flash flash-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('success')): ?><div class="flash flash-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
