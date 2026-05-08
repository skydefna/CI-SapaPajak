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

        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-md-5 col-lg-5 col-xl-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form action="<?= base_url('profile/changepassword'); ?>" method="post">
                        <input type="hidden" name="user_log" value="<?= $user["name"]; ?>">
                            <div class="form-group">
                                <label for="current_password">Password lama</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" autofocus>
                                <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="new_password1">Password baru</label>
                                <input type="password" class="form-control" id="new_password1" name="new_password1">
                                <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="new_password2">Konfirmasi Password baru</label>
                                <input type="password" class="form-control" id="new_password2" name="new_password2">
                                <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <a class="btn mb-1 btn-outline-secondary" href="<?= base_url('profile'); ?>"><i class="mdi mdi-undo-variant"></i> Back</a>
                                <button type="submit" class="btn mb-1 btn-primary"><i class="mdi mdi-content-save"></i> Save</button>
                        </form>
                    </div>
                </div>



            </div>
        </div>



    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->