<!-- / Content -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    
    <div class="mb-2 mb-md-0">
      Copyright © 
      <span id="year"></span>,
      <a href="https://bapenda.tabalongkab.go.id" target="_blank" class="footer-link fw-bolder">
        BAPENDA Kabupaten Tabalong
      </a>
    </div>    

  </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>

</div> <!-- container -->
</div> <!-- content-wrapper -->
</div> <!-- layout-page -->
</div> <!-- layout-container -->
</div> <!-- layout-wrapper -->

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- JS -->
 <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
<script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
<script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
<script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<?php if (session()->getFlashdata('message')) : ?>

<?php 
$type = session()->getFlashdata('type') ?? 'primary';

$bg = [
    'success' => 'bg-success text-white',
    'danger'  => 'bg-danger text-white',
    'warning' => 'bg-warning text-dark',
    'info'    => 'bg-info text-dark',
    'primary' => 'bg-primary text-white'
];
?>

<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index:9999;">
    
    <div id="customToast" 
        class="toast show shadow border-0 <?= $bg[$type] ?? 'bg-primary text-white' ?> position-relative"
        style="min-width: 250px; opacity: 0; transform: translateY(-20px); transition: all 0.4s ease;">

        <!-- tombol close -->
        <button onclick="closeToast()" 
            style="
                position: absolute;
                top: 10px;
                right: 10px;
                background: transparent;
                border: none;
                color: inherit;
                font-size: 18px;
                cursor: pointer;
            ">
            &times;
        </button>

        <!-- isi -->
        <div class="toast-body pe-4 d-flex align-items-center">

            <?php if ($type == 'success'): ?>
                <i class='bx bx-check-circle me-2'></i>
            <?php elseif ($type == 'danger'): ?>
                <i class='bx bx-x-circle me-2'></i>
            <?php endif; ?>

            <?= session()->getFlashdata('message'); ?>
        </div>

    </div>

</div>
<?php endif; ?>

<!-- Year Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const year = new Date().getFullYear();
  document.getElementById('year').innerText =
    year === 2023 ? '2023' : '2023 - ' + year;

  document.addEventListener("DOMContentLoaded", function () {

      let toast = document.getElementById('customToast');

      if (toast) {

          // Muncul (fade + slide)
          setTimeout(() => {
              toast.style.opacity = "1";
              toast.style.transform = "translateY(0)";
          }, 100);

          // Hilang setelah 5 detik
          setTimeout(() => {
              closeToast();
          }, 5000);
      }

  });

  document.addEventListener("DOMContentLoaded", function () {
      const toast = document.getElementById("customToast");

      if (toast) {
          // fade in
          setTimeout(() => {
              toast.style.opacity = "1";
              toast.style.transform = "translateY(0)";
          }, 100);

          // auto close 5 detik
          setTimeout(() => {
              closeToast();
          }, 5000);
      }
  });

  function closeToast() {
      const toast = document.getElementById("customToast");

      if (toast) {
          toast.style.opacity = "0";
          toast.style.transform = "translateY(-20px)";

          setTimeout(() => {
              toast.remove();
          }, 400);
      }
  }

// JS pada Kamera
 function showToast(message, type = 'primary') {
    let container = document.getElementById('toastContainer');

    // kalau belum ada container → buat
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }

    // buat toast baru
    const toast = document.createElement('div');
    toast.className = 'toast show shadow border-0 position-relative text-' + type;
    toast.style.minWidth = '250px';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-20px)';
    toast.style.transition = 'all 0.4s ease';

    toast.innerHTML = `
        <button onclick="this.parentElement.remove()" 
            style="
                position: absolute;
                top: 10px;
                right: 10px;
                background: transparent;
                border: none;
                color: inherit;
                font-size: 18px;
                cursor: pointer;
            ">
            &times;
        </button>
        <div class="toast-body pe-4">${message}</div>
    `;

    container.appendChild(toast);

    // animasi masuk
    setTimeout(() => {
        toast.style.opacity = "1";
        toast.style.transform = "translateY(0)";
    }, 100);

    // auto hilang
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(-20px)";
        setTimeout(() => toast.remove(), 400);
    }, 4000);
}

function toggleTheme() {
    const body = document.body;
    const icon = document.getElementById("themeIcon");
    const label = document.getElementById("themeLabel");

    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");

        if (icon) {
            icon.classList.remove("bx-moon");
            icon.classList.add("bx-sun");
        }

        if (label) label.innerText = "ON";

    } else {
        localStorage.setItem("theme", "light");

        if (icon) {
            icon.classList.remove("bx-sun");
            icon.classList.add("bx-moon");
        }

        if (label) label.innerText = "OFF";
    }
}

// LOAD AWAL
document.addEventListener("DOMContentLoaded", function () {
    const savedTheme = localStorage.getItem("theme");
    const icon = document.getElementById("themeIcon");
    const label = document.getElementById("themeLabel");

    if (savedTheme === "dark") {
        document.body.classList.add("dark-mode");

        if (icon) {
            icon.classList.remove("bx-moon");
            icon.classList.add("bx-sun");
        }

        if (label) label.innerText = "ON";
    }
});
</script>

</body>
</html>