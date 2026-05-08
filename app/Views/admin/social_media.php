<div class="container-xxl">

  <div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

      <h5 class="text-primary fw-bold mb-0">
        Setting Social Media
      </h5>

      <button type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#modalSocial"
              id="btnTambah">

        + Tambah Social Media

      </button>

    </div>

    <div class="card-body">

      <?php
      function formatWA($no)
      {
        $no = preg_replace('/[^0-9]/', '', $no);

        if (substr($no, 0, 2) == '08') {
          $no = '62' . substr($no, 1);
        }

        if (substr($no, 0, 2) == '62') {

          $part1 = substr($no, 2, 3);
          $part2 = substr($no, 5, 4);
          $part3 = substr($no, 9);

          return '+62 ' . $part1 . '-' . $part2 . '-' . $part3;
        }

        return $no;
      }

      function formatTelpKantor($no)
      {
        $no = preg_replace('/[^0-9]/', '', $no);

        if (strlen($no) <= 4) {
          return $no;
        }

        return '(' . substr($no, 0, 4) . ') ' . substr($no, 4);
      }

      $iconMap = [
        'instagram' => 'bxl-instagram-alt',
        'website'   => 'bx-world',
        'facebook'  => 'bxl-facebook',
        'youtube'   => 'bxl-youtube',
        'tiktok'    => 'bxl-tiktok',
        'whatsapp'  => 'bxl-whatsapp',
        'telepon'   => 'bx-phone',
        'x'         => 'bxl-twitter'
      ];
      ?>

      <div class="table-responsive">

        <table class="table table-hover align-middle" id="myTable">

          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th class="text-center">Platform</th>
              <th>URL</th>
              <th width="160">Aksi</th>
            </tr>
          </thead>

          <tbody>

            <?php $no = 1;
            foreach ($social as $s): ?>

              <tr>

                <td><?= $no++ ?></td>

                <td>
                  <span class="badge bg-dark">
                    <?= esc($s['name']) ?>
                  </span>
                </td>

                <td class="text-center">

                  <i class="bx <?= $iconMap[$s['platform']] ?? 'bx-link' ?>"></i>

                </td>

                <td>

                  <?php

                  if ($s['platform'] == 'whatsapp') {

                    echo formatWA(
                      str_replace('https://wa.me/', '', $s['url'])
                    );

                  } elseif ($s['platform'] == 'telepon') {

                    echo formatTelpKantor(
                      str_replace('tel:', '', $s['url'])
                    );

                  } else {

                    echo esc($s['url']);
                  }

                  ?>

                </td>

                <td>

                  <button type="button"
                          class="btn btn-warning btn-sm btn-edit"

                          data-id="<?= $s['id'] ?>"
                          data-name="<?= esc($s['name']) ?>"
                          data-platform="<?= $s['platform'] ?>"
                          data-url="<?= $s['url'] ?>"

                          data-bs-toggle="modal"
                          data-bs-target="#modalSocial">

                    Edit

                  </button>

                  <button type="button"
                          class="btn btn-danger btn-sm"

                          data-bs-toggle="modal"
                          data-bs-target="#modalHapus"

                          onclick="setConfirm(
                            'Hapus Data',
                            'Yakin ingin menghapus data ini?',
                            '<?= base_url('settings/social-media/delete/' . $s['id']) ?>'
                          )">

                    Hapus

                  </button>

                </td>

              </tr>

            <?php endforeach; ?>

          </tbody>

        </table>

      </div>

    </div>

  </div>

</div>

<!-- =========================================================
     MODAL SOCIAL
========================================================= -->

<div class="modal fade" id="modalSocial">

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <form method="post"
            action="<?= base_url('settings/social-media/update') ?>">

        <?= csrf_field(); ?>

        <div class="modal-header">

          <h5 class="modal-title">

            Tambah Social Media

          </h5>

          <button type="button"
                  class="btn-close"
                  data-bs-dismiss="modal">
          </button>

        </div>

        <div class="modal-body">

          <input type="hidden" name="id" id="id">

          <!-- PREVIEW -->
          <div class="text-center mb-3">

            <i id="previewIcon"
               class="bx bx-link fs-1">
            </i>

          </div>

          <!-- NAMA -->
          <div class="mb-3">

            <label class="form-label">
              Nama
            </label>

            <input type="text"
                   name="name"
                   id="name"
                   class="form-control"
                   required>

          </div>

          <!-- PLATFORM -->
          <div class="mb-3">

            <label class="form-label">
              Platform
            </label>

            <select name="platform"
                    id="platform"
                    class="form-control"
                    required>

              <option value="">
                -- Pilih Platform --
              </option>

              <option value="website">Website</option>
              <option value="instagram">Instagram</option>
              <option value="facebook">Facebook</option>
              <option value="youtube">YouTube</option>
              <option value="tiktok">TikTok</option>
              <option value="whatsapp">WhatsApp</option>
              <option value="telepon">Telepon Kantor</option>
              <option value="x">X</option>

            </select>

          </div>

          <!-- TELEPON -->
          <div id="fieldTelp"
               class="d-none mb-3">

            <label class="form-label">
              Nomor Telepon
            </label>

            <input type="text"
                   name="telepon"
                   id="telepon"
                   class="form-control">

          </div>

          <!-- WA -->
          <div id="fieldWa"
               class="d-none mb-3">

            <label class="form-label">
              No WhatsApp
            </label>

            <input type="text"
                   name="whatsapp"
                   id="whatsapp"
                   class="form-control">

          </div>

          <!-- URL -->
          <div id="fieldUrl"
               class="mb-3">

            <label class="form-label">
              URL
            </label>

            <input type="url"
                   name="url"
                   id="url"
                   class="form-control">

          </div>

        </div>

        <div class="modal-footer">

          <button type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal">

            Batal

          </button>

          <button type="submit"
                  class="btn btn-primary">

            Simpan

          </button>

        </div>

      </form>

    </div>

  </div>

