<div style="height: 100vh;" class="bg-white py-5 hero-header d-flex align-items-center">
  <div class="container py-4 px-lg-5">
    <div class="row">
      <div class="col-lg-8 pt-5 text-center text-lg-start">
        <h1 class="display-4 mb-5 animate__animated animate__fadeInLeft">Mudahnya Konsultasi Pajak Daerah Bersama <b style="font-size:53px;" class="fw-bold">Sapa<span class="text-primary">Pajak</span></b></h1>
        <!-- <h3 class="display-7 mb-4 animate__animated animate__fadeInLeft">Sarana cepat dan terpercaya untuk layanan perpajakan Anda.</h3> -->
        <h5 class="animate__animated animate__fadeInLeft">Bantu Anda paham dan patuh pajak daerah dengan proses cepat, aman, dan mudah.</h5>
        <!-- <p class="animate__animated animate__fadeInLeft">✅ Pendaftaran NPWP Cepat</p> -->
        <p class="animate__animated animate__fadeInLeft">✅ Konsultasi Pajak Online/Offline</p>
        <p class="animate__animated animate__fadeInLeft">✅ Layanan Terpercaya & Profesional</p>

        <a href="<?= base_url("/"); ?>tamu/buku_tamu/" class="btn btn-primary mb-3 py-sm-3 px-sm-5 me-3 animate__animated animate__fadeInLeft">Daftar Sekarang</a>
      </div>
      <div class="col-lg-4 text-center text-lg-start">
        <?php
        $logoTabalong = !empty($settings['logo_tabalong'])
            ? base_url('uploads/' . $settings['logo_tabalong'])
            : base_url('uploads/default.png');
        ?>

        <img width="220vh"
            class="mb-3 img-fluid homeseImg animate__animated animate__zoomIn mx-auto d-block"
            src="<?= $logoTabalong; ?>"
            alt="Logo Tabalong">
        <h4 class="text-center m-0 p-0 animate__animated animate__zoomIn fw-bold">Pemerintah Daerah</h4>
        <p class="text-center m-0 p-0 animate__animated animate__zoomIn fw-bold">Badan Pendapatan Daerah Kabupaten Tabalong</p>
      </div>
    </div>
  </div>  
</div>
<!-- Navbar & Hero End -->

<!-- Apa itu SIMaTa Start -->
<div class="container px-lg-5 pt-4 tengah">
  <div class="row align-items-center">
    <div class="col-lg-5 removeCont">
      <img width="370vh" class="img-fluid wow animated zoomIn mx-auto d-block" src="<?= base_url("/"); ?>assets/img/illustrations/undraw_server_cluster_jwwq.svg" alt="">
    </div>
    <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.1s">
      <div class="section-title position-relative  pb-4">
        <h1 class="mb-2 text-center">Apa itu <b>Sapa<span class="text-primary">Pajak</span></b> ?</h1>
      </div>
      <p class="mb-4">
        <?= $settings['deskripsi'] ?? '<b>Sapa<span class="text-primary">Pajak</span></b> belum diatur'; ?>
      </p>
      <div class="row mb-4 removeCont g-3">
        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.2s">
          <div class="bg-light rounded text-center p-4">
            <i class="bx bx-group fs-1 text-primary mb-2"></i>
            <h2 class="mb-1" data-toggle="counter-up"><?= $totalTamu; ?></h2>
            <p class="mb-0">Total Tamu</p>
          </div>
        </div>
        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
          <div class="bg-light rounded text-center p-4">
            <i class="bx bx-user fs-1 text-primary mb-2"></i>
            <h2 class="mb-1" data-toggle="counter-up"><?= $personalTamu; ?></h2>
            <p class="mb-0">Personal</p>
          </div>
        </div>
        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.4s">
          <div class="bg-light rounded text-center p-4">
            <i class="bx bx-buildings fs-1 text-primary mb-2"></i>
            <h2 class="mb-1" data-toggle="counter-up"><?= $organisasiTamu; ?></h2>
            <p class="mb-0">Organisasi</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="padding: 5vh 0;" class="removeCont"></div>

<!-- Apa itu SIMaTa End -->


