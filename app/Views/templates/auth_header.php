<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr"
      data-theme="theme-default"
      data-assets-path="<?= base_url('assets/') ?>"
      data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0,
        user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?= esc($title); ?></title>

  <meta name="description" content="" />

  <!-- html2pdf -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

  <!-- Favicon -->
  <?php helper('settings'); ?>

  <link rel="icon" href="<?= base_url('uploads/' . (setting('logo_tab') ?? 'default.png')); ?>">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />

  <!-- Animation -->
  <link rel="stylesheet" href="<?= base_url('assets/css/animate.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('lib/animate/animate.min.css') ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css') ?>" />

  <!-- Helpers -->
  <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>

  <!-- Config -->
  <script src="<?= base_url('assets/js/config.js') ?>"></script>

  <style>
    .absu {
      position: absolute;
      left: 0;
      right: 0;
      margin: auto;
      width: 100%;
      z-index: 9999;
    }
  </style>
</head>

<body>