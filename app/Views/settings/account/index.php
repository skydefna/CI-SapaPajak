<?php
$anim = in_array($user['role_id'], [3,4])
    ? 'animate__animated animasiKaban animate__fadeInRightBig'
    : '';
?>

<!-- ALERT WAJIB GANTI PASSWORD -->
<?php if ($user['must_change_password'] == 1): ?>
<div class="alert alert-warning">
    ⚠️ Anda wajib mengganti password terlebih dahulu sebelum menggunakan sistem!
</div>
<?php endif; ?>

<div class="row <?= $anim ?>">
  <div class="col-xl-8">

    <!-- PROFILE -->
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex flex-wrap">

          <div class="me-3">
            <img class="rounded img-thumbnail"
                 style="height:140px"
                 src="<?= base_url('assets/img/users/' . $user['image']); ?>">
          </div>

          <div class="flex-grow-1">
            <h4><?= esc($user['name']); ?></h4>
            <p>@<?= esc($user['username']); ?></p>
            <small><?= esc($user['jabatan']); ?></small>

            <?php if ($user['must_change_password'] == 0): ?>
            <div class="mt-2">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                <i class='bx bx-upload'></i> Ganti Foto
              </button>
            </div>
            <?php endif; ?>
          </div>

          <div class="text-end">
            <?php foreach ($userRole as $ur): ?>
              <?php if ($ur['id'] == $user['role_id']): 
                $badge = $user['role_id'] == 1 ? 'bg-label-danger' :
                         ($user['role_id'] == 3 ? 'bg-label-primary' : 'bg-label-secondary');
              ?>
                <span class="badge <?= $badge ?>"><?= esc($ur['role']) ?></span>
              <?php endif; ?>
            <?php endforeach; ?>

            <div>
              <small>Terdaftar <?= date("d M Y", strtotime($user['date_created'])); ?></small>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- TAB -->
    <div class="card">
      <div class="card-body">

        <ul class="nav nav-tabs">

          <!-- PROFILE TAB (LOCKED) -->
          <?php if ($user['must_change_password'] == 0): ?>
          <li class="nav-item">
            <button class="nav-link <?= (!validation_show_error('current_password') ? 'active' : '') ?>"
                    data-bs-toggle="tab" data-bs-target="#profile">
              <i class='bx bx-user'></i> Profile
            </button>
          </li>
          <?php endif; ?>

          <!-- PASSWORD TAB -->
          <li class="nav-item">
            <button class="nav-link <?= ($user['must_change_password'] == 1 || validation_show_error('current_password')) ? 'active' : '' ?>"
                    data-bs-toggle="tab" data-bs-target="#password">
              <i class='bx bx-key'></i> Password
            </button>
          </li>

        </ul>

        <div class="tab-content mt-3">

          <!-- PROFILE FORM -->
          <?php if ($user['must_change_password'] == 0): ?>
          <div class="tab-pane fade <?= (!validation_show_error('current_password') ? 'show active' : '') ?>" id="profile">

            <form action="<?= base_url('settings/account/update'); ?>" method="post">
              <input type="hidden" name="id" value="<?= esc($user['id']); ?>">

              <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control"
                       value="<?= old('name', $user['name']); ?>">
                <div class="text-muted">Nama lengkap berserta gelar</div>
              </div>

              <div class="mb-3">
                <label>NIP</label>
                <input type="number" name="nip" class="form-control"
                       value="<?= old('nip', $user['nip'] ?: '-'); ?>">
              </div>

              <button class="btn btn-primary">
                <i class='bx bxs-save'></i> Simpan
              </button>

            </form>

          </div>
          <?php endif; ?>

          <!-- PASSWORD FORM -->
          <div class="tab-pane fade <?= ($user['must_change_password'] == 1 || validation_show_error('current_password')) ? 'show active' : '' ?>" id="password">

            <form action="<?= base_url('settings/changePassword'); ?>" method="post">

              <div class="mb-3">
                <label>Password Lama</label>
                <div class="input-group">
                  <input type="password" id="passLama" name="current_password" class="form-control">
                  <span class="input-group-text" onclick="togglePassword('passLama', this)">
                    <i class="bx bx-hide"></i>
                  </span>
                </div>
                <div class="text-danger"><?= validation_show_error('current_password'); ?></div>
              </div>

              <div class="mb-3">
                <label>Password Baru</label>
                <div class="input-group">
                  <input type="password" id="passBaru" name="passwd1" class="form-control">
                  <span class="input-group-text" onclick="togglePassword('passBaru', this)">
                    <i class="bx bx-hide"></i>
                  </span>
                </div>
                <div class="text-danger"><?= validation_show_error('passwd1'); ?></div>
              </div>

              <div class="mb-3">
                <label>Konfirmasi Password</label>
                <div class="input-group">
                  <input type="password" id="passConfirm" name="passwd2" class="form-control">
                  <span class="input-group-text" onclick="togglePassword('passConfirm', this)">
                    <i class="bx bx-hide"></i>
                  </span>
                </div>
                <div class="text-danger"><?= validation_show_error('passwd2'); ?></div>
              </div>

              <button class="btn btn-primary">
                <i class='bx bxs-save'></i> Simpan
              </button>

            </form>

          </div>

        </div>

      </div>
    </div>

  </div>

  <!-- RIGHT PANEL -->
  <div class="col-xl-4">

    <img class="img-fluid mb-3"
         src="<?= base_url('assets/img/illustrations/undraw_focus_sey6.svg'); ?>">

    <div class="card">
      <div class="card-body">
        <h6>Pintasan Keluar</h6>

        <!-- 🔥 LOGOUT DIHILANGKAN -->
        <?php if ($user['must_change_password'] == 0): ?>
        <button onclick="window.location.href='<?= base_url('/logout'); ?>'"
                class="btn btn-danger">
          <i class="bx bx-power-off"></i> Logout
        </button>
        <?php endif; ?>

      </div>
    </div>

  </div>
</div>

<!-- MODAL FOTO (DISABLE JIKA WAJIB PASSWORD) -->
<?php if ($user['must_change_password'] == 0): ?>
<div class="modal fade" id="modalCenter">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    
    <form action="<?= base_url('settings/gantiFotoProfile'); ?>"
          method="post" enctype="multipart/form-data">

      <div class="modal-content">
        <div class="modal-header">
          <h5><i class='bx bx-upload'></i> Ganti Foto</h5>
        </div>

        <div class="modal-body text-center">

          <img id="preview" class="img-thumbnail mb-3"
               style="height:140px"
               src="<?= base_url('assets/img/users/' . $user['image']); ?>">

          <input type="file" name="image" id="imgInp" class="form-control">

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>

    </form>
  </div>
</div>
<?php endif; ?>

<script>
document.getElementById('imgInp')?.addEventListener('change', function(evt) {
  const [file] = evt.target.files;
  if (file) {
    document.getElementById('preview').src = URL.createObjectURL(file);
  }
});

function togglePassword(id, el) {
  const input = document.getElementById(id);
  const icon = el.querySelector("i");

  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("bx-hide");
    icon.classList.add("bx-show");
  } else {
    input.type = "password";
    icon.classList.remove("bx-show");
    icon.classList.add("bx-hide");
  }
}
</script>