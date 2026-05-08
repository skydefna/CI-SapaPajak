<script>
    let responsiveScrollx = screen.width < 1400;

    $(document).ready(function() {
        $("#myTable").DataTable({
            lengthChange: true,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            pageLength: 5,
            language: {
                url: "<?= base_url('assets/id.json'); ?>"
            },
            scrollX: responsiveScrollx,
            order: [[0, "asc"]],
            pagingType: "numbers",
        });
    });

    function simpan() {
        document.getElementById("simpan").setAttribute("disabled", true);
    }
</script>

<div class="row">

    <!-- ================= TABLE ================= -->
    <div class="col-xl-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Table Karyawan</h5>
                <small class="text-muted float-end">Data Karyawan</small>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>NIP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($users as $d) : ?>
                            <?php if ($d['ditemui'] == 1) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= esc($d['name']); ?></td>
                                    <td><?= esc($d['jabatan']); ?></td>
                                    <td><?= esc($d['nip']); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>

                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('Karyawan/edit/'.$d['id']); ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>

                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#hapus<?= $d['id']; ?>">
                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL HAPUS -->
                                <div class="modal fade" id="hapus<?= $d['id']; ?>">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Hapus data</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <a href="<?= base_url('Karyawan/hapusKaryawan/'.$d['id']); ?>" class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= FORM ================= -->
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Form Karyawan</h5>
            </div>

            <div class="card-body">
                <form action="<?= base_url('Karyawan'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input name="nama" value="<?= old('nama'); ?>" class="form-control">
                        <div class="text-danger"><?= $validation->getError('nama'); ?></div>
                    </div>

                    <!-- JABATAN -->
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input name="jabatan" value="<?= old('jabatan'); ?>" class="form-control">
                        <div class="text-danger"><?= $validation->getError('jabatan'); ?></div>
                    </div>

                    <!-- NIP -->
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input name="nip" type="number" value="<?= old('nip'); ?>" class="form-control">
                        <div class="text-danger"><?= $validation->getError('nip'); ?></div>
                    </div>

                    <button onclick="simpan()" id="simpan" class="btn btn-primary">
                        <i class="bx bxs-save"></i> Simpan
                    </button>

                </form>
            </div>
        </div>
    </div>

</div>