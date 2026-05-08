<div class="inputTamu">
    <h5 class="text-center">Isi Form Tamu</h5>

    <div class="row">

        <!-- LEFT CARD -->
        <div class="col-md-4 mt-4 animate__animated animate__fadeIn">
            <div class="card text-center">
                <img src="<?= base_url('assets/img/illustrations/undraw_businessman_re_mlee.png') ?>"
                     class="img-fluid img-thumbnail mx-5 mt-5">

                <div class="card-body">
                    <i class='bx bxs-user fs-2 m-3'></i>
                    <h5>Tamu Personal</h5>
                    <p>Tokoh Masyarakat, Wajib Pajak, dll.</p>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="col-md-8 py-4 animate__animated animate__fadeIn">

            <div class="card">
                <div class="card-header">
                    <h5>Buku Tamu Personal</h5>
                </div>

                <div class="card-body">

                    <form action="<?= site_url('tamu/personal') ?>" method="post">
                        <?= csrf_field(); ?>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Anda</label>

                            <?php if (isset($validation) && $validation->hasError('namaTamu')) : ?>
                                <div class="text-danger">
                                    <?= $validation->getError('namaTamu') ?>
                                </div>
                            <?php endif; ?>

                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text"
                                       name="namaTamu"
                                       class="form-control"
                                       value="<?= old('namaTamu') ?>">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>

                            <?php if (isset($validation) && $validation->hasError('alamatTamu')) : ?>
                                <div class="text-danger">
                                    <?= $validation->getError('alamatTamu') ?>
                                </div>
                            <?php endif; ?>

                            <input type="text"
                                   name="alamatTamu"
                                   class="form-control"
                                   value="<?= old('alamatTamu') ?>">
                        </div>

                        <!-- Ditemui -->
                        <div class="mb-3">
                            <label class="form-label">Ingin Bertemu</label>

                            <select name="ditemui" class="form-select">
                                <option value="">- pilih -</option>

                                <?php foreach ($users as $u) : ?>
                                    <?php if ($u['ditemui'] == 1) : ?>
                                        <option value="<?= $u['id'] ?>"
                                            <?= old('ditemui') == $u['id'] ? 'selected' : '' ?>>
                                            <?= esc($u['jabatan']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Janjian</label>

                            <input type="date"
                                   name="tanggalBerkunjung"
                                   class="form-control"
                                   value="<?= old('tanggalBerkunjung') ?>"
                                   min="<?= date('Y-m-d') ?>">
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-3">
                            <label class="form-label">Keperluan</label>

                            <textarea name="keperluanTamu"
                                      class="form-control"><?= old('keperluanTamu') ?></textarea>
                        </div>

                        <!-- Hidden -->
                        <input type="hidden" name="gambar" value="tidak ada">
                        <input type="hidden" name="mengatasnamakan" value="Personal">

                        <!-- Button -->                        
                        <div class="cf-turnstile mb-3"
                            data-sitekey="0x4AAAAAADLJnWkJP2FMwVu6">
                        </div>

                        <!-- Button -->
                        <button class="btn btn-primary">
                            <i class="bx bxs-send"></i> Kirim
                        </button>

                        <a href="<?= base_url('tamu/buku_tamu') ?>"
                           class="btn btn-outline-secondary">
                           Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>