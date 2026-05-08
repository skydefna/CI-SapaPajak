<?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?>
<!DOCTYPE html>
<html lang="en"
  data-theme="theme-default"
  data-assets-path="<?= base_url('assets/') ?>"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>
    <?= esc($title ?? 'SapaPajak') ?>
    <?= !empty($sub) ? ' - ' . esc($sub) : '' ?>
  </title>

  <link rel="icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <!-- JS -->
  <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
  <script src="<?= base_url('assets/js/config.js') ?>"></script>

</head>

<body>

<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">