<!-- ================= KAMERA ================= -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasStart">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Live Kamera</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="p-3">
    <div id="my_camera"></div>
  </div>
</div>

<div class="row">

  <!-- ================= KAMERA PREVIEW ================= -->
  <div class="col-md-6 col-lg-4 mb-3">
    <div class="card">
      <div id="results">
        <img class="card-img-top" src="<?= base_url('assets/img/users/default.jpg') ?>">
      </div>

      <div class="card-body">
        <form action="<?= site_url('bukutamu/unRekam') ?>" method="post">

          <div class="d-grid d-sm-flex">
            <button class="btn btn-outline-success mx-1 mt-1"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasStart">
              <i class='bx bx-video'></i> Live
            </button>

            <button class="btn btn-primary mx-1 mt-1"
                    type="button"
                    onclick="take_snapshot()">
              <i class='bx bxs-camera'></i> Take
            </button>

            <button class="btn btn-outline-danger mx-1 mt-1"
                    id="reset"
                    type="submit"
                    disabled>
              <i class='bx bx-trash'></i> Delete
            </button>

            <input type="hidden" name="hapusGmr" id="gambar1">
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- ================= FORM ================= -->
  <div class="col-xl col-md-6 col-lg-8">
    <div class="card mb-4">

      <div class="card-header">
        <h5>Form Tamu Masuk</h5>
        <small class="text-muted">Form Rekam Tamu Berkunjung</small>
      </div>

      <div class="card-body">

        <form action="<?= site_url('bukutamu/rekam') ?>" method="post">
          <?= csrf_field(); ?>

          <!-- NAMA -->
          <div class="mb-3">
            <label class="form-label">Nama Tamu</label>

            <?php if (isset($validation) && $validation->hasError('namaTamu')): ?>
              <div class="text-danger"><?= $validation->getError('namaTamu') ?></div>
            <?php endif; ?>

            <div class="input-group">
              <span class="input-group-text"><i class="bx bx-user"></i></span>
              <input type="text" name="namaTamu" class="form-control"
                     value="<?= old('namaTamu') ?>">
            </div>
          </div>

          <!-- ALAMAT -->
          <div class="mb-3">
            <label class="form-label">Alamat Tamu</label>

            <?php if (isset($validation) && $validation->hasError('alamatTamu')): ?>
              <div class="text-danger"><?= $validation->getError('alamatTamu') ?></div>
            <?php endif; ?>

            <input type="text" name="alamatTamu" class="form-control"
                   value="<?= old('alamatTamu') ?>">
          </div>

          <!-- ROW -->
          <div class="row">

            <!-- DITEMUI -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Ingin Bertemu</label>

              <?php if (isset($validation) && $validation->hasError('ditemui')): ?>
                <div class="text-danger"><?= $validation->getError('ditemui') ?></div>
              <?php endif; ?>

              <select name="ditemui" class="form-select">
                <option value="">- pilih -</option>

                <?php foreach ($users as $u): ?>
                  <?php if ($u['ditemui'] == 1): ?>
                    <option value="<?= $u['id'] ?>"
                      <?= old('ditemui') == $u['id'] ? 'selected' : '' ?>>
                      <?= esc($u['jabatan']) ?>
                    </option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- TANGGAL -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Tanggal Berkunjung</label>

              <?php if (isset($validation) && $validation->hasError('tanggalBerkunjung')): ?>
                <div class="text-danger"><?= $validation->getError('tanggalBerkunjung') ?></div>
              <?php endif; ?>

              <input type="date"
                     name="tanggalBerkunjung"
                     class="form-control"
                     value="<?= old('tanggalBerkunjung') ?: date('Y-m-d') ?>"
                     min="<?= date('Y-m-d') ?>">
            </div>

          </div>

          <!-- KEPERLUAN -->
          <div class="mb-3">
            <label class="form-label">Keperluan</label>

            <?php if (isset($validation) && $validation->hasError('keperluanTamu')): ?>
              <div class="text-danger"><?= $validation->getError('keperluanTamu') ?></div>
            <?php endif; ?>

            <textarea name="keperluanTamu" class="form-control"><?= esc(old('keperluanTamu')) ?></textarea>
          </div>

          <!-- RADIO -->
          <div class="mb-3">
            <label class="form-label d-block">Mengatasnamakan</label>

            <?php if (isset($validation) && $validation->hasError('mengatasnamakan')): ?>
              <div class="text-danger"><?= $validation->getError('mengatasnamakan') ?></div>
            <?php endif; ?>

            <div class="form-check form-check-inline">
              <input type="radio" name="mengatasnamakan" value="Personal"
                     class="form-check-input"
                     <?= old('mengatasnamakan') == 'Personal' ? 'checked' : '' ?>>
              <label class="form-check-label">Personal</label>
            </div>

            <div class="form-check form-check-inline">
              <input type="radio" name="mengatasnamakan" value="Organisasi"
                     class="form-check-input"
                     <?= old('mengatasnamakan') == 'Organisasi' ? 'checked' : '' ?>>
              <label class="form-check-label">Organisasi</label>
            </div>
          </div>

          <!-- HIDDEN -->
          <input type="hidden" name="gambar" id="gambar" value="tidak ada">

          <!-- BUTTON -->
          <button type="submit" class="btn btn-primary">
            <i class='bx bxs-save'></i> Simpan
          </button>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- ================= JS ================= -->
<script src="<?= base_url('assets/js/webcamjs/webcam.min.js') ?>"></script>
<script src="<?= base_url('assets/js/js_me/webcam.js') ?>"></script>