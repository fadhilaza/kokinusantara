<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord2.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid">
      <!-- Logo Kembali -->
      <a href=<?= base_url('beranda'); ?> class="px-3">
        <img src="<?php echo base_url('assets/images/logokoki.png'); ?>"  width="36" height="36"  alt="Logo">
      </a>

      <!-- Search Bar -->
      <form class="d-flex mx-3 flex-grow-1">
        <input class="form-control search-bar me-2" type="search" placeholder="Mau masak apa hari ini?" aria-label="Search">
        <button class="btn btn-warning px-4" type="submit">Cari</button>
      </form>

      <!-- Links -->
      <div class="d-flex align-items-center">
        <!-- Dropdown Kategori -->
        <div class="dropdown me-3">
          <button class="btn btn-link dropdown-toggle text-dark" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">Resep Sambal</a></li>
            <li><a class="dropdown-item" href="#">Resep Daging</a></li>
            <li><a class="dropdown-item" href="#">Resep Bumbu</a></li>
            <li><a class="dropdown-item" href="#">Resep Bakar</a></li>
            <li><a class="dropdown-item" href="#">Resep Sayuran</a></li>
            <li><a class="dropdown-item" href="#">Resep Seafood</a></li>
          </ul>
        </div>

        <!-- Favorit Resep -->
        <a href="#" class="text-dark text-decoration-none me-3">Favorit Resep</a>

        <!-- Tombol Premium -->
        <button class="btn btn-premium me-3 px-4">Premium</button>

        <div class="dropdown profile-dropdown">
        <!-- Avatar Profile -->
        <a class="d-flex align-items-center text-decoration-none" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="assets/images/logouser.png" alt="UserAvatar" class="rounded-circle" style="width: 50px; height: 50px;">
        </a>

        <!-- Dropdown Menu -->
        <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">My Profile</a></li>
            <li><a class="dropdown-item" href="#">Enrolled Class</a></li>
            <li><a class="dropdown-item" href="#">Certificate</a></li>
            <li><a class="dropdown-item" href="#">Help & Support</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="<?= base_url('dashboard/logout');?>">Log Out</a></li>
        </ul>
        </div>

      </div> 
    </div>
  </nav>

  <?php if ($this->session->flashdata('message')) : ?>
    <div class="alert alert-info" role="alert">
        <?= $this->session->flashdata('message'); ?>
    </div>
  <?php endif; ?>



  <!-- Header Section -->
  <header class="header-background text-center py-5">
    <img src="<?php echo base_url('assets/images/logokoki.png'); ?>" id="min-logo" lt="Koki Nusantara Logo"> <!-- Replace logo URL -->
    <h1 class="fw-bold"> <span class="text-warning"></span></h1>
    <p class="fs-5 mb-4 text-dark">Mau masak apa hari ini? </p>
    <div class="container">
      <div class="d-flex justify-content-center">
        <div class="search-box w-50">
          <input type="text" class="form-control border-0" placeholder="Mau masak apa hari ini?">
        </div>
        <button class="btn btn-warning ms-3 px-4">Cari</button>
      </div>
    </div>
  </header>

  <section class="container py-5">
  <h3 class="fw-bold text-center mb-4">Kategori Resep</h3>
  <div class="row row-cols-1 row-cols-md-3 g-3 text-center">
    <!-- Kategori 1 -->
    <div class="col">
      <form action="/search" method="get">
        <input type="hidden" name="category" value="Resep Daging">
        <button type="submit" class="btn btn-outline-warning w-100 py-3">Resep Daging</button>
      </form>
    </div>
    <!-- Kategori 2 -->
    <div class="col">
      <form action="/search" method="get">
        <input type="hidden" name="category" value="Resep Sambal">
        <button type="submit" class="btn btn-outline-warning w-100 py-3">Resep Sambal</button>
      </form>
    </div>
    <!-- Kategori 3 -->
    <div class="col">
      <form action="/search" method="get">
        <input type="hidden" name="category" value="Resep Bumbu">
        <button type="submit" class="btn btn-outline-warning w-100 py-3">Resep Bumbu</button>
      </form>
    </div>
    <!-- Kategori 4 -->
    <div class="col">
      <form action="/search" method="get">
        <input type="hidden" name="category" value="Resep Seafood">
        <button type="submit" class="btn btn-outline-warning w-100 py-3">Resep Seafood</button>
      </form>
    </div>
    <!-- Kategori 5 -->
    <div class="col">
      <form action="/search" method="get">
        <input type="hidden" name="category" value="Resep Bakar">
        <button type="submit" class="btn btn-outline-warning w-100 py-3">Resep Bakar</button>
      </form>
    </div>
    <!-- Kategori 6 -->
    <div class="col">
      <form action="/search" method="get">
        <input type="hidden" name="category" value="Resep Sayuran">
        <button type="submit" class="btn btn-outline-warning w-100 py-3">Resep Sayuran</button>
      </form>
    </div>
  </div>
  <div class="text-center my-4">
    <form action="/kategori/lebih-banyak" method="get">
      <button type="submit" class="btn btn-warning ms-3 px-4">Lebih Banyak</button>
    </form>
  </div>
</section>





  <!-- Popular Recipes Section -->
  <section class="container py-5">
    <h3 class="fw-bold text-center mb-4">Resep Populer</h3>
    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card popular-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Gudeg Spesial">
          <div class="card-body text-center">
            <h5 class="card-title">GUDEG SPESIAL</h5>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card popular-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Bakmi Jawa Mantap">
          <div class="card-body text-center">
            <h5 class="card-title">BAKMI JAWA MANTAP</h5>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card popular-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Rawon Pedas">
          <div class="card-body text-center">
            <h5 class="card-title">RAWON PEDAS</h5>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center my-3">
      <button class="btn btn-warning ms-3 px-4">Lebih Banyak</button>
    </div>
  </section>

  <!-- Footer Section -->
  <footer class="text-center">
    <img src="https://via.placeholder.com/150x50" alt="Footer Logo" class="mb-3"> <!-- Replace footer logo -->
    <p class="text-muted">© 2024 Koki Nusantara. All Rights Reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



<p> HALO </p>

<h1>Selamat datang, <?= $nama_pengguna; ?>!</h1>
<p>Email: <?= $email; ?></p>
</p>

<a href="<?= site_url('dashboard/logout'); ?>" class="btn btn-danger">Logout</a>
