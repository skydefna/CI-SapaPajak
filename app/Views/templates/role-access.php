</header>
<!-- End Navigation Bar -->

<!-- ================= CONTENT ================= -->
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    
                    <div class="btn-group float-end">
                        <ol class="breadcrumb p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Administrator/role'); ?>">Role</a>
                            </li>
                            <li class="breadcrumb-item active"><?= esc($title); ?></li>
                        </ol>
                    </div>

                    <h4 class="page-title"><?= esc($title); ?></h4>
                </div>
            </div>
        </div>

        <!-- Flash Message -->
        <?= session()->getFlashdata('message'); ?>

        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6">
                
                <div class="card mb-3">
                    
                    <h6 class="card-header">
                        Role : <?= esc($role['role']); ?>
                    </h6>

                    <div class="card-body">

                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Controllers</th>
                                    <th>Access</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($menu as $m) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= esc($m['menu']); ?></td>
                                        <td>
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input check-role"
                                                    type="checkbox"
                                                    id="check<?= $m['id']; ?>"
                                                    <?= check_access($role['id'], $m['id']); ?>
                                                    data-role="<?= $role['id']; ?>"
                                                    data-menu="<?= $m['id']; ?>"
                                                >
                                                <label class="form-check-label" for="check<?= $m['id']; ?>"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <a class="btn btn-outline-secondary mt-2" href="<?= base_url('Administrator/role'); ?>">
                            <i class="mdi mdi-undo-variant"></i> Back
                        </a>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- End of Main Content -->