<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>ERROR</title>

    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css'); ?>">
</head>

<body>

<div class="container text-center mt-5">

    <h2 class="text-danger">Terjadi Kesalahan</h2>

    <p>
        <?= esc($message ?? 'Terjadi kesalahan pada sistem'); ?>
    </p>

    <!-- tampil detail hanya saat development -->
    <?php if (ENVIRONMENT !== 'production' && isset($exception)) : ?>
        <div class="alert alert-warning mt-4 text-start">
            <p><strong>File:</strong> <?= esc($exception->getFile()) ?></p>
            <p><strong>Line:</strong> <?= esc($exception->getLine()) ?></p>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('/'); ?>" class="btn btn-primary mt-3">
        Kembali ke Beranda
    </a>

</div>

</body>
</html>