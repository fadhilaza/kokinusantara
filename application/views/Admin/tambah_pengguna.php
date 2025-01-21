<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/admin.css">
</head>
<body>

<div class="sidebar">
        <a href="<?= base_url('admin'); ?>" class="active"><span class="fw-bold fs-6">DASHBOARD ADMIN</span></a>
        <a href="<?= base_url('admin/kelola_resep'); ?>">Kelola Resep</a>
        <a href="<?= base_url('admin/kelola_pengguna'); ?>">Kelola Pengguna</a>
        <a href="<?= base_url('admin/laporan_ulasan'); ?>">Laporan Ulasan</a>
        <a href="<?= base_url('admin/logout'); ?>">Logout</a>
</div>

<div class="content">
        <h1 class="mb-4 text-center fw-bold">Tambah Pengguna</h1>
        <?php if ( validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo base_url('admin/tambah_pengguna'); ?>" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Nama/Username">
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Konfirmasi Password">
            </div>
            <button type="submit" class="btn btn-warning w-100 py-2">Simpan</button>
        </form>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
