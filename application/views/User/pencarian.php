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

  <!-- Content -->
    <main class="container mt-4 mb-4 ">
    <?php if ($keyword === null): ?>
        <!-- Tampilan jika tidak ada pencarian -->
        <h2 class="text-center">Resep Masakan</h2>
        <p class="text-center">
            Inilah tempat untuk mencari cita rasa tradisional,<br>
            Beragam masakan nusantara ada disini!
        </p>
    <?php else: ?>
        <!-- Tampilan jika ada hasil pencarian -->
        <h2 class="text-center">Hasil Pencarian <span class="text-warning">"<?php echo $keyword; ?>"</span></h2>
    <?php endif; ?>
    <form method="GET" action="<?= base_url('dashboard/kategori'); ?>" class="mb-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= isset($selected_kategori) ? $selected_kategori : 'Telusuri Kategori'; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end text-center">
                <?php foreach ($kategori as $row): ?>
                    <li>
                        <button type="submit" name="kategori" value="<?= $row['nama']; ?>" class="dropdown-item">
                            <?= $row['nama']; ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </form>


    <div class="row g-3 mt-4">
        <?php foreach ($resep as $r) : ?>
            <div class="col-md-4">
                <a href="<?= base_url('dashboard/halaman_resep/' . $r['id_resep']); ?>" class="text-decoration-none text-dark">
                    <div class="card card-kategori text-center mb-4">
                        <img src="<?= base_url('assets/recipe/foto/' . $r['foto']); ?>" class="card-img-top" style="height: 200px; border-radius: 25px 25px 0 0; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $r['judul']; ?></h5>
                            <p class="card-text">
                                <small>± <?= $r['waktu_masak']; ?> Menit</small> • 
                                <small><?= $r['jumlah_porsi']; ?> Porsi</small>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>


          <nav aria-label="..." class="d-flex justify-content-center">
              <?= $pagination; ?>
          </nav>
    </main>

<!-- Footer Section -->
<footer class="text-center">
    <img src="https://via.placeholder.com/150x50" alt="Footer Logo" class="mb-3"> <!-- Replace footer logo -->
    <p class="text-muted">© 2024 Koki Nusantara. All Rights Reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

