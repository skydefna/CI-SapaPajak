<!-- Content -->

<div class="container-fluid p-0">
  <div class="authentication-wrapper d-flex align-items-center justify-content-center vh-100 position-relative"
     style="
        background: url('<?= !empty($setting['bg_login']) 
            ? base_url('uploads/'.$setting['bg_login']) 
            : base_url('assets/default-bg.jpg') ?>') no-repeat center center;
        background-size: cover;
     ">

```
<!-- OVERLAY -->
<div class="login-overlay"></div>

<!-- CARD -->
<div class="card shadow-lg border-0 overflow-hidden"
     style="max-width:900px; width:100%; border-radius:20px; z-index:2;">

  <div class="row g-0">

    <!-- ================= LEFT (DESKTOP) ================= -->
    <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center text-center p-4"
         style="background:#f8f9fa;">

      <img src="<?= (!empty($setting['logo_login']) && file_exists(FCPATH.'uploads/'.$setting['logo_login']))
        ? base_url('uploads/'.$setting['logo_login']) 
        : base_url('assets/logo.png') ?>" 
        width="180" class="mb-3">

      <h2 class="fw-bold">
        Sapa<span class="text-primary">Pajak</span>
      </h2>

      <p class="text-muted mb-0">
        Sarana Pendaftaran Konsultasi Pajak
      </p>
      <p class="text-muted">
        BAPENDA Kab.Tabalong
      </p>

    </div>

    <!-- ================= RIGHT ================= -->
    <div class="col-md-6 p-4 d-flex flex-column justify-content-center">

      <!-- MOBILE HEADER -->
      <div class="text-center mb-4 d-md-none">

        <img src="<?= (!empty($setting['logo_login']) && file_exists(FCPATH.'uploads/'.$setting['logo_login']))
          ? base_url('uploads/'.$setting['logo_login']) 
          : base_url('assets/logo.png') ?>" 
          width="120" class="mb-2">

        <h4 class="fw-bold">
          Sapa<span class="text-primary">Pajak</span>
        </h4>

        <p class="text-muted small mb-0">
          Sarana Pendaftaran Konsultasi Pajak
        </p>
        <p class="text-muted small">
          BAPENDA Kab.Tabalong
        </p>

      </div>

      <!-- TOAST -->
      <?php if (session()->getFlashdata('message')) : ?>
      <?php 
      $type = session()->getFlashdata('type') ?? 'danger';

      $toastClass = match($type) {
          'success' => 'bg-success text-white',
          'warning' => 'bg-warning text-dark',
          default   => 'bg-danger text-white'
      };
      ?>

      <div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index:9999;">
          <div id="customToast"
              class="shadow border rounded <?= $toastClass ?>"
              style="min-width:280px; opacity:0; transform:translateY(-20px); transition:all .4s ease;">

              <div class="px-3 py-2">
                  <?= session()->getFlashdata('message'); ?>
              </div>

          </div>
      </div>
      <?php endif; ?>

      <div class="d-flex align-items-center justify-content-center mb-4 position-relative">

        <!-- TEXT -->
        <h4 class="m-0 text-center">
          Selamat Datang
        </h4>

        <!-- PANAH (KIRI) -->
        <a href="<?= base_url('/') ?>" 
          class="position-absolute end-0 text-decoration-none">
          <i class='bx bx-arrow-back fs-3'></i>
        </a>

      </div>

      <form method="post" action="<?= base_url('login/process'); ?>">
        <?= csrf_field(); ?>

        <!-- USERNAME -->
        <div class="form-floating mb-3">
          <input 
            type="text" 
            class="form-control <?= validation_show_error('username') ? 'is-invalid' : '' ?>" 
            name="username"
            placeholder="Username"
            value="<?= old('username'); ?>"
          >
          <label>Username</label>

          <div class="invalid-feedback">
            <?= validation_show_error('username'); ?>
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="form-floating mb-3 position-relative">
          <input 
            type="password" 
            id="password"
            class="form-control <?= validation_show_error('password') ? 'is-invalid' : '' ?>" 
            name="password"
            placeholder="Password"
          >
          <label>Password</label>

          <span onclick="togglePassword()" class="password-toggle">
            <i class="bx bx-hide"></i>
          </span>

          <div class="invalid-feedback">
            <?= validation_show_error('password'); ?>
          </div>
        </div>

        <!-- BUTTON -->
        <button id="btnLogin" class="btn btn-primary w-100">
          <span id="btnText">
            Masuk
          </span>
          <span id="btnLoading" class="d-none">
            <span class="spinner-border spinner-border-sm me-1"></span>
            Memverifikasi...
          </span>
        </button>
        
      </form>

      <!-- FOOTER -->
      <div class="text-center mt-4">
        <small class="text-muted">
          Copyright © 
          <?= (date('Y') == 2023) ? "2023" : "2023 - " . date('Y'); ?>,
          BAPENDA Kab.Tabalong
        </small>
      </div>

    </div>
  </div>
</div>
```

  </div>
</div>

<script>
function togglePassword() {
  const input = document.getElementById("password");
  const icon = document.querySelector(".password-toggle i");

  if (input.type === "password") {
    input.type = "text";
    icon.classList.replace("bx-hide", "bx-show");
  } else {
    input.type = "password";
    icon.classList.replace("bx-show", "bx-hide");
  }
}

document.querySelector("form").addEventListener("submit", function() {
    const btn = document.getElementById("btnLogin");
    const text = document.getElementById("btnText");
    const loading = document.getElementById("btnLoading");

    btn.disabled = true;
    text.classList.add("d-none");
    loading.classList.remove("d-none");
});

document.addEventListener("DOMContentLoaded", function() {
    let toast = document.getElementById("customToast");

    if (toast) {
        setTimeout(() => {
            toast.style.opacity = "1";
            toast.style.transform = "translateY(0)";
        }, 100);

        setTimeout(() => {
            toast.style.opacity = "0";
            toast.style.transform = "translateY(-20px)";
        }, 4000);
    }
});

  // Apply theme sebelum render (anti flicker)
  if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.classList.add('dark-mode');
  }
</script>