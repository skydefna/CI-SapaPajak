<script>
let responsiveScrollx = screen.width < 800;

$(document).ready(function() {
    $("#myTable").DataTable({
        lengthChange: true,
        pageLength: 5,
        language: {
            url: "<?= base_url('assets/id.json'); ?>"
        },
        scrollX: responsiveScrollx,
        order: [[0, "desc"]],
        pagingType: "numbers"
    });
});
</script>

<div class="row">
    <div class="col">
        <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Table Data Berkunjung</h5>

            <a target="_blank" href="<?= site_url('bukutamu/cetak') ?>" class="btn btn-primary">
                <i class='bx bxs-printer'></i> Cetak
            </a>
        </div>

            <div class="card-body">

                <table id="myTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Tamu</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Ditemui</th>
                        <th>Keperluan</th>
                    </tr>
                </thead>

                    <tbody>
                        <?php foreach ($tamu as $t): ?>
                        <tr data-bs-toggle="modal" data-bs-target="#modal<?= $t['id'] ?>">

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-2">
                                    <img src="<?= $t['gambar']=='tidak ada' 
                                        ? base_url('assets/img/users/default.jpg') 
                                        : base_url('img/'.$t['gambar']) ?>"
                                        class="rounded-circle">
                                </div>

                                <div>
                                    <b><?= esc($t['namaTamu']) ?></b><br>
                                    <small><?= esc($t['alamatTamu']) ?></small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <?php
                            $status = [
                                0 => ['info','Baru'],
                                1 => ['success','Diterima'],
                                2 => ['primary','Selesai'],
                                3 => ['danger','Ditolak']
                            ];
                            ?>
                            <span class="badge bg-label-<?= $status[$t['statusTamu']][0] ?>">
                                <?= $status[$t['statusTamu']][1] ?>
                            </span>
                        </td>

                        <td>
                            <?= date('H:i', $t['tamuMasuk']) ?><br>
                            <small><?= date('d M Y', strtotime($t['tanggalBerkunjung'])) ?></small>
                        </td>

                        <td><?= esc($t['ditemui']) ?></td>
                        <td><?= esc($t['keperluanTamu']) ?></td>

                        </tr>
                            <!-- MODAL -->
                            <div class="modal fade" id="modal<?= $t['id'] ?>">
                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content">

                                        <img src="<?= $t['gambar']=='tidak ada' 
                                            ? base_url('img/index.jpg') 
                                            : base_url('img/'.$t['gambar']) ?>" class="img-fluid">

                                        <div class="p-3">

                                            <h5><?= esc($t['namaTamu']) ?></h5>
                                            <p><?= esc($t['alamatTamu']) ?></p>

                                            <p>
                                            Bertemu: <b><?= esc($t['ditemui']) ?></b><br>
                                            Keperluan: <?= esc($t['keperluanTamu']) ?>
                                            </p>

                                            <a href="<?= site_url('bukutamu/edit/'.$t['id']) ?>" class="btn btn-success btn-sm">
                                                Edit
                                            </a>

                                    </div>

                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>