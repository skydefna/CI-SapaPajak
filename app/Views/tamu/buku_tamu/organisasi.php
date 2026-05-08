
<div class="inputTamu">
    <h5 class="text-center">Isi Form Tamu</h5>

    <div class="row">
        <!-- LEFT -->
        <div class="col-sm-12 col-md-4 mt-3">
            <div class="row">
                <div class="col">
                    <div class="col-12">
                        <div class="card">
                            <img src="<?= base_url('assets/img/illustrations/undraw_stand_out_-1-oag.svg'); ?>" 
                                 class="img-fluid img-thumbnail mx-5 mt-5">

                            <div class="card-body text-center">
                                <i class='bx bxs-user fs-1 m-3'></i>
                                <h5 class="card-title">Tamu Organisasi</h5>
                                <p class="card-text">Instansi Pemerintahan, Perusahaan, dll.</p>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-sm-12 col-md-8">
            <div class="row mt-3">
                <div class="col-xxl">
                    <div class="card mb-4">

                        <div class="card-header">
                            <h5>Buku Tamu Personal</h5>
                        </div>

                        <div class="card-body">
                            <form action="<?= site_url('tamu/personal'); ?>" method="post" enctype="multipart/form-data">

                                <?= csrf_field(); ?>

                                <!-- NAMA -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        <?php if (isset($validation) && $validation->getError('namaTamu')): ?>
                                            <div class="text-danger"><?= $validation->getError('namaTamu'); ?></div>
                                        <?php else: ?>
                                            Nama Anda
                                        <?php endif; ?>
                                    </label>

                                    <input type="text" name="namaTamu" class="form-control"
                                           value="<?= old('namaTamu'); ?>" placeholder="John Doe">
                                </div>

                                <!-- ALAMAT -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        <?php if (isset($validation) && $validation->getError('alamatTamu')): ?>
                                            <div class="text-danger"><?= $validation->getError('alamatTamu'); ?></div>
                                        <?php else: ?>
                                            Alamat Anda
                                        <?php endif; ?>
                                    </label>

                                    <input type="text" name="alamatTamu" class="form-control"
                                           value="<?= old('alamatTamu'); ?>">
                                </div>

                                <div class="row">
                                    <!-- DITEMUI -->
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <?php if (isset($validation) && $validation->getError('ditemui')): ?>
                                                    <div class="text-danger"><?= $validation->getError('ditemui'); ?></div>
                                                <?php else: ?>
                                                    Ingin Bertemu
                                                <?php endif; ?>
                                            </label>

                                            <select name="ditemui" class="form-select">
                                                <option value="">- pilih -</option>

                                                <?php foreach ($users as $u): ?>
                                                    <?php if ($u['ditemui'] == 1): ?>
                                                        <option value="<?= $u['jabatan']; ?>"
                                                            <?= old('ditemui') == $u['jabatan'] ? 'selected' : ''; ?>>
                                                            <?= $u['jabatan']; ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- TANGGAL -->
                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <?php if (isset($validation) && $validation->getError('tanggalBerkunjung')): ?>
                                                    <div class="text-danger"><?= $validation->getError('tanggalBerkunjung'); ?></div>
                                                <?php else: ?>
                                                    Tanggal Janjian
                                                <?php endif; ?>
                                            </label>

                                            <input type="date" name="tanggalBerkunjung"
                                                   class="form-control"
                                                   value="<?= old('tanggalBerkunjung'); ?>"
                                                   min="<?= date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- KEPERLUAN -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        <?php if (isset($validation) && $validation->getError('keperluanTamu')): ?>
                                            <div class="text-danger"><?= $validation->getError('keperluanTamu'); ?></div>
                                        <?php else: ?>
                                            Keperluan
                                        <?php endif; ?>
                                    </label>

                                    <textarea name="keperluanTamu" class="form-control"><?= old('keperluanTamu'); ?></textarea>
                                </div>

                                <!-- Upload -->
                                <div class="mb-3">
                                    <label class="form-label">Upload Surat Tugas</label>
                                    <input class="form-control" type="file" name="surat">
                                </div>

                                <!-- HIDDEN -->
                                <input type="hidden" name="gambar" value="tidak ada">
                                <input type="hidden" name="mengatasnamakan" value="Personal">

                                <!-- BUTTON -->
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="<?= site_url('tamu/buku_tamu'); ?>" class="btn btn-secondary">Kembali</a>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>