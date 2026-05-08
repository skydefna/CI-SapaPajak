<div class="card">

    <!-- HEADER -->
    <div class="card-header d-flex justify-content-between">
        <h5 class="fw-bold text-primary">Kelola Menu</h5>
    </div>

    <!-- BODY -->
    <div class="card-body">

        <!-- FLASH -->
        <?php if(session()->getFlashdata('message')): ?>
        <?php endif; ?>

        <!-- TABLE -->
        <table id="myTableMenu" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Group</th>
                    <th>Controller</th>                
                    <th>Icon</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($menuList)): ?>
                <?php $no=1; foreach($menuList as $m): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($m['menu']) ?></td>
                    <td><?= esc($m['group_label'] ?? '-') ?></td>
                    <td><?= esc($m['controllers']) ?></td>
                    <td><i class="<?= $m['icon'] ?: 'bx bx-menu' ?>"></i></td>

                    <td>

                        <!-- EDIT -->
                        <button class="btn btn-warning btn-sm btn-edit"
                            data-id="<?= $m['id'] ?>"
                            data-menu="<?= esc($m['menu']) ?>"
                            data-controller="<?= esc($m['controllers']) ?>"
                            data-group="<?= esc($m['group_label']) ?>"
                            data-icon="<?= esc($m['icon']) ?>"
                            data-iconactive="<?= esc($m['iconActive']) ?>"
                            data-url="<?= esc($m['url']) ?>"
                            data-urutan="<?= $m['urutan'] ?>"
                        >
                            Edit
                        </button>

                        <!-- DELETE -->
                        <button
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalHapus"
                            onclick="setConfirm(
                                'Hapus Menu',
                                'Yakin ingin menghapus menu ini?',
                                '<?= base_url('administrator/menu/delete/'.$m['id']) ?>',
                                'danger'
                            )">
                            <i class="bx bx-trash me-1"></i> Hapus
                        </button>

                    </td>
                </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<div class="modal fade" id="modalEdit">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm border-0">

      <form id="formEdit" method="post">
      <?= csrf_field(); ?>

      <!-- HEADER -->
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-primary">
          Edit Menu
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body">

        <input type="hidden" id="editId">

        <!-- INFORMASI -->
        <div class="mb-4">          
            <div class="mt-2">
                <label class="form-label">Nama Menu</label>
                <input id="editMenu" name="menu" class="form-control">
            </div>

            <div class="mt-3">
                <label class="form-label">Group Menu</label>
                <select id="editGroupLabel" name="group_label" class="form-select">
                    <option value="">-- Tanpa Group --</option>
                    <option value="MAIN">Main</option>
                    <option value="KELOLA">Kelola</option>                    
                    <option value="SETTINGS">Settings</option>
                </select>
            </div>
            <div class="mt-3">
                <label class="form-label">Urutan</label>
                <input type="number" id="editUrutan" name="urutan" class="form-control">
            </div>
            <div class="mt-2">
                <label class="form-label">Nama Controllers</label>
                <input id="editControllers" name="controllers" class="form-control">
            </div>
        </div>

        <hr>

        <!-- TAMPILAN -->
        <div class="mb-3">          
          <div class="mt-2">
            <label class="form-label">Icon</label>

            <div class="d-flex align-items-center gap-3">
              <input id="editIcon" name="icon" class="form-control">

              <div class="icon-preview">
                <i id="iconPreview" class="bx bx-home"></i>
              </div>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">Icon Active</label>
            <input id="editIconActive" name="iconActive" class="form-control">
          </div>

          <div class="mt-3">
            <label class="form-label">URL</label>
            <input id="editUrl" name="url" class="form-control">
          </div>
        </div>

      </div>

      <!-- FOOTER -->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Batal
        </button>

        <button type="submit" class="btn btn-primary px-4">
          Update
        </button>
      </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger" id="modalTitle">
                    Konfirmasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p id="modalMessage" class="mb-0">
                    Apakah anda yakin?
                </p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="formDelete" method="post">
                    <?= csrf_field(); ?>

                    <button type="submit" class="btn btn-danger px-4">
                        Ya, Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    if ($('#myTableMenu').length) {
        $('#myTableMenu').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 20],
            lengthChange: true,
            responsive: true,
            autoWidth: false,
            scrollX: true,
            language: {
                url: "<?= base_url('assets/id.json'); ?>"
            }
        });
    }

});

document.querySelectorAll('.btn-edit').forEach(btn => {

    btn.addEventListener('click', function () {

        document.getElementById('editId').value = this.dataset.id;
        document.getElementById('editMenu').value = this.dataset.menu;
        document.getElementById('editGroupLabel').value = this.dataset.group;
        document.getElementById('editControllers').value = this.dataset.controller;
        document.getElementById('editIcon').value = this.dataset.icon;
        document.getElementById('editIconActive').value = this.dataset.iconactive;
        document.getElementById('editUrutan').value = this.dataset.urutan || '';
        document.getElementById('editUrl').value = this.dataset.url || '';
        

        // preview icon
        document.getElementById('iconPreview').className = this.dataset.icon;

        // set action form
        document.getElementById('formEdit').action =
            "<?= base_url('administrator/menu/edit/') ?>/" + this.dataset.id;

        // tampilkan modal
        new bootstrap.Modal(document.getElementById('modalEdit')).show();

    });

});

function checkChanged(form) {

    let inputs = form.querySelectorAll('input');
    let changed = false;

    inputs.forEach(input => {
        if (input.value !== input.defaultValue) {
            changed = true;
        }
    });

    if (!changed) {
        console.log("Tidak ada perubahan");
        return false; 
    }

    return true;
}

const modalEdit = document.getElementById('modalEdit');

modalEdit.addEventListener('hidden.bs.modal', function () {
    document.getElementById('formEdit').reset();
});

function setConfirm(title, message, url, type) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalMessage').innerText = message;    

    let form = document.getElementById('formDelete');
    form.action = url;

    btn.className = 'btn';

    if (type === 'danger') {
        btn.classList.add('btn-danger');
    } else if (type === 'primary') {
        btn.classList.add('btn-primary');
    } else {
        btn.classList.add('btn-secondary');
    }
}

</script>