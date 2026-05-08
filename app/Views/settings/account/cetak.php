<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('assets/'); ?>" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $title; ?> | SIMaTa</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/'); ?>img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/fonts/boxicons.css" />

    <!-- animation.io -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/animate.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->

    <script src="<?= base_url('assets/'); ?>vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/js/helpers.js"></script>

    <!--databases  -->
    <script src="<?= base_url('assets/'); ?>js/config.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url("/"); ?>assets/dataTables/datatables.min.css" />
     
    <script type="text/javascript" src="<?= base_url("/"); ?>assets/dataTables/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $("#myTable").DataTable({
                "paging": false,
                "lengthChange": true,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "pageLength": -1,
                "language": {
                    "url": "<?= base_url('/'); ?>assets/id.json"
                },
                fixedHeader: true,
                scrollY: true,
                scrollX: true,
                scrollCollapse: false,
                fixedColumns: {
                    left: 1,
                    right: 0
                },
                order: [
                    [0, "asc"]
                ],
                pagingType: "first_last_numbers",
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        className: 'btn-success',
                        text: "<i class='bx bxs-file-export'></i>Export Excel"
                    },
                    {
                        extend: 'print',
                        className: 'btn-danger',
                        text: "<i class='bx bxs-file-pdf'></i>Export PDF",
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend(
                                    '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                                );

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
    <div class="">
        <table id="myTable" class="table table-bordered table-hover table-sm">
            <thead>
                <tr style="background-color: white;">
                    <th scope="col">#</th>
                    <th scope="col">Nama Tamu</th>
                    <th scope="col">Alamat Tamu</th>
                    <th scope="col">Tanggal Berkunjung</th>
                    <th scope="col">Waktu Berkunjung</th>
                    <th scope="col">Ingin Bertemu</th>
                    <th scope="col">Keperluan Keperluan</th>
                    <th scope="col">Status Tamu</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($tamu as $t) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= ucwords($t['namaTamu']); ?></td>
                        <td><?= ucwords($t['alamatTamu']); ?></td>
                        <td><?= date_format(date_create($t['tanggalBerkunjung']), "d/m/Y"); ?></td>
                        <td><?= date("h:i A", $t['tamuMasuk']); ?></td>
                        <td><?=$t['ditemui'];?></td>
                        <td><?= $t['keperluanTamu']; ?></td>
                        <td>
                            <?php

                            if ($t['statusTamu'] == 0) {
                                echo '<span class="badge bg-label-info me-1">Tamu Baru</span>';
                            }
                            if ($t['statusTamu'] == 1) {
                                echo '<span class="badge bg-label-success me-1">Diterima</span>';
                            }
                            if ($t['statusTamu'] == 2) {
                                echo '<span class="badge bg-label-primary me-1">Selesai</span>';
                            }
                            if ($t['statusTamu'] == 3) {
                                echo '<span class="badge bg-label-danger me-1">Ditolak</span>';
                            }

                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>