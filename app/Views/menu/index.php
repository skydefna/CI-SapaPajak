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
                            <li class="breadcrumb-item active"><?= $title; ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?= $title; ?></h4>
                </div>
            </div>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-md-9 col-lg-9 col-xl-9">
                <div class="card m-b-30">
                    <h6 class="card-header m-0">Daftar Menu</h6>
                    <div class="card-body">
                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1cm;" scope="col">#</th>
                                    <th style="width: 1cm;" scope="col">Nama Menu</th>
                                    <th scope="col">Controllers</th>
                                    <th style="width: 2cm;" scope="col">Icon</th>
                                    <th style="width: 3cm;" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                <?php foreach ($menu as $m) : ?>
                                    <tr>
                                        <td scope="row"><b><?= $i + 1; ?></b></td>
                                        <td><?= $m['name']; ?></td>
                                        <td><?= $m['menu']; ?></td>
                                        <td><i style="color: rgb(82, 82, 82);" class="<?= $m['icon']; ?>"></i></td>
                                        <td>
                                            <div class="button-items">
                                                <button disabled class="btn hps1<?= $m['id']; ?> btn-success waves-effect waves-success" data-toggle="tooltip" data-placement="left" title="" data-original-title="Edit" onclick="edit<?= $m['id']; ?>()"><i class="mdi mdi-lead-pencil"></i></button>
                                                <button disabled class="btn hps2<?= $m['id']; ?> btn-danger waves-effect waves-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete" onclick="hapus<?= $m['id']; ?>()"><i class="mdi mdi-delete"></i></button>
                                                <!--<button disabled class="btn aktifMenus<?= $m['id']; ?> btn-warning waves-effect waves-warning" data-toggle="tooltip" data-placement="right" title="" data-original-title="Aktifkan" onclick="aktif<?= $m['id']; ?>()"><i class="mdi mdi-check"></i></button>-->
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <script>
                                        if (<?= $m['id']; ?> > 3) {
                                            document.getElementsByClassName("hps1<?= $m['id']; ?>")[0].removeAttribute("disabled");
                                            document.getElementsByClassName("hps2<?= $m['id']; ?>")[0].removeAttribute("disabled");
                                        }
                                        
                                        if(<?= $m['aktif']; ?> == 0){
                                            document.getElementsByClassName("aktifMenus<?= $m['id']; ?>")[0].removeAttribute("disabled");
                                        }

                                        function edit<?= $m['id']; ?>() {
                                            window.location = "<?= base_url('menu/edit/') . $m['id']; ?>";
                                        };

                                        function hapus<?= $m['id']; ?>() {
                                            var yakin = confirm('Yakin ingin hapus Menu "<?= $m['menu']; ?>" ??');
                                            if (yakin) {
                                                window.location = "<?= base_url('menu/delete/') . $m['id']; ?>";
                                            };
                                        };
                                        function aktif<?= $m['id']; ?>() {
                                            var yakin = confirm('Aktifkan Menu "<?= $m['menu']; ?>" ??');
                                            if (yakin) {
                                                window.location = "<?= base_url('menu/aktifMenu/') . $m['id']; ?>";
                                            };
                                        };
                                    </script>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h6 class="card-header m-0">Menu Baru</h6>
                    <div class="card-body">
                        <div class="form-group">
                            <form action="<?= base_url('menu'); ?>" method="post">
                                <input type="text" autofocus class="mt-2 form-control" id="name" name="name" placeholder="Nama Menu...">
                                <?php if (isset($validation) && $validation->hasError('name')) : ?>
                                    <small class="text-danger"><?= $validation->getError('name'); ?></small>
                                <?php endif; ?>
                                <input type="text" autofocus class="mt-2 form-control" id="menu" name="menu" placeholder="Nama Controllers...">
                                <?php if (isset($validation) && $validation->hasError('name')) : ?>
                                    <small class="text-danger"><?= $validation->getError('name'); ?></small>
                                <?php endif; ?>
                                <input type="hidden" value="mdi mdi-flower" autofocus class="mt-2 form-control" id="icon" name="icon">
                                <button type="submit" class="btn btn-primary mt-2 btn-block"><i class="mdi mdi-content-save"></i> Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel"><i class="mdi mdi-folder-plus"></i> New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" autofocus class="form-control" id="id" name="id" placeholder="Code">
                        <input type="text" autofocus class="mt-2 form-control" id="menu" name="menu" placeholder="Nama menu...">
                        <input type="hidden" value="mdi mdi-flower" autofocus class="mt-2 form-control" id="icon" name="icon">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>