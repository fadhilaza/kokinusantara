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
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/rating.css">
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

<!-- Konten Masakan -->
<div class="container mt-5 mb-5 bg-light shadow-lg rounded p-5">
    <!-- Bagian Resep -->
    <div class="row" style="border-bottom: 2px solid gray;">

    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>

        <div class="col-md-5 me-3">
            <div class="col me-5 text-center">
                <!-- Tombol Simpan Resep -->
                <a href="<?= base_url('dashboard/add_to_favorite/' . $resep['id_resep']); ?>" class="btn btn-register">
                    Simpan Resep <i class="bi bi-bookmark ms-2"></i>
                </a>

                <!-- Tombol Bagikan Resep -->
                <a href="#" class="btn btn-register" data-bs-toggle="modal" data-bs-target="#shareModal">
                    Bagikan Resep <i class="bi bi-share-fill ms-2"></i>
                </a>
                                    <!-- Modal Bagikan Resep -->
                    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="shareModalLabel">Bagikan Resep</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Bagikan resep ini melalui:</p>
                                    <div class="d-flex justify-content-around">
                                        <!-- Contoh Tombol Media Sosial -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= base_url('dashboard/halaman_resep/' . $resep['id_resep']); ?>" target="_blank" class="btn btn-primary">
                                            <i class="bi bi-facebook"></i> Facebook
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode('Lihat resep ini: ' . base_url('dashboard/halaman_resep/' . $resep['id_resep'])); ?>" target="_blank" class="btn btn-info">
                                            <i class="bi bi-twitter"></i> Twitter
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text=<?= urlencode('Lihat resep ini: ' . base_url('dashboard/halaman_resep/' . $resep['id_resep'])); ?>" target="_blank" class="btn btn-success">
                                            <i class="bi bi-whatsapp"></i> WhatsApp
                                        </a>
                                    </div>
                                    <hr>
                                    <!-- Link Salin -->
                                    <p>Atau salin tautan:</p>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="recipeLink" value="<?= base_url('dashboard/halaman_resep/' . $resep['id_resep']); ?>" readonly>
                                        <button class="btn btn-outline-secondary" onclick="copyLink()">Salin</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <img src="<?= base_url('assets/recipe/foto/' . $resep['foto']); ?>" class="img-fluid mb-3 mt-3 shadow"
                style="height: 300px; width: 450px; border-radius: 25px; object-fit: cover;">
            
            <?php if ($this->session->userdata('status_aktif')): ?>
            <video class="mt-3 bg-dark shadow" 
                style="position: relative; width: 100%; max-width: 450px; height: 300px; display: flex; border-radius: 25px;" controls>
                <source src="<?= base_url('assets/recipe/video/' . $resep['video']); ?>" type="video/mp4">
            </video>
            <?php else: ?>
            <a href="<?= base_url('dashboard/premium'); ?>" class="premium-link">
                <div class="video-container mt-3">
                <video src="video-url.mp4" controls></video>
                    <div class="premium-overlay">
                        <img src="<?= base_url('assets/images/premiumlogo.png'); ?>" class="premium-logo">
                        <span>Premium Features</span>
                    </div>
                </div>
            </a>
            <?php endif; ?>
        </div>

        <div class="col-md-6 ms-3">
            <h1 class="fw-bold text-center mb-3"><?= $resep['judul']; ?></h1>
            <p class="card-text">
                <small>± <?= $resep['waktu_masak']; ?> Menit</small> •
                <small><?= $resep['jumlah_porsi']; ?> Porsi</small>
            </p>
            <h5>Bahan-bahan :</h5>
            <p><?= nl2br($resep['bahan']); ?></p>
            <h5>Bumbu :</h5>
            <p><?= nl2br($resep['bumbu'] ?? ''); ?></p>
            <h5>Langkah-langkah :</h5>
            <p><?= nl2br($resep['langkah']); ?></p>
        </div>
    </div>

    <!-- ID Resep -->
    <div class="row mt-1" style="border-bottom: 2px solid gray;">
        <p class="card-text text-center mb-1">
            <small>ID RESEP : <?= $resep['id_resep']; ?></small>
        </p>
    </div>

    <!-- Bagian Ulasan -->
    <div class="row mt-3 mb-3 text-center" style="border-bottom: 2px solid gray;">
        
        <?php if (!empty($ulasan)): ?>
            <?php foreach ($ulasan as $u): ?>
                <div class="card card-rating mb-3 p-3 shadow me-3 ms-2" style="width: 23%;">
                    <p><?= str_repeat('⭐', $u['penilaian']); ?></p>
                    <p><strong><?= $u['komentar']; ?></strong></p>
                    <div class="d-flex justify-content-center me-5">
                    <!-- Gambar Profil -->
                    <img src="<?= base_url($u['foto_pengguna'] ?: 'assets/uploads/default.png') ?>" 
                         alt="Foto <?= $u['nama_pengguna']; ?>" 
                         class="rounded-circle" 
                         style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                    <!-- Nama dan Tanggal -->
                    <div>
                        <p class="mb-0"><strong><?= $u['nama_pengguna']; ?></strong></p>
                        <small><?= date('d M Y', strtotime($u['tanggal_ulasan'])); ?></small>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
          <h3>Ulasan</h3>
            <p>Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
        <?php endif; ?>
    </div>

    <!-- Form Beri Ulasan -->
    <div class="row mt-1" style="border-bottom: 2px solid gray;">
        <h3>Beri Ulasan</h3>
        <form action="<?= base_url('dashboard/tambah_ulasan/') ?>" method="post">
            <div class="col-12 mt-3 mb-3">
                <input type="hidden" name="id_resep" value="<?= $resep['id_resep']; ?>">
                <label for="rating" class="form-label">Rating :</label>
                <select name="rating" id="rating" required>
                    <option value="5">⭐ ⭐ ⭐ ⭐ ⭐</option>
                    <option value="4">⭐ ⭐ ⭐ ⭐</option>
                    <option value="3">⭐ ⭐ ⭐</option>
                    <option value="2">⭐ ⭐</option>
                    <option value="1">⭐</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="bahan">Komentar :</label>
                <textarea name="bahan" class="form-control w-25" id="bahan" rows="3" placeholder="Berikan komentar..." required></textarea>
                <button type="submit" class="btn btn-register mt-3">Kirim</button>
            </div>
        </form>
    </div>

    <!-- Informasi Pembuat Resep -->
    <div class="row mt-3 mb-3" style="border-bottom: 2px solid gray;">
        <div class="card mb-3 p-3 shadow w-25" style="border-radius: 25px;">
            <h6>Dibuat Oleh:</h6>
            <div class="d-flex align-items-center">
                <img src="<?= base_url($recipe['foto_pengguna'] ?: 'assets/uploads/default.png') ?>" 
                     alt="Foto Pengguna" 
                     style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                <p class="m-0"><strong><?= $recipe['nama_pengguna']; ?></strong></p>
            </div>
            <h6 class="mt-3">Diupload Pada:</h6>
            <p><?= $resep['tanggal_pembuatan']; ?></p>
        </div>
    </div>
</div>




<!-- Footer Section -->
<footer class="text-center">
    <img src="https://via.placeholder.com/150x50" alt="Footer Logo" class="mb-3"> <!-- Replace footer logo -->
    <p class="text-muted">© 2024 Koki Nusantara. All Rights Reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script type = 'text/javascript' src = "<?php echo base_url(); 
   ?>assets/js/tautan.js"></script>
  <!-- Scrip Rating JS -->
  <script>
    // JavaScript untuk interaksi rating bintang
    const stars = document.querySelectorAll('.rating-stars i');
    const ratingInput = document.getElementById('rating-input');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;

            // Highlight bintang yang dipilih
            stars.forEach(s => s.classList.remove('active'));
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('active');
            }
        });
    });
    </script>
</body>
</html>
