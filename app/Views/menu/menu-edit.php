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
                            <li class="breadcrumb-item"><a href="#">Annex</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('menu'); ?>">Menu Management</a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?= $title; ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form action="<?= site_url('menu/edit/' . $menu['id']); ?>" method="post">
    
                            <?= csrf_field(); ?>

                            <input type="hidden" name="id" value="<?= esc($menu['id']); ?>">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Controllers</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext" name="menu" value="<?= old('menu', $menu['menu']); ?>">

                                    <?php if (isset($validation) && $validation->hasError('menu')) : ?>
                                        <small class="text-danger"><?= $validation->getError('menu'); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Menu</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" value="<?= old('name', $menu['name']); ?>">

                                    <?php if (isset($validation) && $validation->hasError('name')) : ?>
                                        <small class="text-danger"><?= $validation->getError('name'); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Icon</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="icon" value="<?= old('icon', $menu['icon']); ?>">

                                    <?php if (isset($validation) && $validation->hasError('icon')) : ?>
                                        <small class="text-danger"><?= $validation->getError('icon'); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row justify-content-end">
                                <div class="col-sm-9">
                                    <a class="btn btn-secondary" href="<?= site_url('menu'); ?>">Back</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>




    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->