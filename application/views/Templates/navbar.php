<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Example</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-custom {
      background-color: white; /* Warna latar belakang navbar */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan bawah */
      padding: 0.5rem 1rem;
    }

    .navbar-brand-circle {
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f5f5f5;
      width: 50px;
      height: 50px;
      border-radius: 50%;
    }

    .btn-premium {
      background-color: #000;
      color: #fff;
      border-radius: 20px;
    }

    .btn-register {
      background-color: #ffc107;
      color: #000;
      border-radius: 20px;
    }

    .search-bar {
      border-radius: 20px;
    }
  </style>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
