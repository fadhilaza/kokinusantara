<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $judul; ?></title>
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bord2.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid">
      <!-- Logo Kembali -->
      <a href="#" class="navbar-brand navbar-brand-circle">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
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
            <li><a class="dropdown-item" href="#">Kategori 1</a></li>
            <li><a class="dropdown-item" href="#">Kategori 2</a></li>
            <li><a class="dropdown-item" href="#">Kategori 3</a></li>
          </ul>
        </div>

        <!-- Favorit Resep -->
        <a href="#" class="text-dark text-decoration-none me-3">Favorit Resep</a>

        <!-- Tombol Premium -->
        <button class="btn btn-premium me-3 px-4">Premium</button>

        <!-- Tombol Login -->
        <button class="btn btn-outline-dark me-3 px-4">Log In</button>

        <!-- Tombol Register -->
        <button class="btn btn-register px-4">Register</button>
      </div>
    </div>
  </nav>


  <!-- Header Section -->
  <header class="header-background text-center py-5">
    <img src="<?php echo base_url('assets/images/logokoki.png'); ?>" id="min-logo" lt="Koki Nusantara Logo"> <!-- Replace logo URL -->
    <h1 class="fw-bold"> <span class="text-warning"></span></h1>
    <p class="fs-5 mb-4">Mau masak apa hari ini?</p>
    <div class="container">
      <div class="d-flex justify-content-center">
        <div class="search-box w-50">
          <input type="text" class="form-control border-0" placeholder="Mau masak apa hari ini?">
        </div>
        <button class="btn btn-warning ms-3 px-4">Cari</button>
      </div>
    </div>
  </header>

  <!-- Welcome Section -->
  <section class="container text-center py-5">
    <h2 class="fw-bold">Selamat Datang di <span class="text-warning">Koki Nusantara</span></h2>
    <p class="mt-3 px-5">
    Nikmati kekayaan rasa dan warisan kuliner Indonesia yang autentik di Dapur Nusantara! Kami menyajikan resep-resep masakan tradisional dari berbagai daerah di seluruh Indonesia, dari Sabang hingga Merauke. Mulai dari lezatnya Rendang Padang, gurihnya Soto Betawi, hingga segarnya Sayur Asem, semua resep disusun dengan bahan-bahan yang mudah didapat dan petunjuk langkah-langkah yang sederhana.
    </p>
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
