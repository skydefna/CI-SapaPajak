<div class="row">
    <div class="col-xl col-md-6 col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit User</h5>
                <small class="text-muted float-end">Form Edit User</small>
            </div>

            <div class="card-body">

                <form action="<?= base_url('administrator/users/edit/'.$userEdit['id']); ?>" method="post">
                    <?= csrf_field(); ?>

                    <!-- USERNAME -->
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input value="<?= old('username', $userEdit['username']); ?>" name="username" type="text" class="form-control">
                            <div class="text-danger"><?= $validation->getError('username'); ?></div>
                        </div>
                    </div>

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label">Nama User</label>
                        <input value="<?= old('name', $userEdit['name']); ?>" name="name" type="text" class="form-control">
                        <div class="text-danger"><?= $validation->getError('name'); ?></div>
                    </div>

                    <!-- JABATAN -->
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input value="<?= old('jabatan', $userEdit['jabatan']); ?>" name="jabatan" type="text" class="form-control">
                    </div>

                    <!-- NIP (BARU) -->
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input value="<?= old('nip', $userEdit['nip']); ?>" name="nip" type="text" class="form-control">
                    </div>

                    <!-- ROLE -->
                    <div class="mb-3">
                        <label class="form-label">Role Akses</label>
                        <select name="role_id" class="form-select">
                            <?php foreach ($userRole as $u) : ?>
                                <option value="<?= $u['id']; ?>"
                                    <?= ($u['id'] == old('role_id', $userEdit['role_id'])) ? 'selected' : ''; ?>>
                                    <?= esc($u['role']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="text-danger"><?= $validation->getError('role_id'); ?></div>
                    </div>

                    <!-- IS ACTIVE (BARU) -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                            <?= old('is_active', $userEdit['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label">
                            Diterima (Aktif)
                        </label>
                    </div>

                    <!-- BUTTON -->
                    <div class="d-grid d-sm-flex">
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="bx bxs-save"></i> Update
                        </button>

                        <a href="<?= base_url('/administrator/users'); ?>" class="btn btn-secondary mt-3 ms-2">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>