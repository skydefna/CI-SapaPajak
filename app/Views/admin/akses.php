<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="text-primary fw-bold">Tabel Role Akses</h5>

        <div class="d-flex gap-2">

            <!-- LIHAT MENU -->
            <a href="<?= base_url('administrator/menu'); ?>" class="btn btn-primary">
                <i class="fa fa-eye"></i> Lihat Menu
            </a>

            <!-- TAMBAH ROLE -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAkses">
                + Tambah Role
            </button>

        </div>
    </div>

    <div class="card-body">

        <table class="table table-hover" id="myTable">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Role</th>
            <th class="text-center">Total User</th>
            <th>Aksi</th>
        </tr>
        </thead>

        <tbody>
        <?php $no = 1; foreach ($userRole as $d): ?>
        <tr>
            <td><?= $no++ ?></td>

            <td>
                <span class="badge bg-dark"><?= esc($d['role']) ?></span>
            </td>

            <td class="text-center">
                <span class="badge bg-primary"><?= $d['total_user'] ?></span>
            </td>

            <td>
                <button class="btn btn-warning btn-sm"
                    onclick="openEdit(<?= $d['id'] ?>,'<?= esc($d['role'],'js') ?>')">
                    Edit
                </button>

                <?php if ($d['total_user'] == 0): ?>
                    <button
                        class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalHapus"
                        onclick="setConfirm(
                            'Hapus Role',
                            'Yakin ingin menghapus role ini?',
                            '<?= base_url('administrator/akses/delete/'.$d['id']) ?>',
                            'danger'
                        )">
                        Hapus
                    </button>
                <?php else: ?>
                    <button class="btn btn-secondary btn-sm" disabled>
                        Tidak bisa hapus
                    </button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
        </table>

    </div>
</div>


<!-- ================= TAMBAH ================= -->
<div class="modal fade" id="modalAkses">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="<?= base_url('administrator/akses/add') ?>" method="post">
                <?= csrf_field(); ?>

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input name="role" class="form-control mb-3" placeholder="Nama Role">

                    <label>Hak Akses</label>

                    <div class="row">
                    <?php 
                    $total = count($allMenus);
                    $half = ceil($total / 2);

                    $left = array_slice($allMenus, 0, $half);
                    $right = array_slice($allMenus, $half);
                    ?>

                    <div class="col-md-6">
                        <?php foreach ($left as $m): ?>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="menu_id[]" value="<?= $m['id'] ?>" class="form-check-input">
                                <label class="form-check-label"><?= $m['menu'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-md-6">
                        <?php foreach ($right as $m): ?>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="menu_id[]" value="<?= $m['id'] ?>" class="form-check-input">
                                <label class="form-check-label"><?= $m['menu'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="simpan" onclick="simpan()">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- ================= EDIT ================= -->
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form id="formEdit" method="post">
                <?= csrf_field(); ?>

                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="editId">

                    <input id="editRole" name="role" class="form-control mb-3">

                    <label class="fw-semibold mb-2">Hak Akses</label>

                    <div class="row">
                    <?php foreach ($allMenus as $m): ?>
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input edit-menu" name="menu_id[]" value="<?= $m['id'] ?>" type="checkbox">
                                <label class="form-check-label"><?= $m['menu'] ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- ================= HAPUS ================= -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p id="modalMessage">Apakah anda yakin?</p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <a href="#" id="modalActionBtn" class="btn btn-danger">
                    Ya, Hapus
                </a>
            </div>

        </div>
    </div>
</div>

<script>
let responsiveScrollx = screen.width < 1400;

$(document).ready(function() {
    $("#myTable").DataTable({
        lengthChange: true,
        lengthMenu: [5, 10, 20],
        pageLength: 5,
        language: {
            url: "<?= base_url('assets/id.json'); ?>"
        },
        scrollX: responsiveScrollx,
        order: [[0, "asc"]],
    });
});

function simpan() {
    document.getElementById("simpan").setAttribute("disabled", true);
}

// 🔥 EDIT + LOAD CHECKLIST
function openEdit(id, role) {
    document.getElementById('editId').value = id;
    document.getElementById('editRole').value = role;

    let form = document.getElementById('formEdit');
    form.action = "<?= base_url('administrator/akses/edit/') ?>/" + id;

    document.querySelectorAll('.edit-menu').forEach(cb => cb.checked = false);

    fetch("<?= base_url('administrator/akses/getMenu/') ?>/" + id)
        .then(res => res.json())
        .then(data => {
            data.forEach(menu_id => {
                let el = document.querySelector(`.edit-menu[value="${menu_id}"]`);
                if (el) el.checked = true;
            });
        });

    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}

// 🔥 CONFIRM MODAL
function setConfirm(title, message, url, type) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalMessage').innerText = message;

    let btn = document.getElementById('modalActionBtn');
    btn.href = url;

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