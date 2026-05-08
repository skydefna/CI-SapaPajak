</header>
<!-- End Navigation Bar=============================================================================-->

<div class="wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <h4><?= esc($title); ?></h4>
            </div>
        </div>

        <!-- VALIDATION ERROR -->
        <?php if (isset($validation) && $validation->getErrors()) : ?>
            <div class="alert alert-danger">
                <?= implode('<br>', $validation->getErrors()); ?>
            </div>
        <?php endif; ?>

        <!-- FLASH MESSAGE -->
        <?= session()->getFlashdata('message'); ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <h6 class="card-header">Daftar Submenu</h6>
                    <div class="card-body">

                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Submenu</th>
                                    <th>Controllers</th>
                                    <th>Icon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($subMenu as $sm) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>

                                        <td>
                                            <?= esc($sm['title']); ?>
                                            <?= ($sm['is_active'] == 1)
                                                ? '<i class="mdi mdi-check-circle text-success"></i>'
                                                : '<i class="mdi mdi-close-circle text-danger"></i>'; ?>
                                        </td>

                                        <td><?= esc($sm['menu']); ?></td>

                                        <td>
                                            <i class="<?= esc($sm['icons']); ?>"></i>
                                        </td>

                                        <td>
                                            <a href="<?= site_url('menu/subMenuEdit/' . $sm['id']); ?>" class="btn btn-success btn-sm">
                                                Edit
                                            </a>

                                            <a href="<?= site_url('menu/subMenuDelete/' . $sm['id']); ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin hapus submenu?')">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- FORM TAMBAH -->
            <div class="col-md-4">
                <form action="<?= site_url('menu/submenu'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="card">
                        <h6 class="card-header">Submenu Baru</h6>
                        <div class="card-body">

                            <div class="mb-3">
                                <input type="text" name="title" class="form-control"
                                       value="<?= old('title'); ?>" placeholder="Nama Submenu">
                            </div>

                            <div class="mb-3">
                                <select name="menu_id" class="form-control">
                                    <option value="">Pilih Menu</option>
                                    <?php foreach ($menu as $m) : ?>
                                        <option value="<?= $m['id']; ?>">
                                            <?= esc($m['menu']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <input type="text" name="url" class="form-control"
                                       value="<?= old('url'); ?>" placeholder="URL Submenu">
                            </div>

                            <div class="mb-3">
                                <label>Active?</label><br>
                                <input type="radio" name="is_active" value="1" checked> Yes
                                <input type="radio" name="is_active" value="0"> No
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Simpan
                            </button>

                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>