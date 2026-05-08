<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr"
      data-theme="theme-default"
      data-assets-path="<?= base_url('assets/'); ?>"
      data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>404 | SapaPajak</title>

  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/img/favicon/favicon.ico'); ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css'); ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>">

  <!-- Page CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-misc.css'); ?>">

  <!-- Helpers -->
  <script src="<?= base_url('assets/vendor/js/helpers.js'); ?>"></script>
  <script src="<?= base_url('assets/js/config.js'); ?>"></script>
</head>

<body>

<div class="container-xxl container-p-y">
  <div class="misc-wrapper text-center">

    <h2 class="mb-2">Halaman tidak ditemukan :(</h2>

    <p class="mb-3">
      Oops! 😖 URL yang diminta tidak ditemukan di server ini
    </p>    

    <button onclick="window.history.back();" class="btn btn-primary mt-3">
      <i class="bx bx-undo"></i> Kembali
    </button>

    <div class="mt-4">
      <img src="<?= base_url('assets/img/illustrations/page-misc-error-light.png'); ?>"
           width="500"
           class="img-fluid">
    </div>

  </div>
</div>

<!-- JS -->
<script src="<?= base_url('assets/vendor/libs/jquery/jquery.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/js/bootstrap.js'); ?>"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>

</body>
</html>