<!-- Kenpa SIMaTa Start -->
<div class="bg-theme pt-4">  
  <div style="padding: 5vh 0;" class="removeCont"></div>
  <div class="container px-lg-5 text-center">
    <div class="section-title position-relative mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
      <h1 class="mb-3">Kenapa <b>Sapa<span class="text-primary">Pajak</span></b> ?</h1>
      <p class="mb-1"><b>Sapa<span class="text-primary">Pajak</span></b> dirancang untuk membantu pengguna dalam mengelola data tamu secara terintegrasi dan terpusat, serta memberikan informasi yang akurat dan <i>real-time</i>. <b>Sapa<span class="text-primary">Pajak</span></b> memiliki beberapa keunggulan :</p>
    </div>
    <div class="row gy-5 gx-4 pb-5">
      <div class="d-flex align-items-stretch col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0.2s">
        <div class="d-flex align-items-stretch bg-white position-relative shadow rounded border-top border-5 border-primary">
          <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 60px; height: 60px; margin-top: -3px;">
            <i class='bx bx-pointer fs-1 text-white'></i>
          </div>
          <div class="text-center border-bottom p-4 pt-5">
            <h4 class="fw-bold">Mudah</h4>
            <p class="mb-0">Mudah digunakan karena sistemnya terintegrasi dan terpusat, memungkinkan pengguna dengan mudah mencari, menyimpan, dan melacak data tamu.</p>
          </div>
        </div>
      </div>
      <div class="d-flex align-items-stretch col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0.3s">
        <div class="d-flex align-items-stretch bg-white position-relative shadow rounded border-top border-5 border-primary">
          <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 60px; height: 60px; margin-top: -3px;">
            <i class='text-white fs-1 bx bx-timer'></i>
          </div>
          <div class="text-center border-bottom p-4 pt-5">
            <h4 class="fw-bold">Cepat</h4>
            <p class="mb-0">Mempercepat pendaftaran tamu dan memberikan informasi <i>real-time</i> karena data tamu dikelola secara terpusat, terintegrasi, dan dilacak sistematis.</p>
          </div>
        </div>
      </div>
      <div class="d-flex align-items-stretch col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0.4s">
        <div class="d-flex align-items-stretch bg-white position-relative shadow rounded border-top border-5 border-primary">
          <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 60px; height: 60px; margin-top: -3px;">
            <i class='text-white fs-1 bx bx-check-shield'></i>
          </div>
          <div class="text-center border-bottom p-4 pt-5">
            <h4 class="fw-bold">Aman</h4>
            <p class="mb-0">Pengelolaan data tamu dilakukan dengan terstruktur dan terkontrol untuk mencegah kebocoran data.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="padding: 5vh 0;" class="removeCont"></div>
</div>
<!-- Kenpa SIMaTa End -->

<!-- Demo SIMaTa Start -->
<div class="pt-4">
  <div style="margin: 10vh 0;" class="removeCont"></div>
  <div class="container px-lg-5 mb-4 tengah">
    <div class="row align-items-center mb-2">
      <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.1s">
        <div class="section-title position-relative">
          <h1 class="mb-3">Demo <b>Sapa<span class="text-primary">Pajak</span></b></h1>
        </div>
        <p class="m-0">Anda dapat mengakses <b>Sapa<span class="text-primary">Pajak</span></b> melalui website resmi BAPENDA Kabupaten Tabalong dan memasukkan data diri atau organisasi ada. Untuk lebih jelasnya, tonton video demo penggunaan <b>Sapa<span class="text-primary">Pajak</span></b> di channel YouTube BAPENDA Kabupaten Tabalong.</p>
      </div>
      <div class="col-lg-5">
        <div class="ratio ratio-16x9">
          <?php
          $youtube = $settings['youtube'] ?? '';
          $embed = '';

          if ($youtube) {
              $embed = str_replace('watch?v=', 'embed/', $youtube);
          }
          ?>

          <div class="ratio ratio-16x9">
            <iframe 
              src="<?= $embed ?: 'https://www.youtube.com/embed/default'; ?>"
              class="rounded"
              frameborder="0"
              allowfullscreen>
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </div>  
</div>
<!-- Demo SIMaTa End -->

