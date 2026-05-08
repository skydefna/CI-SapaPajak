<!DOCTYPE html>
<html lang="id" class="light-style" dir="ltr"
      data-theme="theme-default"
      data-assets-path="<?= base_url('assets/'); ?>">

<head>
  <meta charset="utf-8">
  <title>Database Error | SIMaTa</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>">
</head>

<body>

<div class="container-xxl container-p-y">
  <div class="misc-wrapper text-center">

    <h2 class="mb-2 text-danger">Terjadi Kesalahan Database</h2>

    <p class="mb-3">
      Sistem mengalami kendala saat mengakses database.
    </p>

    <!-- Pesan error -->
    <div class="alert alert-danger text-start mx-auto" style="max-width:600px;">
      <?= esc($message ?? 'Silakan coba beberapa saat lagi'); ?>
    </div>

    <a href="<?= base_url('/'); ?>" class="btn btn-primary mt-3">
      Kembali ke Beranda
    </a>

  </div>
</div>

</body>
</html>