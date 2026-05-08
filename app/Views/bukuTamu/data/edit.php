<div class="row">

  <div class="col-md-4">

    <div class="card">
      <img src="<?= $tamu['gambar']=='tidak ada' 
          ? base_url('img/index.jpg') 
          : base_url('img/'.$tamu['gambar']) ?>" class="img-fluid">
    </div>

    <div class="card mt-3 p-3">

      <form method="post" action="<?= site_url('bukutamu/delete/'.$tamu['id']) ?>">

        <div class="alert alert-warning">Yakin hapus data?</div>

        <input type="checkbox" id="cek" onchange="toggleBtn()"> Konfirmasi

        <button id="btnHapus" disabled class="btn btn-danger w-100 mt-2">Hapus</button>

      </form>

    </div>
  </div>


  <div class="col-md-8">

    <div class="card p-3">

      <form method="post" action="<?= site_url('bukutamu/edit/'.$tamu['id']) ?>">

        <?= csrf_field() ?>

        <input class="form-control mb-2" name="namaTamu" value="<?= esc($tamu['namaTamu']) ?>">

        <input class="form-control mb-2" name="alamatTamu" value="<?= esc($tamu['alamatTamu']) ?>">

        <select name="ditemui" class="form-control mb-2">
          <option value="">- pilih -</option>

        <?php foreach ($users as $u): ?>
          <?php if ($u['ditemui']==1): ?>
            <option value="<?= $u['id'] ?>"
              <?= $u['id']==$tamu['ditemui']?'selected':'' ?>>
              <?= esc($u['jabatan']) ?>
            </option>
          <?php endif; ?>
        <?php endforeach; ?>

        </select>

        <input type="date" name="tanggalBerkunjung" value="<?= $tamu['tanggalBerkunjung'] ?>" class="form-control mb-2">

        <textarea name="keperluanTamu" class="form-control mb-2"><?= esc($tamu['keperluanTamu']) ?></textarea>

        <button class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('bukutamu/data') ?>" class="btn btn-secondary">Kembali</a>

      </form>

    </div>
  </div>

</div>

<script>
function toggleBtn(){
    document.getElementById('btnHapus').disabled = !document.getElementById('cek').checked;
}
</script>