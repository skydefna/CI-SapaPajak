<?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?>

<!-- Loading -->
<div id="loadingers">
  <div class="custom-loader"></div>
</div>

<script>
  function hideLoading() {
    const el = document.getElementById("loadingers");
    let opacity = 1;

    function fade() {
      opacity -= 0.05;
      el.style.opacity = opacity;

      if (opacity <= 0) {
        el.style.display = "none";
      } else {
        requestAnimationFrame(fade);
      }
    }

    fade();
  }

  setTimeout(hideLoading, 500);
</script>

<!-- Layout -->
<div class="layout-page">

  <!-- ================= NAVBAR ================= -->
  <nav class="layout-navbar navbar navbar-expand-xl bg-navbar-theme container-xxl">

    <!-- TOGGLE -->
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <!-- TANGGAL DAN JAM -->
    <div class="nav-item d-flex align-items-center">
      <i class='bx bx-calendar fs-4 lh-0 me-2'></i>
      
      <div>
        <div id="tglNows" class="fw-bolder"></div>
        <small id="jamNow" class="text-muted"></small>
      </div>
    </div>

    <!-- USER -->
    <ul class="navbar-nav ms-auto align-items-center">

      <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
            <img src="<?= base_url('assets/img/users/' . ($user['image'] ?? 'default.jpg')) ?>"
                 class="rounded-circle"
                 width="40">
          </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">

          <li>
            <div class="dropdown-item d-flex">

              <img src="<?= base_url('assets/img/users/' . ($user['image'] ?? 'default.jpg')) ?>"
                   class="rounded-circle me-2"
                   width="40">

              <div>
                <strong><?= esc($user['name'] ?? $userTamu['codeTamu'] ?? '-') ?></strong><br>

                <small>
                  <?php foreach ($userRole as $ur) : ?>
                    <?php if (($ur['id'] ?? null) == ($user['role_id'] ?? null)) : ?>

                      <?php if (($user['role_id'] ?? '') == 1) : ?>
                        <span class="badge bg-danger"><?= esc($ur['role']) ?></span>
                      <?php else : ?>
                        <?= esc($user['jabatan'] ?? '-') ?>
                      <?php endif; ?>

                    <?php endif; ?>
                  <?php endforeach; ?>
                </small>

              </div>
            </div>
          </li>

          <li><hr></li>

          <li>
            <a class="dropdown-item" href="<?= base_url('settings/account') ?>">
              <i class="bx bx-cog me-2"></i> Setting Account
            </a>
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)" onclick="toggleTheme()">
              <span>
                <i id="themeIcon" class="bx bx-moon me-2"></i> Mode Gelap
              </span>
              <span class="badge bg-label-secondary" id="themeLabel">OFF</span>
            </a>
          </li>

          <li><hr></li>

          <li>
            <a class="dropdown-item" href="<?= base_url('logout') ?>">
              <i class="bx bx-power-off me-2"></i> Logout
            </a>
          </li>

        </ul>
      </li>

    </ul>

  </nav>

  <!-- ================= SCRIPT TANGGAL DAN JAM ================= -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {

      const today = new Date();

      const options = {
        weekday: 'long',   // 🔥 hari (Senin)
        day: 'numeric',
        month: 'long',
        year: 'numeric'
      };

      const formattedDate = today.toLocaleDateString('id-ID', options);

      const el = document.getElementById('tglNows');
      if (el) el.innerHTML = formattedDate;

    });
    
    document.addEventListener("DOMContentLoaded", function () {

      function updateJam() {
        const now = new Date();

        let jam   = String(now.getHours()).padStart(2, '0');
        let menit = String(now.getMinutes()).padStart(2, '0');
        let detik = String(now.getSeconds()).padStart(2, '0');

        const waktu = jam + ":" + menit + ":" + detik;

        const el = document.getElementById("jamNow");
        if (el) el.innerHTML = waktu;
      }

      // update tiap 1 detik
      setInterval(updateJam, 1000);

      // jalankan pertama kali
      updateJam();
    });  

    if (localStorage.getItem('theme') === 'dark') {
      document.body.classList.add('dark-mode');
    }

    function toggleTheme() {
      const body = document.body;

      body.classList.toggle('dark-mode');

      if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
      } else {
        localStorage.setItem('theme', 'light');
      }
    }
  </script>


  <!-- ================= CONTENT ================= -->
  <div class="content-wrapper">
    <div class="container-xxl mt-4">

      <?php if (($title ?? '') !== "Dashboard") : ?>

        <h4 class="fw-bold mb-5">
          <span class="text-muted">
            <?= esc($openMenu ?? '') ?>
            <?= ($openMenu ?? '') ? ' / ' : '' ?>
          </span>
          <?= esc($title ?? ''); ?>
          <?= !empty($submenus) && !empty($sub) ? ' / <strong>'.esc($sub).'</strong>' : '' ?>
        </h4>

      <?php endif; ?> 