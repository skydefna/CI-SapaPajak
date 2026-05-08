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
                            <li class="breadcrumb-item"><a href="#">Menu</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('menu/submenu'); ?>">Submenu Management</a></li>
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?= $title; ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 col-lg-7 col-xl-7">
                <div class="card m-b-30">
                    <div class="card-body">                    
                        <form action="<?= site_url('menu/subMenuEdit/' . $subMenu['id']); ?>" method="post">
    
                            <?= csrf_field(); ?>

                            <input type="hidden" name="id" value="<?= esc($subMenu['id']); ?>">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Submenu</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" class="form-control" value="<?= old('title', $subMenu['title']); ?>">

                                    <?php if (isset($validation) && $validation->hasError('title')) : ?>
                                        <small class="text-danger"><?= $validation->getError('title'); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Menu</label>
                                <div class="col-sm-8">
                                    <select name="menu_id" class="form-control" required>
                                        <?php foreach ($menu as $m) : ?>
                                            <option value="<?= $m['id']; ?>" <?= ($m['id'] == $subMenu['menu_id']) ? 'selected' : '' ?>>
                                                <?= esc($m['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">URL</label>
                                <div class="col-sm-8">
                                    <input type="text" name="url" class="form-control" value="<?= old('url', $subMenu['url']); ?>">

                                    <?php if (isset($validation) && $validation->hasError('url')) : ?>
                                        <small class="text-danger"><?= $validation->getError('url'); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Icon</label>
                                <div class="col-sm-8">
                                    <input type="text" name="icons" class="form-control" value="<?= old('icons', $subMenu['icons']); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Active</label>
                                <div class="col-sm-8">
                                    <input type="radio" name="is_active" value="1" <?= ($subMenu['is_active'] == 1) ? 'checked' : ''; ?>> Yes
                                    <input type="radio" name="is_active" value="0" <?= ($subMenu['is_active'] == 0) ? 'checked' : ''; ?>> No
                                </div>
                            </div>

                            <div class="form-group row justify-content-end">
                                <div class="col-sm-8 mt-2">
                                    <a class="btn btn-secondary" href="<?= site_url('menu/submenu'); ?>">Back</a>
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