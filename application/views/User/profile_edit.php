<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord2.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/img_profile.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid">
      <!-- Logo Kembali -->
      <a href=<?= base_url(''); ?> class="px-3">
        <img src="<?php echo base_url('assets/images/logokoki.png'); ?>"  width="36" height="36"  alt="Logo">
      </a>

      <!-- Search Bar -->
      <form class="d-flex mx-3 flex-grow-1" action="<?= base_url(); ?>dashboard/pencarian" method="POST">
        <input class="form-control search-bar me-2 w-50" type="text" name="keyword" placeholder="Mau masak apa hari ini?" autocomplete="off">
        <input class="btn btn-warning px-4" type="submit" name="submit" value="Cari"></input>
      </form>

        <?php if ($this->session->userdata('is_logged_in')): ?>
      <!-- Dropdown Kategori -->
      <div class="d-flex align-items-center">
      <div class="btn-group me-5">
          <a href="<?= base_url(); ?>dashboard/kategori" class="btn btn-kat" >Kategori</a>
          <button type="button" class="btn btn-kat dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu text-center">
            <li><a class="dropdown-item" href="<?php echo base_url('dashboard/kategori?kategori=Resep+Sambal'); ?>">Resep Sambal</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url('dashboard/kategori?kategori=Resep+Daging'); ?>">Resep Daging</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url('dashboard/kategori?kategori=Resep+Bumbu'); ?>">Resep Bumbu</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url('dashboard/kategori?kategori=Resep+Bakar'); ?>">Resep Bakar</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url('dashboard/kategori?kategori=Resep+Sayuran'); ?>">Resep Sayuran</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url('dashboard/kategori?kategori=Resep+Seafood'); ?>">Resep Seafood</a></li>
          </ul>
        </div>
        <!-- Favorit Resep -->
        <a href="<?= base_url(); ?>dashboard/favorit" class="text-dark text-decoration-none me-5">Favorit Resep</a>
        <!-- Tombol Premium -->
        <a href="<?= base_url(); ?>dashboard/premium" class="btn btn-premium me-5 px-4">Premium</a>
        <!-- Tombol Profile -->
        <div class="dropdown profile-dropdown me-3">
        <!-- Image Profile -->
        <a class="d-flex align-items-center text-decoration-none" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= base_url($pengguna['foto_profil'] ?: 'assets/uploads/default.png') ?>" alt="UserAvatar" class="rounded-circle" style="width: 45px; height: 45px;">
        </a>
        <!-- Dropdown Menu -->
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
            <li>
              <a class="dropdown-item" href="<?= base_url(); ?>dashboard/profile">
              <img src="<?= base_url('assets/images/logoprofile.png'); ?>" alt="Upload Icon" class="ms-2 me-2" style="width: 15px; height: 15px;">
                Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?= base_url(); ?>dashboard/kelola_resep">
              <img src="<?= base_url('assets/images/logoresep.png'); ?>" alt="Upload Icon" class="ms-2 me-2" style="width: 15px; height: 15px;">
              Kelola Resep
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?= base_url(); ?>dashboard/unggah_resep">
              <img src="<?= base_url('assets/images/logounggah.png'); ?>" alt="Upload Icon" class="ms-2 me-2" style="width: 15px; height: 15px;">
              Unggah Resep
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item custom-item" href="<?= base_url('dashboard/logout');?>">
              <i class="bi bi-box-arrow-right ms-2 me-2"></i>
              Log Out
              </a>
            </li>
        </ul>
        </div>
        <?php else: ?>
         <!-- Favorit Resep -->
        <a href="<?= base_url(); ?>dashboard/favorit" class="text-dark text-decoration-none me-3">Favorit Resep</a>
        <!-- Tombol Premium -->
        <a href="<?= base_url(); ?>dashboard/premium" class="btn btn-premium me-3 px-4">Premium</a>
        <!-- Tombol Login & Register-->
        <a href="<?= base_url(); ?>dashboard/login" class="btn btn-login me-3 px-4">Log In</a>
        <a href="<?= base_url(); ?>dashboard/register" class="btn btn-register px-4">Register</a>
        <?php endif; ?>
      </div> 
    </div>
</nav>

  <!-- Content Section -->
  <div class="profile-container">
        <a href="<?= base_url(); ?>dashboard/profile">
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
            <a href="<?= site_url('dashboard/profile_hapus'); ?>" class="btn btn-danger w-100 py-2" 
            onclick="return confirm('Apakah Anda yakin ingin menghapus akun?')">Hapus Akun</a>
            <!--<button type="submit" class="btn btn-danger w-100 py-2">Hapus Akun</button>-->
        </form>
    </div>

  <!-- Footer Section -->
  <footer class="text-center">
    <img src="https://via.placeholder.com/150x50" alt="Footer Logo" class="mb-3"> <!-- Replace footer logo -->
    <p class="text-muted">© 2024 Koki Nusantara. All Rights Reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('assets/js/profile.js'); ?>"></script>
</body>
</html>
