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
            <div class="col-sm-12 mb-4">
                <div class="mx-auto card mb-3 shadows" style="max-width: 700px;">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <img style="" src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img-top img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h3 class="card-title"><?= ucwords($user['name']); ?> <small>(<?php foreach ($userRole as $sr) {
                                    if ($sr['id'] == $user['role_id']) {
                                    echo $sr['role'];
                                    }
                                    } ?>)</smaill></h3>
                                <p class="card-text"><?= ucwords($user['email']); ?></p>
                                <p class="card-text"><small class="text-muted">Terdaftar dari <?= date('d F Y', $user['date_created']); ?></small></p>
                                <br>
                                <a class="mr-1 btn btn-primary" href="<?= base_url('profile/edit'); ?>">Ganti Foto Profile</a>
                                <a class="ml-1 btn btn-primary" href="<?= base_url('profile/changepassword'); ?>">Ubah Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->