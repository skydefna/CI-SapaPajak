<!-- Navbar & Hero Start -->
<div class="position-relative p-0">

  <nav class="navbar fixed-top navbar-expand-lg mb-5 custom-navbar">

    <div class="container-xxl">

      <!-- Logo -->
      <a class="navbar-brand me-5" href="<?= base_url('/') ?>">
          <img src="<?= base_url('uploads/' . ($settings['logo_sapapajak'] ?? 'default.png')); ?>" 
              style="height: 40px; width: auto;">
      </a>

      <!-- Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <?php $active = "active text-primary fw-semibold"; ?>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">      

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <!-- Home -->
          <li class="nav-item me-4">
            <a class="nav-link <?= ($title == "Sapa Pajak Tabalong") ? $active : '' ?>"
               href="<?= base_url('/') ?>">
              Home
            </a>
          </li>

          <!-- Buku Tamu Dropdown -->
          <li class="nav-item dropdown me-4">
            <a class="nav-link dropdown-toggle 
              <?= (in_array($title, ['Buku Tamu','Tamu Personal','Tamu Organisasi'])) ? $active : '' ?>"
               href="#" data-bs-toggle="dropdown">

              Buku Tamu
            </a>

            <ul class="dropdown-menu">

              <li>
                <a class="dropdown-item <?= ($title == "Tamu Personal") ? $active : '' ?>"
                   href="<?= base_url('tamu/personal') ?>">
                  <i class='bx bxs-user'></i> Tamu Personal
                </a>
              </li>

              <li>
                <a class="dropdown-item <?= ($title == "Tamu Organisasi") ? $active : '' ?>"
                   href="<?= base_url('tamu/organisasi') ?>">
                  <i class='bx bxs-group'></i> Tamu Organisasi
                </a>
              </li>

            </ul>
          </li>

          <!-- Survey -->
          <li class="nav-item me-4">
            <a class="nav-link <?= ($title == "Tentang Kami") ? $active : '' ?>"
               href="<?= base_url('tamu/about') ?>">
              Survey Kepuasan
            </a>
          </li>

          <!-- Dokumentasi -->
          <li class="nav-item me-4">
            <a class="nav-link <?= ($title == "Dokumentasi") ? $active : '' ?>"
               href="<?= base_url('tamu/documentation') ?>">
              Dokumentasi
            </a>
          </li>

        </ul>

        <div class="d-flex align-items-center ms-auto">
          <button id="themeToggle" class="theme-toggle">
            <i class='bx bx-sun'></i>
          </button>
        </div>

      </div>
    </div>
  </nav>

</div>

<script>
  const toggleBtn = document.getElementById('themeToggle');
  const body = document.body;
  const icon = toggleBtn.querySelector('i');

  // Load dari localStorage
  if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
    icon.classList.replace('bx-moon', 'bx-sun');
  }

  toggleBtn.addEventListener('click', () => {
    body.classList.toggle('dark-mode');

    if (body.classList.contains('dark-mode')) {
      localStorage.setItem('theme', 'dark');
      icon.classList.replace('bx-moon', 'bx-sun');
    } else {
      localStorage.setItem('theme', 'light');
      icon.classList.replace('bx-sun', 'bx-moon');
    }
  });
</script>