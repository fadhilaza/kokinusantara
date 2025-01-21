<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord2.css">

</head>
<body>

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

  <?php if ($this->session->flashdata('message')) : ?>
    <div class="alert alert-info" role="alert">
        <?= $this->session->flashdata('message'); ?>
    </div>
  <?php endif; ?>
    <!-- Content Section -->
    <form action="" method="POST" enctype="multipart/form-data">
          <div class="container container-unggah">
              <h3 class="fw-bold text-center mb-4">UNGGAH RESEP</h3>

              <div class="mb-3">
                  <label class="form-label" for="judul_resep">Judul Resep :</label>
                  <input type="text" name="judul_resep" class="form-control" id="judul_resep" placeholder="Masukkan judul resep" required>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="deskripsi">Deskripsi :</label>
                  <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3" placeholder="Masukkan deskripsi resep"></textarea>
              </div>

              <div class="row g-3 mb-3 align-items-center">
                  <div class="col-auto col-sm-3">
                    <label class="form-label" for="jumlah_porsi">Jumlah Porsi :</label>
                    <div class="input-group mb-3">
                      <input type="number" name="jumlah_porsi" class="form-control"  
                      min="1" max="40" placeholder="Jumlah porsi" required>
                      <span class="input-group-text" id="basic-addon2">Porsi</span>
                    </div>
                  </div>
              </div>

              <div class="row g-3 mb-3 align-items-center">
                  <div class="col-auto col-sm-3">
                    <label class="form-label" for="judul_resep">Durasi Masak :</label>
                    <div class="input-group mb-3">
                      <input type="number" name="durasi_masak" class="form-control" 
                      min="1" max="500" placeholder="Durasi masak" required>
                      <span class="input-group-text" id="basic-addon2">Menit</span>
                    </div>
                  </div>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="kategori_resep">Kategori Resep :</label>
                  <select name="kategori_resep" class="form-select w-25" id="kategori_resep" required>
                      <option selected disabled>Pilih Kategori</option>
                      <?php foreach ($kategori as $row): ?>
                      <option value="<?= $row['id_kategori']; ?>"><?= $row['nama']; ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="bahan">Bahan :</label>
                  <textarea name="bahan" class="form-control" id="bahan" rows="3" placeholder="Masukkan bahan-bahan resep" required></textarea>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="bumbu">Bumbu :</label>
                  <textarea name="bumbu" class="form-control" id="bumbu" rows="3" placeholder="Masukkan bumbu resep" required></textarea>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="langkah">Langkah :</label>
                  <textarea name="langkah" class="form-control" id="langkah" rows="3" placeholder="Masukkan langkah-langkah resep" required></textarea>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="foto_resep">Foto Resep :</label>
                  <input type="file" name="foto_resep" class="form-control form-control-sm w-50" id="foto_resep" required>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="video_resep">Video Resep :</label>
                  <input type="file" name="video_resep" class="form-control form-control-sm w-50" id="video_resep">
              </div>

              <div class="text-center">
                  <button type="submit" class="btn btn-warning w-25 px-4 mt-3">Unggah Resep</button>
              </div>
          </div>
      </form>

  <!-- Footer Section -->
  <footer class="text-center">
    <img src="https://via.placeholder.com/150x50" alt="Footer Logo" class="mb-3"> <!-- Replace footer logo -->
    <p class="text-muted">© 2024 Koki Nusantara. All Rights Reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
