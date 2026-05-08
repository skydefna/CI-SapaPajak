<div class="<?= (($user['role_id'] ?? null) != 1 ? 'd-none' : ''); ?>">

  <!-- USERS -->
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h5 class="text-primary fw-bold">Tabel Users</h5>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUser">
        <i class="bx bx-user-plus me-2"></i>Tambah
      </button>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table id="myTable" class="table table-hover">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Role</th>
              <th>NIP</th>
              <th>Status Blokir</th>
              <th>Status Akun</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($usersMAs as $t) : ?>
            <?php if ($t['username'] !== $user['username']) : ?>
            <tr>
              <td><?= esc($t['name']); ?></td>
              <td><?= esc($t['role']); ?></td>
              <td><?= esc($t['nip'] ?? '-'); ?></td>
              <td class="text-center">
                <?php if ($t['blocked_until'] > time()): ?>
                    <span class="badge bg-danger">
                        Diblokir (<?= ceil(($t['blocked_until'] - time()) / 60); ?> menit)
                    </span>
                <?php else: ?>
                    <span class="badge bg-success">Diizinkan</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <span class="badge <?= $t['is_active'] ? 'bg-success' : 'bg-danger'; ?>">
                  <?= $t['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                </span>
              </td>
              <td class="text-center">
                <div class="dropdown">

                  <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>

                  <ul class="dropdown-menu">

                    <!-- EDIT -->
                    <li>
                      <a class="dropdown-item" href="<?= base_url('/administrator/users/edit/'.$t['id']); ?>">
                        <i class="bx bx-edit me-2 text-warning"></i> Edit
                      </a>
                    </li>

                    <!-- UNBLOCK -->
                    <li>
                      <a href="#"
                        class="dropdown-item"
                        data-bs-toggle="modal"
                        data-bs-target="#modalUnblock"
                        onclick="setUnblockUrl('<?= base_url('/administrator/users/unblock/'.$t['id']); ?>')">

                        <i class="bx bx-lock-open me-2"></i> Buka Blokir
                      </a>
                    </li>

                    <!-- RESET PASSWORD -->
                    <li>
                      <a href="#"
                        class="dropdown-item"
                        data-bs-toggle="modal"
                        data-bs-target="#modalConfirm"
                        onclick="setConfirm(
                          'Reset Password',
                          'Yakin ingin mereset password user ini?',
                          '<?= base_url('/administrator/users/reset/'.$t['id']); ?>',
                          'primary'
                        )">

                        <i class="bx bx-refresh me-2 text-info"></i> Reset Password
                      </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <!-- HAPUS USER (FIXED) -->
                    <li>
                      <a href="#"
                        class="dropdown-item text-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#modalConfirm"
                        onclick="setConfirm(
                            'Hapus User',
                            'Yakin ingin menghapus user ini?',
                            '<?= base_url('/administrator/users/delete/'.$t['id']); ?>',
                            'danger'
                        )">

                        <i class="bx bx-trash me-2"></i> Hapus
                      </a>
                    </li>

                  </ul>

                </div>
              </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- MODAL UNBLOCK -->
  <div class="modal fade" id="modalUnblock" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow border-0" style="border-radius:12px;">

        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">
          <p>Apakah Anda yakin buka blokir akun ini?</p>
        </div>

        <div class="modal-footer justify-content-center border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Batal
          </button>

          <a href="#" id="btnUnblock" class="btn btn-primary px-4">
            Ya, Lanjut
          </a>
        </div>

      </div>
    </div>
  </div>

  <!-- / MODAL HAPUS USER -->
  <div class="modal fade" id="modalConfirm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow border-0" style="border-radius:12px;">

        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold text-danger" id="modalTitle">
            Konfirmasi
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">
          <p id="modalMessage">Apakah anda yakin?</p>
        </div>

        <div class="modal-footer justify-content-center border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Batal
          </button>

          <a href="#" id="modalActionBtn" class="btn btn-danger px-4">
            Ya, Hapus
          </a>
        </div>

      </div>
    </div>
  </div>

  <!-- MODAL TAMBAH USER -->
  <div class="modal fade" id="tambahUser" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">
            <i class="bx bx-user-plus me-2"></i> Tambah User
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>        

        <form action="<?= base_url('/administrator/users'); ?>" method="post">
          <?= csrf_field(); ?>

          <div class="modal-body">

              <!-- USERNAME -->
              <div class="mb-3">
                  <label>Username</label>
                  <div class="input-group">
                      <input name="username" id="username" class="form-control"
                            value="<?= old('username'); ?>" required>
                      <button type="button" class="btn btn-primary" onclick="cekUsername()">Cek</button>
                  </div>
                  <div id="infoUsername" class="small mt-1"></div>
              </div>

              <div id="formLanjutan" style="display:none;">

                <!-- NAMA -->
                <div class="mb-3">
                    <label>Nama</label>
                    <input name="name" class="form-control"
                          value="<?= old('name'); ?>">
                </div>

                <!-- JABATAN -->
                <div class="mb-3">
                    <label>Jabatan</label>
                    <input name="jabatan" class="form-control"
                          value="<?= old('jabatan'); ?>">
                </div>

                <!-- NIP -->
                <div class="mb-3">
                    <label>NIP</label>
                    <input name="nip" class="form-control"
                          value="<?= old('nip'); ?>">
                </div>

                <!-- ROLE -->
                <div class="mb-3">
                    <label>Hak Akses</label>
                    <select name="role_id" class="form-select">
                        <option value="">- pilih -</option>
                        <?php foreach ($userRole as $u) : ?>
                            <option value="<?= $u['id']; ?>">
                                <?= esc($u['role']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- ACTIVE -->
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1">
                    <label class="form-check-label">Diterima</label>
                </div>

            </div>

          </div>

          <div class="modal-footer">
              <button type="submit" id="btnSimpan" class="btn btn-primary" disabled>
                  Simpan
              </button>
          </div>
      </form>

      </div>
    </div>
  </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {
    if ($('#myTable').length) {
        $('#myTable').DataTable({
            lengthChange: true,
            lengthMenu: [5, 15, 30, 45, 60],
            pageLength: 5,
            language: {
                url: "<?= base_url('assets/id.json'); ?>"
            },
            scrollX: true,
            responsive: true,
            autoWidth: false
        });
    }
});

