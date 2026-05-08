<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-primary mb-0">Setting Website</h5>

        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSetting">
                Edit Setting
            </button>

            <form action="<?= base_url('/settings/website/reset'); ?>" method="post">
                <?= csrf_field(); ?>
                <button class="btn btn-danger"
                        onclick="return confirm('Reset semua setting?')">
                    Reset
                </button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs mb-3">
            
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#logoWeb">
                <i class="bx bx-image"></i> Logo
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#infoWeb">
                <i class="bx bx-info-circle"></i> Informasi
                </button>
            </li>


        </ul>

        <div class="tab-content">

            <!-- ================= LOGO ================= -->
            <div class="tab-pane fade show active" id="logoWeb">
            
                <div class="row text-center">
            
                    <div class="col-md-4 mb-4">
                        <label class="fw-semibold">Logo Tab</label><br>
                        <img src="<?= base_url('uploads/' . ($settings['logo_tab'] ?? 'default.png')); ?>" style="height:60px;">
                    </div>
                
                    <div class="col-md-4 mb-4">
                        <label class="fw-semibold">Logo Sapa Pajak</label><br>
                        <img src="<?= base_url('uploads/' . ($settings['logo_sapapajak'] ?? 'default.png')); ?>" style="height:60px;">
                    </div>
                
                    <div class="col-md-4 mb-4">
                        <label class="fw-semibold">Logo Tabalong</label><br>
                        <img src="<?= base_url('uploads/' . ($settings['logo_tabalong'] ?? 'default.png')); ?>" style="height:80px;">
                    </div>
            
                </div>

                <div class="row text-center">
                    <div class="col-md-6 mb-4">
                        <label class="fw-semibold">Logo Login</label><br>
                        <img src="<?= base_url('uploads/' . ($settings['logo_login'] ?? 'default.png')); ?>" style="height:80px;">
                    </div>
                
                    <div class="col-md-6 mb-4">
                        <label class="fw-semibold">Background Login</label><br>
                        <img src="<?= base_url('uploads/' . ($settings['bg_login'] ?? 'default.png')); ?>" style="height:120px; width:auto;">
                    </div>
                </div>
            
            </div>

            <!-- ================= INFO WEBSITE ================= -->
            <div class="tab-pane fade" id="infoWeb">

                <div class="row">

                    <!-- KIRI: DESKRIPSI -->
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="fw-semibold">Deskripsi</label>
                            <div class="form-control" style="min-height:150px;">
                                <?= $settings['deskripsi'] ?? '-' ?>
                            </div>
                        </div>
                    </div>

                    <!-- KANAN: VIDEO -->
                    <div class="col-md-5">
                        <?php
                        $youtube = $settings['youtube'] ?? '';
                        $youtube = str_replace("watch?v=", "embed/", $youtube);
                        ?>

                        <?php if (!empty($youtube)): ?>
                        <div class="mb-3">
                            <label class="fw-semibold">Video</label>

                            <div class="ratio ratio-16x9">
                                <iframe src="<?= $youtube ?>" allowfullscreen></iframe>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSetting">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <form action="<?= base_url('/settings/website/update'); ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>

      <!-- HEADER -->
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-primary">Edit Setting Website</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body">

        <div class="row">
        <?php
        $files = [
            'logo_tab' => 'Logo Tab',
            'logo_sapapajak' => 'Logo Sapa Pajak',
            'logo_tabalong' => 'Logo Tabalong',
            'logo_login' => 'Logo Login',
            'bg_login' => 'Background Login'
        ];
        ?>

        <?php foreach ($files as $key => $label): ?>
        <div class="col-md-4 text-center mb-4">

            <label class="fw-semibold mb-2"><?= $label ?></label>

            <div class="upload-box mb-2">
                <img id="preview_<?= $key ?>"
                    src="<?= base_url('uploads/' . ($settings[$key] ?? 'default.png')); ?>"
                    class="img-fluid"
                    style="
                        max-height:<?= $key == 'bg_login' ? '120px' : '80px' ?>;
                        object-fit:cover;
                        border-radius:8px;
                    ">
            </div>

            <input type="file" name="<?= $key ?>" class="form-control mb-2"
                onchange="previewImage(event,'preview_<?= $key ?>')">

            <button type="button"
                    onclick="deleteLogo('<?= $key ?>')"
                    class="btn btn-outline-danger btn-sm w-100">
                Hapus
            </button>

        </div>
        <?php endforeach; ?>
    </div>

    <hr>

        <!-- DESKRIPSI -->
        <div class="mb-3">
            <label class="fw-semibold">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control"><?= $settings['deskripsi'] ?? '' ?></textarea>
        </div>

        <!-- YOUTUBE -->
        <div class="mb-3">
            <label class="fw-semibold">Link YouTube</label>
            <input type="text" name="youtube" class="form-control"
                   value="<?= $settings['youtube'] ?? '' ?>">
        </div>

      </div>

      <!-- FOOTER -->
      <div class="modal-footer">
        <button class="btn btn-primary px-4">Simpan</button>
      </div>

      </form>

    </div>
  </div>
</div>

<script>
function previewImage(event, target) {
        document.getElementById(target).src = URL.createObjectURL(event.target.files[0]);
}

document.querySelector('#modalSetting form').addEventListener('submit', function(e){
    if (!this.checkValidity()) {
        e.preventDefault();
    }
});

document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById('modalSetting');

    modal.addEventListener('shown.bs.modal', function () {

        // destroy dulu kalau ada
        if (CKEDITOR.instances.deskripsi) {
            CKEDITOR.instances.deskripsi.destroy(true);
        }

        // init ulang
        CKEDITOR.replace('deskripsi', {
            height: 200,
            resize_enabled: false
        });

    });

});

function deleteLogo(key) {

    Swal.fire({
        title: 'Yakin hapus?',
        text: "Logo akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#696cff',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        zIndex: 9999
    }).then((result) => {

        if (result.isConfirmed) {

            // loading popup
            Swal.fire({
                title: 'Menghapus...',
                text: 'Harap tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // buat form POST manual
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?= base_url('/settings/website/update') ?>";

            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '<?= csrf_token() ?>';
            csrf.value = '<?= csrf_hash() ?>';

            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete';
            input.value = key;

            form.appendChild(csrf);
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

</script>