<?php
// ================= FORMAT WHATSAPP =================
if (!function_exists('formatWA')) {
    function formatWA($no){
    $no = preg_replace('/[^0-9]/', '', $no);

    // ubah 08 → +62
    if(substr($no, 0, 2) == '08'){
      $no = '62' . substr($no, 1);
    }

    // kalau sudah 62 lanjut
    if(substr($no, 0, 2) == '62'){
      return '+'.substr($no,0,2).' '
          . substr($no,2,3) . '-'
          . substr($no,5,4) . '-'
          . substr($no,9);
    }

    return $no;
  }
}

// ================= FORMAT TELEPON =================
if (!function_exists('formatTelpKantor')) {
  function formatTelpKantor($no){
    $no = preg_replace('/[^0-9]/', '', $no);

    if(strlen($no) <= 4){
      return $no;
    }

    return '(' . substr($no,0,4) . ') ' . substr($no,4);
  }
}

// ================= ICON SOSIAL MEDIA =================
if (!function_exists('getSocialIcon')) {
  function getSocialIcon($platform){
    $platform = strtolower($platform);

    switch ($platform) {
      case 'facebook':
        return 'bxl-facebook';
      case 'instagram':
        return 'bxl-instagram';
      case 'twitter':
        return 'bxl-twitter';
      case 'youtube':
        return 'bxl-youtube';
      case 'tiktok':
        return 'bxl-tiktok';
      case 'linkedin':
        return 'bxl-linkedin';
      default:
        return 'bx-globe'; // default icon
    }
  }
}
?>

<!-- Footer Start -->
<div class="container-fluid footer-custom pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="container py-5 px-lg-5">
    
    <h3 class="mb-4 text-center fw-bold">Statistik Pengunjung</h3>

    <div class="row g-3 text-center">

      <div class="col-6 col-md-3">
        <div class="card-stat rounded p-4 shadow-sm">
          <h2 class="mb-1"><?= $today ?></h2>
          <small>Hari Ini</small>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card-stat rounded p-4 shadow-sm">
          <h2 class="mb-1"><?= $month ?></h2>
          <small>Bulan Ini</small>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card-stat rounded p-4 shadow-sm">
          <h2 class="mb-1"><?= $year ?></h2>
          <small>Tahun Ini</small>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card-stat rounded p-4 shadow-sm">
          <h2 class="mb-1"><?= $total ?></h2>
          <small>Total</small>
        </div>
      </div>

    </div>
    <br>

    <div class="row gy-5 gx-5 pt-3">

      <!-- ================== KIRI ================== -->
      <div class="col-lg-7">
        <div class="row g-4">

          <!-- ================== KONTAK ================== -->
          <div class="col-md-4 px-3">
            <h5 class="fw-bold text-white mb-4">Kontak Kami</h5>

            <?php if(!empty($kontak)): ?>
              <?php foreach($kontak as $k): ?>

                <?php if($k['platform']=='whatsapp'): ?>
                  <a href="<?= $k['url'] ?>" 
                    class="d-flex align-items-start text-white text-decoration-none mb-3">

                    <!-- ICON -->
                    <div style="width:28px;">
                      <i class='bx bxl-whatsapp mt-1'></i>
                    </div>

                    <!-- TEXT -->
                    <div>
                      <div class="fw-semibold"><?= esc($k['name']) ?></div>
                      <small class="text-muted">
                        <?= formatWA(str_replace('https://wa.me/','',$k['url'])) ?>
                      </small>
                    </div>

                  </a>
                <?php endif; ?>


                <?php if($k['platform']=='telepon'): ?>
                  <a href="<?= $k['url'] ?>" 
                    class="d-flex align-items-start text-white text-decoration-none mb-3">

                    <!-- ICON -->
                    <div style="width:28px;">
                      <i class='bx bx-phone mt-1'></i>
                    </div>

                    <!-- TEXT -->
                    <div>
                      <div class="fw-semibold"><?= esc($k['name']) ?></div>
                      <small class="text-muted">
                        <?= formatTelpKantor(str_replace('tel:','',$k['url'])) ?>
                      </small>
                    </div>

                  </a>
                <?php endif; ?>

              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-white">Belum ada kontak...</p>
            <?php endif; ?>
          </div>

          <!-- ================== SOSIAL MEDIA ================== -->
          <div class="col-md-4 px-3">
            <h5 class="fw-bold text-white mb-4">Sosial Media</h5>

            <?php if(!empty($sosmed)): ?>
              <?php foreach($sosmed as $s): ?>
                <a href="<?= $s['url'] ?>" target="_blank"
                   class="d-flex align-items-center mb-3 text-white">

                  <i class="bx <?= getSocialIcon($s['platform']) ?> me-2"></i>
                  
                  <div class="fw-semibold"><?= esc($s['name']) ?></div>

                  <i class="bx bx-link-external ms-auto"></i>
                </a>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-white">Belum ada sosial media...</p>
            <?php endif; ?>
          </div>

          <!-- ================== TAUTAN ================== -->
          <div class="col-md-4 px-3">
            <h5 class="fw-bold text-white mb-4">Tautan Terkait</h5>

            <?php if(!empty($link)): ?>
              <?php foreach($link as $l): ?>
                <a href="<?= $l['url'] ?>" target="_blank"
                   class="d-flex align-items-center mb-3 text-white">

                  <i class="bx bx-world me-2"></i>

                  <div class="fw-semibold"><?= esc($l['name']) ?></div>                  

                  <i class="bx bx-link-external ms-auto"></i>
                </a>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-white">Belum ada banner link...</p>
            <?php endif; ?>
          </div>

        </div>
      </div>

      <!-- ================== MAP ================== -->
      <div class="col-lg-5">
        <div class="bg-light rounded p-2">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15947.889278282842!2d115.382124!3d-2.1642349!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc42e44dd0491bd5f!2sBadan%20Pengelola%20Pajak%20dan%20Retribusi%20Daerah%20(BPPRD)%20Kabupaten%20Tabalong!5e0!3m2!1sid!2sid!4v1661936348923!5m2!1sid!2sid"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            width="100%"
            height="300">
          </iframe>
        </div>
      </div>

    </div>

  </div>

  <!-- ================== COPYRIGHT ================== -->
  <div class="container px-lg-5">
    <hr class="text-white">

    <div class="d-flex flex-wrap justify-content-between pt-2 pb-4 flex-md-row flex-column text-theme">
      <div class="mb-2 mb-md-0">
        Copyright ©
        <script>
          document.write(new Date().getFullYear());
        </script>,
        <a href="https://bapenda.tabalongkab.go.id" target="_blank"
          class="text-theme fw-bold">
          BAPENDA Kabupaten Tabalong
        </a>
      </div>
    </div>
  </div>

</div>
<!-- Footer End -->

<!-- JavaScript Libraries -->
<script src="<?= base_url("/"); ?>lib/wow/wow.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="<?= base_url("/"); ?>lib/easing/easing.min.js"></script>
<script src="<?= base_url("/"); ?>lib/waypoints/waypoints.min.js"></script>
<script src="<?= base_url("/"); ?>lib/counterup/counterup.min.js"></script>
<script src="<?= base_url("/"); ?>lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="<?= base_url("/"); ?>js/main.js"></script>

<script>
if (window.innerWidth < 540) {
  const h1 = document.querySelectorAll('.tengah');
  h1.forEach((h1) => {
    h1.classList.add('text-center');
  });
}
</script>