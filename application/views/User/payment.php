<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koki Nusantara Premium</title>
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-Z7WY4w9Z4xMewHO3"></script>
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

    <!-- Proses Payment -->
    <div class="container container-premium text-center">
      <div class="row bg-warning p-3 text-center rounded">
        <h2>LANGGANAN PREMIUM</h2>
        <p>Langganan bulanan diperpanjang otomatis. Batalkan langganan kapan saja pada bagian Pengaturan.</p>
      </div>
        <div class="price">Rp. 49.000 / 3 Bulan</div>
        <p>Metode Pembayaran : </p>
          <div class="row d-flex justify-content-center"> 
            <button id="pay-button" type="submit" class="btn btn-premium w-25">Bayar</button>
            <form action="<?php echo site_url('dashboard/callback')?>" id="payment-form" method="post">
              <input type="hidden" name="result_type" id="result_type">
              <input type="hidden" name="result_data" id="result_data">
            </form>
            <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('<?= $snapToken; ?>', {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil!');
                    console.log(result);
                    fetch('<?= site_url('dashboard/callback'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(result), // Kirim data JSON ke server
                }).then(response => {
                    if (response.ok) {
                        alert('Callback berhasil diproses di server!');
                    } else {
                        alert('Gagal memproses callback di server.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran...');
                    console.log(result);
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    console.log(result);
                }
            });
        });
    </script>
            <button type="button" class="btn btn-warning w-25 mt-3" style="border-radius: 25px;" onclick="history.back()">Kembali</button>
          </div>
        <div class="footer mt-3">Kamu akan diarahkan ke ShopeePay untuk menyelesaikan pembayaran.</div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
