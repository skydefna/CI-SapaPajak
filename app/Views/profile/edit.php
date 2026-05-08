</header>
<!-- End Navigation Bar=============================================================================-->

<!-- ISI ================================================================================================= -->
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Profile</a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?= $title; ?></h4>
                </div>
            </div>
        </div>

        <?= form_open_multipart('profile/edit'); ?>
        <input type="hidden" name="user_log" value="<?= $user["name"]; ?>">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card mb-3">
                    <h6 class="card-header m-0">Ganti Foto</h6>
                    <div class="card-body">
                        <input type="file" onchange="loadFile(event)" class="dropify" id="image" name="image" data-height="350" data-default-file="<?= base_url('assets/img/profile/') . $user['image']; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card m-b-30">
                    <h6 class="card-header m-0">Edit Nama</h6>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control-plaintext" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control-plaintext" id="role" name="role" value="<?php foreach ($userRole as $sr) {
                                                                                                                    if ($sr['id'] == $user['role_id']) {
                                                                                                                        echo $sr['role'];
                                                                                                                    }
                                                                                                                } ?>">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <a class="btn mb-1 btn-outline-secondary" href="<?= base_url('profile'); ?>"><i class="mdi mdi-undo-variant"></i> Back</a>
                                <button type="submit" class="btn mb-1 btn-primary"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->