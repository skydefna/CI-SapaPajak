<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr"
      data-theme="theme-default"
      data-assets-path="<?= base_url('assets/'); ?>"
      data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Akses ditolak | SapaPajak</title>

  <link rel="icon" href="<?= base_url('assets/img/favicon/favicon.ico'); ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap">

  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-misc.css'); ?>">

  <script src="<?= base_url('assets/vendor/js/helpers.js'); ?>"></script>
  <script src="<?= base_url('assets/js/config.js'); ?>"></script>
</head>

<body>

<div class="container-xxl container-p-y">
  <div class="misc-wrapper text-center">

    <h2 class="mb-2">Akses ditolak !!!</h2>
    <p class="mb-4">Heeyy! 🧐 URL yang diminta ditolak aksesnya di server ini</p>

    <?php
      $role = $user['role_id'] ?? null;
      $showLogout = true;

      if (!empty($user_access_menu)) {
          foreach ($user_access_menu as $a) {
              if ($a['role_id'] == $role && $a['menu_id'] == 0) {
                  $showLogout = false;
                  ?>
                  <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary">
                      <i class="bx bx-home-circle"></i> Dashboard
                  </a>
                  <?php
                  break;
              }
          }
      }
    ?>

    <?php if ($showLogout): ?>
      <a href="<?= base_url('login'); ?>" class="btn btn-danger">
        <i class="bx bx-power-off"></i> Log Out
      </a>
    <?php endif; ?>

    <div class="mt-4">
      <img src="<?= base_url('assets/img/illustrations/undraw_alert_re_j2op.svg'); ?>"
           width="400"
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