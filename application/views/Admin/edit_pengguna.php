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
        <a href="<?= base_url(); ?>admin/kelola_pengguna">
          <span class="bi bi-arrow-left-circle fs-4 text-dark "></span>
        </a>
        <h1 class="mb-4 text-center fw-bold">EDIT PROFILE</h1>
        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert <?= $this->session->flashdata('alert-class') ?>" role="alert">
                <?= $this->session->flashdata('message') ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo site_url('dashboard/profile_edit'); ?>" method="POST" enctype="multipart/form-data">
        <img src="<?= base_url($pengguna['foto_profil'] ?: 'assets/uploads/default.png') ?>" alt="User Avatar" 
        class="rounded-circle mb-4 mx-auto d-block" id="previewImage" width="100" height="100">
            <div class="mb-3">
                <label class="form-label ms-1">Nama/Username</label>
                <input type="text" class="form-control" id="username" name="username" 
                value="<?= set_value('username', $pengguna['nama_pengguna']) ?>" placeholder="Nama/Username">
            </div>
            <div class="mb-3">
              <label class="form-label ms-1">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" 
                value="<?= set_value('email', $pengguna['email']) ?>" placeholder="E-Mail">
            </div>
            <div class="mb-3">
                <label class="form-label ms-1">Password</label>
                <input type="password" class="form-control" id="password" name="password" 
                value="" placeholder="******">
                <p class="small-text mt-1"><em>(Kosongkan jika tidak ingin mengganti password)</em></p>
            </div>
            <div class="mb-3">
                <label class="form-label ms-1">Upload Foto Profil</label>
                <input type="file" class="form-control" id="foto_profil" name="foto_profil" 
                value="" placeholder="">
                <p class="small-text mt-1"><em>(max-size 2mb | format .jpg, .jpeg, .png)</em></p>
            </div>
            <!-- Tombol Update Profile -->
            <button type="submit" class="btn btn-warning w-100 py-2">Update Profile</button>
            <div class="border-top my-3"></div>

            <!-- Tombol Hapus Akun -->
            <a href="<?= base_url('admin/hapus_pengguna/'.$pengguna['id_pengguna']); ?>" class="btn btn-danger w-100 py-2" 
            onclick="return confirm('Apakah Anda yakin ingin menghapus akun?')">Hapus Akun</a>
            <!--<button type="submit" class="btn btn-danger w-100 py-2">Hapus Akun</button>-->
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