</div>

<!-- =========================================================
     MODAL HAPUS
========================================================= -->

<div class="modal fade" id="modalHapus">

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content text-center">

      <div class="modal-header">

        <h5 id="modalTitle">
          Konfirmasi
        </h5>

      </div>

      <div class="modal-body">

        <p id="modalMessage"></p>

      </div>

      <div class="modal-footer justify-content-center">

        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">

          Batal

        </button>

        <a id="modalActionBtn"
           class="btn btn-danger">

          Ya, Hapus

        </a>

      </div>

    </div>

  </div>

</div>

<script>
$(document).ready(function () {

  $("#myTable").DataTable({

    lengthMenu: [5, 10, 20],
    pageLength: 5,

    language: {
      url: "<?= base_url('assets/id.json') ?>"
    }

  });

});

// =========================================================
// ICON
// =========================================================

const iconMap = {

  instagram: 'bxl-instagram-alt',
  facebook: 'bxl-facebook',
  youtube: 'bxl-youtube',
  website: 'bx-world',
  tiktok: 'bxl-tiktok',
  whatsapp: 'bxl-whatsapp',
  x: 'bxl-twitter',
  telepon: 'bx-phone'

};

// =========================================================
// ELEMENT
// =========================================================

const platform   = document.getElementById('platform');
const preview    = document.getElementById('previewIcon');

const url        = document.getElementById('url');
const wa         = document.getElementById('whatsapp');
const telp       = document.getElementById('telepon');

const nameField  = document.getElementById('name');

const fieldWa    = document.getElementById('fieldWa');
const fieldUrl   = document.getElementById('fieldUrl');
const fieldTelp  = document.getElementById('fieldTelp');

// =========================================================
// UPDATE UI
// =========================================================

function updateUI(p)
{
  preview.className =
    'bx ' + (iconMap[p] || 'bx-link') + ' fs-1';

  fieldWa.classList.add('d-none');
  fieldTelp.classList.add('d-none');
  fieldUrl.classList.remove('d-none');

  if (p === 'whatsapp') {

    fieldWa.classList.remove('d-none');
    fieldUrl.classList.add('d-none');

  }
  else if (p === 'telepon') {

    fieldTelp.classList.remove('d-none');
    fieldUrl.classList.add('d-none');

  }
}

// =========================================================
// PLATFORM CHANGE
// =========================================================

platform.addEventListener('change', () => {

  updateUI(platform.value);

});

// =========================================================
// EDIT
// =========================================================

document.querySelectorAll('.btn-edit').forEach(btn => {

  btn.onclick = () => {

    document.querySelector('.modal-title').innerText =
      'Edit Social Media';

    document.getElementById('id').value =
      btn.dataset.id;

    nameField.value =
      btn.dataset.name;

    platform.value =
      btn.dataset.platform;

    updateUI(platform.value);

    if (platform.value === 'whatsapp') {

      wa.value =
        btn.dataset.url.replace('https://wa.me/', '');

      url.value = '';
      telp.value = '';

    }
    else if (platform.value === 'telepon') {

      telp.value =
        btn.dataset.url.replace('tel:', '');

      url.value = '';
      wa.value = '';

    }
    else {

      url.value = btn.dataset.url;

      wa.value = '';
      telp.value = '';

    }

  };

});

// =========================================================
// TAMBAH
// =========================================================

document.getElementById('btnTambah').onclick = () => {

  document.querySelector('.modal-title').innerText =
    'Tambah Social Media';

  document.getElementById('id').value = '';

  platform.value = '';
  nameField.value = '';

  url.value = '';
  wa.value = '';
  telp.value = '';

  updateUI('');

};

// =========================================================
// FORMAT TELEPON
// =========================================================

telp.addEventListener('input', () => {

  let val =
    telp.value.replace(/\D/g, '');

  if (val.length > 4 && val.length <= 7) {

    val =
      val.slice(0, 4)
      + '-'
      + val.slice(4);

  }
  else if (val.length > 7) {

    val =
      val.slice(0, 4)
      + '-'
      + val.slice(4, 7)
      + '-'
      + val.slice(7);

  }

  telp.value = val;

});

// =========================================================
// FORMAT WA
// =========================================================

wa.addEventListener('input', () => {

  let val =
    wa.value.replace(/\D/g, '');

  if (val.length > 5 && val.length <= 9) {

    val =
      val.slice(0, 5)
      + '-'
      + val.slice(5);

  }
  else if (val.length > 9) {

    val =
      val.slice(0, 5)
      + '-'
      + val.slice(5, 9)
      + '-'
      + val.slice(9);

  }

  wa.value = val;

});

// =========================================================
// SUBMIT
// =========================================================

document.querySelector('#modalSocial form').onsubmit = () => {

  // WHATSAPP
  if (platform.value === 'whatsapp') {

    let number =
      wa.value.replace(/\D/g, '');

    if (number.length < 10) {

      showToast(
        'Nomor WhatsApp tidak valid',
        'danger'
      );

      return false;
    }

    url.value =
      'https://wa.me/' + number;
  }

  // TELEPON
  if (platform.value === 'telepon') {

    let number =
      telp.value.replace(/\D/g, '');

    if (!number) {

      showToast(
        'Nomor telepon wajib diisi',
        'danger'
      );

      return false;
    }

    url.value =
      'tel:' + number;
  }

};

// =========================================================
// MODAL DELETE
// =========================================================

function setConfirm(title, msg, urlConfirm)
{
  modalTitle.innerText = title;
  modalMessage.innerText = msg;
  modalActionBtn.href = urlConfirm;
}
</script>