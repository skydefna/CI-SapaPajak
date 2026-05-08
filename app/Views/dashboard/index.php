<div class="<?= !in_array($user['role_id'] ?? null, [1, 2]) ? 'd-none' : ''; ?>">

    <!-- ================= KUNJUNGAN ================= -->
    <div class="row mb-4">

        <!-- HARI INI -->
        <div class="col-md-3 mb-3">
            <div class="card border-start border-primary border-4 shadow-sm">
                <div class="card-body">

                    <h6 class="text-muted">Hari Ini</h6>

                    <h3 class="fw-bold">
                        <?= esc($today ?? 0); ?>
                    </h3>

                    <small>Jumlah Kunjungan</small>

                </div>
            </div>
        </div>

        <!-- BULAN INI -->
        <div class="col-md-3 mb-3">
            <div class="card border-start border-success border-4 shadow-sm">
                <div class="card-body">

                    <h6 class="text-muted">Bulan Ini</h6>

                    <h3 class="fw-bold">
                        <?= esc($month ?? 0); ?>
                    </h3>

                    <small>Jumlah Kunjungan</small>

                </div>
            </div>
        </div>

        <!-- TAHUN INI -->
        <div class="col-md-3 mb-3">
            <div class="card border-start border-warning border-4 shadow-sm">
                <div class="card-body">

                    <h6 class="text-muted">Tahun Ini</h6>

                    <h3 class="fw-bold">
                        <?= esc($year ?? 0); ?>
                    </h3>

                    <small>Jumlah Kunjungan</small>

                </div>
            </div>
        </div>

        <!-- TOTAL -->
        <div class="col-md-3 mb-3">
            <div class="card border-start border-danger border-4 shadow-sm">
                <div class="card-body">

                    <h6 class="text-muted">Total</h6>

                    <h3 class="fw-bold">
                        <?= esc($total ?? 0); ?>
                    </h3>

                    <small>Total Kunjungan</small>

                </div>
            </div>
        </div>

    </div>


    <!-- ================= ROLE USER ================= -->
    <div class="row">

        <?php foreach ($userRoleStats as $r) : ?>

            <div class="col-md-4 mb-4">

                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">

                        <h6 class="text-muted mb-3">
                            <?= esc($r['role']); ?>
                        </h6>

                        <h2 class="fw-bold text-primary">
                            <?= esc($r['total']); ?>
                        </h2>

                        <small>Jumlah User</small>

                    </div>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>