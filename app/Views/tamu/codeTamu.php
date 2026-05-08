<?php
setlocale(LC_ALL, 'id_ID');

// amanin data
$tanggalIndonesiaDua = isset($codeTamu['tanggalBerkunjung'])
    ? strftime("%d %B %Y", strtotime($codeTamu['tanggalBerkunjung']))
    : '-';

$bg = '';
$status = '';

if (isset($codeTamu['statusTamu'])) {
    if ($codeTamu['statusTamu'] == 0) {
        $bg = 'info';
        $status = 'MENUNGGU';
    } elseif ($codeTamu['statusTamu'] == 1) {
        $bg = 'success';
        $status = 'DITERIMA';
    } elseif ($codeTamu['statusTamu'] == 3) {
        $bg = 'danger';
        $status = 'DITOLAK';
    }
}
?>

<div class="row mb-5">

    <!-- STATUS -->
    <div class="col text-center">
        <div class="card bg-label-<?= esc($bg); ?> text-black mb-3">
            <div class="card-header pb-1">Status</div>

            <div class="card-body">
                <i style="font-size:150px;"
                   class='text-<?= esc($bg); ?> bx 
                   <?= $bg == 'danger' ? 'bxs-x-circle' : ($bg == 'info' ? 'bxs-hourglass' : 'bxs-check-circle'); ?>'>
                </i>

                <h5 class="mt-2"><strong><?= esc($status); ?></strong></h5>

                <p>
                    <?php if ($bg == 'info'): ?>
                        Mohon tunggu, akan dikonfirmasi sebelum tanggal <strong><?= $tanggalIndonesiaDua; ?></strong>
                    <?php elseif ($bg == 'danger'): ?>
                        Mohon maaf, pengajuan Anda ditolak.
                    <?php elseif ($bg == 'success'): ?>
                        Silakan datang ke kantor dengan membawa <strong>Kode Tamu</strong>.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- DATA TAMU -->
    <div class="col-lg">
        <div class="card mb-2">
            <h5 class="card-header">Data Tamu</h5>

            <table class="table table-borderless mb-3">
                <tbody>

                    <tr>
                        <td>Kode Tamu</td>
                        <td><?= esc($codeTamu['codeTamu'] ?? '-'); ?></td>
                    </tr>

                    <tr>
                        <td>Nama</td>
                        <td><?= esc(ucwords($codeTamu['namaTamu'] ?? '-')); ?></td>
                    </tr>

                    <tr>
                        <td>Alamat</td>
                        <td><?= esc(ucwords($codeTamu['alamatTamu'] ?? '-')); ?></td>
                    </tr>

                    <tr>
                        <td>Ingin Bertemu</td>
                        <td>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $u): ?>
                                    <?php if (($u['id'] ?? null) == ($codeTamu['ditemui'] ?? null)): ?>
                                        <?= esc($u['jabatan']); ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Tanggal</td>
                        <td><?= $tanggalIndonesiaDua; ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- BUTTON -->
        <div class="d-flex justify-content-center gap-3 mt-3 mb-4">

            <a href="<?= site_url('tamu/buku_tamu'); ?>" class="btn btn-primary">
                <i class="bx bx-undo"></i> Kembali
            </a>

            <a href="<?= site_url('tamu/download/' . $codeTamu['codeTamu']); ?>" 
            class="btn btn-success">
                Download Kode Tamu
            </a>

        </div>  
    </div>

</div>

<?php if (session()->getFlashdata('autoDownload')): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // cek localStorage biar tidak double
    const key = "downloaded_<?= $codeTamu['codeTamu']; ?>";

    if (!localStorage.getItem(key)) {

        setTimeout(() => {
            window.open("<?= site_url('tamu/download/' . $codeTamu['codeTamu']); ?>", "_blank");
        }, 800);

        // tandai sudah download
        localStorage.setItem(key, "true");
    }

});
</script>
<?php endif; ?>