<!-- testimoni SIMaTa Start -->
<div id="testimoniNya" class="bg-theme py-4">
  <div style="margin: 8vh 0;" class="removeCont"></div>
  <h1 class="mb-3 text-center">Punya Masukan untuk <b>Sapa<span class="text-primary">Pajak</span></b>? </h1>
  <h2 class="text-center">Bagikan di Sini!</h2>
  <div class="container py-5">
    <div class="row">

      <!-- Kolom Kiri: Form Masukan -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="text-center card-title text-primary mb-3">Kirim Masukan / Saran</h4>
            <p class="small text-muted">
              Kami senang mendengar masukan Anda.<br>
              <strong>Jangan cantumkan data pribadi atau rahasia pajak Anda.</strong>
            </p>

            <form id="feedbackForm" action="<?= base_url('tamu/kirim_feedback'); ?>" method="post">
              <div class="mb-3">
                <label for="name" class="form-label">Nama (Opsional)</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <div class="mb-3">
                <label for="kodeTamu" class="form-label">Kode Tamu</label>
                <input type="password" maxlength="6" class="form-control" id="kodeTamu" name="kodeTamu">
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Pesan / Masukan Anda</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
              </div>
              <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#kirimSurvey">Selanjutnya</button>

              <!-- Modal -->
              <div class="modal fade" id="kirimSurvey" tabindex="-1" aria-labelledby="kirimSurveyLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="kirimSurveyLabel">Kapuasan anda?</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="d-flex justify-content-between mx-4">
                        <div class="text-center selectable">
                          <img class="img-thumbnail rounded-circle" width="70" height="70" src="/assets/img/survey/1.png" alt="">
                          <p class="mt-3">Sangat Puas</p>
                        </div>
                        <div class="text-center selectable">
                          <img class="img-thumbnail rounded-circle" width="70" height="70" src="/assets/img/survey/2.png" alt="">
                          <p class="mt-3">Puas</p>
                        </div>
                        <div class="text-center selectable">
                          <img class="img-thumbnail rounded-circle" width="70" height="70" src="/assets/img/survey/3.png" alt="">
                          <p class="mt-3">Cukup</p>
                        </div>
                        <div class="text-center selectable">
                          <img class="img-thumbnail rounded-circle" width="70" height="70" src="/assets/img/survey/4.png" alt="">
                          <p class="mt-3">kurang</p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Kirim Masukan</button>
                    </div>
                  </div>
                </div>
              </div>              
            </form>

            <div id="feedbackSuccess" class="alert alert-success mt-3 d-none" role="alert">
              Terima kasih atas masukan Anda!
            </div>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Daftar Komentar -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="card-title text-primary mb-5 text-center">Testimoni / Komentar / Masukan Terbaru</h4>

            <div id="commentsList">
              <!-- Dummy Komentar -->
              <?php foreach ($testimoni as $ts) : ?>

                <div class="mb-3">
                  <h6 class="mb-1 fw-bold"><?= $ts['nama']; ?></h6>
                  <p class="mb-1"><?= $ts['testimony']; ?></p>
                  <div class="d-flex justify-content-between">
                    <div class="mt-2 d-flex align-items-center">
                      <div class="mt-2 d-flex align-items-center">
                        <img class="img-thumbnail me-1" width="30" height="30" src="/assets/img/survey/<?= $ts['kepuasan']; ?>.png" alt="">
                        <span class="text-light fw-medium">
                          <?php if ($ts['kepuasan'] == 1) : ?>
                            Sangat Puas
                          <?php elseif ($ts['kepuasan'] == 2) : ?>
                            Puas
                          <?php elseif ($ts['kepuasan'] == 3) : ?>
                            Cukup
                          <?php elseif ($ts['kepuasan'] == 4) : ?>
                            Kurang
                          <?php endif; ?>
                        </span>
                      </div>
                    </div>
                    <small class="text-muted mt-2"><?= date("d/m/Y", strtotime($ts['tanggal'])); ?></small>
                  </div>
                </div>
                <hr>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div style="margin: 10vh 0;" class="removeCont"></div>
</div>

<!-- testimoni SIMaTa End -->

<!-- Login -->
<div class="text-center my-5">

    <form action="<?= base_url('login') ?>">
        <button class="btn btn-primary px-4 py-2 shadow">
            <i class='bx bx-log-in'></i> Login Petugas
        </button>
    </form>

</div>

<script>
  // =========================
  // SELECTABLE IMAGE
  // =========================
  document.querySelectorAll('.selectable img').forEach(img => {
    img.addEventListener('click', () => {
      const images = document.querySelectorAll('.selectable img');

      images.forEach(i => {
        i.classList.remove('active', 'dimmed');
      });

      img.classList.add('active');

      images.forEach(i => {
        if (i !== img) i.classList.add('dimmed');
      });
    });
  });

  // =========================
  // DARK MODE SYSTEM (FIX)
  // =========================
  const toggleBtn = document.getElementById('themeToggle');
  const html = document.documentElement;
  const icon = toggleBtn?.querySelector('i');

  function applyTheme(theme) {
    if (theme === 'dark') {
      html.classList.add('dark-mode');
      icon?.classList.replace('bx-moon', 'bx-sun');
    } else {
      html.classList.remove('dark-mode');
      icon?.classList.replace('bx-sun', 'bx-moon');
    }
  }

  // Load theme saat buka halaman
  applyTheme(localStorage.getItem('theme'));

  // Toggle click
  toggleBtn?.addEventListener('click', () => {
    const isDark = html.classList.contains('dark-mode');
    const newTheme = isDark ? 'light' : 'dark';

    localStorage.setItem('theme', newTheme);
    applyTheme(newTheme);
  });
</script>