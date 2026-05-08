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
            order: [[2, "asc"]],
            pagingType: "numbers",
        });
    });

    function simpan() {
        document.getElementById("simpan").setAttribute("disabled", true);
    }
</script>

<div class="row">

    <!-- ================= FORM EDIT ================= -->
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Form Edit</h5>
                <small class="text-muted">Form Ubah Karyawan</small>
            </div>

            <div class="card-body">
                <form action="<?= base_url('Karyawan/edit/'.$karyawan['id']); ?>" method="post">
                    <?= csrf_field(); ?>

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input autofocus 
                               name="nama" 
                               value="<?= old('nama', $karyawan['name']); ?>" 
                               class="form-control">
                        <div class="text-danger"><?= $validation->getError('nama'); ?></div>
                    </div>

                    <!-- JABATAN -->
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input name="jabatan" 
                               value="<?= old('jabatan', $karyawan['jabatan']); ?>" 
                               class="form-control">
                        <div class="text-danger"><?= $validation->getError('jabatan'); ?></div>
                    </div>

                    <!-- NIP -->
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="number" 
                               name="nip" 
                               value="<?= old('nip', $karyawan['nip']); ?>" 
                               class="form-control">
                        <div class="text-danger"><?= $validation->getError('nip'); ?></div>
                    </div>

                    <button onclick="simpan()" id="simpan" class="btn btn-primary">
                        <i class="bx bxs-edit-alt"></i> Ubah
                    </button>

                    <a href="<?= base_url('Karyawan'); ?>" class="btn btn-secondary">
                        <i class="bx bx-undo"></i> Kembali
                    </a>

                </form>
            </div>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="col-xl-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Table Karyawan</h5>
                <small class="text-muted">Data Karyawan</small>
            </div>

            <div class="card-body">
                <table id="myTable" class="table text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>NIP</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($users as $d) : ?>
                            <?php if ($d['ditemui'] == 1) : ?>

                                <tr class="<?= ($d['id'] == $karyawan['id']) ? 'table-success' : ''; ?>">
                                    
                                    <td>
                                        <?= $i++; ?>
                                        <?php if ($d['id'] == $karyawan['id']) : ?>
                                            <strong class="text-dark"> (EDIT)</strong>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= esc($d['name']); ?></td>
                                    <td><?= esc($d['jabatan']); ?></td>
                                    <td><?= esc($d['nip']); ?></td>

                                </tr>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>