// JS MODAL UNBLOCK
function setUnblockUrl(url) {
    document.getElementById('btnUnblock').href = url;
}

// JS MODAL HAPUS USER
function setConfirm(title, message, url, type) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalMessage').innerText = message;

    let btn = document.getElementById('modalActionBtn');
    btn.href = url;

    // reset class
    btn.className = 'btn';

    // set warna tombol
    if (type === 'danger') {
        btn.classList.add('btn-danger');
    } else if (type === 'primary') {
        btn.classList.add('btn-primary');
    } else {
        btn.classList.add('btn-secondary');
    }
}

// JS MODAL TAMBAH USER
<?php if ($validation->getErrors()) : ?>
    let modal = new bootstrap.Modal(document.getElementById('tambahUser'));
    modal.show();

    document.getElementById('formLanjutan').style.display = 'block';
    document.getElementById('btnSimpan').disabled = false;
<?php endif; ?>

// JS CEK USERNAME
function cekUsername() {

    let username = document.getElementById('username').value;
    let info = document.getElementById('infoUsername');
    let form = document.getElementById('formLanjutan');
    let btn = document.getElementById('btnSimpan');

    if (username === '') {
        info.innerHTML = '<span class="text-danger">Username wajib diisi!</span>';
        form.style.display = 'none';
        btn.disabled = true;
        return;
    }

    let csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');

    fetch("<?= base_url('/administrator/cekUsername'); ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: `username=${username}&${csrfInput.name}=${csrfInput.value}`
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === 'exists') {
            info.innerHTML = '<span class="text-danger">❌ Username sudah digunakan</span>';
            form.style.display = 'none';
            btn.disabled = true;
        } else {
            info.innerHTML = '<span class="text-success">✅ Username tersedia</span>';
            form.style.display = 'block';
            btn.disabled = false;

            document.querySelector('input[name="name"]').focus();
        }

    });
}
</script>