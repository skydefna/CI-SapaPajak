<h4 class="fw-bold mb-4"><?= esc($title); ?></h4>

<div class="row mb-4">

  <div class="col-md-4">
    <div class="card text-center p-3">
      <h5>Total Log</h5>
      <h3><?= count($log) ?></h3>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card text-center p-3">
      <h5>User Aktif</h5>
      <h3><?= count(array_unique(array_column($log, 'user_id'))) ?></h3>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card text-center p-3">
      <h5>Status</h5>
      <h3>Aktif</h3>
    </div>
  </div>

</div>

<div class="card">
  <div class="card-header">Riwayat Log</div>

  <div class="card-body">

    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Aktivitas</th>
          <th>Waktu</th>
          <th>Keterangan</th>
        </tr>
      </thead>

      <tbody>
      <?php if (!empty($log)) : ?>
        <?php foreach ($log as $l): ?>
        <tr>
          <td><?= esc($l['id']); ?></td>
          <td><?= esc($l['user_id']); ?></td>
          <td><?= esc($l['aktivitas']); ?></td>
          <td><?= esc($l['created_at']); ?></td>
          <td><?= esc($l['keterangan'] ?? '-') ?></td>
        </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="5" class="text-center py-4">
            Tidak ada data
          </td>
        </tr>
      <?php endif; ?>
      </tbody>

    </table>

  </div>
</div>