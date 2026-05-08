<!DOCTYPE html>
<html lang="id">

    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buku Tamu | SapaPajak</title>

    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dataTables/datatables.min.css') ?>">

    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/dataTables/datatables.min.js') ?>"></script>

    <style>
        body { font-size: 13px; }
        table { font-size: 12px; }
    </style>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: true,
            order: [[0, "asc"]],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn btn-success',
                    text: 'Export Excel'
                },
                {
                    extend: 'print',
                    className: 'btn btn-danger',
                    text: 'Print PDF',
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '10pt');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
    });
    </script>

    </head>

    <body>

        <div class="container mt-3">

            <h4 class="text-center mb-4">Laporan Buku Tamu</h4>

            <table id="myTable" class="table table-bordered table-hover">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Ditemui</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <?php 
                    $i = 1;

                    $status = [
                        0 => ['info','Tamu Baru'],
                        1 => ['success','Diterima'],
                        2 => ['primary','Selesai'],
                        3 => ['danger','Ditolak']
                    ];
                    ?>

                    <?php foreach ($tamu as $t): ?>

                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= esc(ucwords($t['namaTamu'])) ?></td>
                    <td><?= esc(ucwords($t['alamatTamu'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['tanggalBerkunjung'])) ?></td>
                    <td><?= date('H:i', $t['tamuMasuk']) ?></td>
                    <td><?= esc($t['ditemui']) ?></td>
                    <td><?= esc($t['keperluanTamu']) ?></td>
                    <td>
                        <span class="badge bg-label-<?= $status[$t['statusTamu']][0] ?>">
                        <?= $status[$t['statusTamu']][1] ?>
                        </span>
                    </td>
                </tr>

                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>