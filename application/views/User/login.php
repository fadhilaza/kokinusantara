<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css">
</head>
<body>
    <div class="register-container">
        <img src="<?php echo base_url('assets/images/logokoki.png'); ?>" alt="Logo"> <!-- Ganti dengan logo Anda -->
        <h1 class="mb-4">LOGIN</h1>
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert <?= $this->session->flashdata('alert-class'); ?>" role="alert">
                <?= $this->session->flashdata('message'); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" >
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
            </div>
            <button type="submit" class="btn btn-warning w-100 py-2">Simpan</button>
        </form>
        <p class="mt-3">Belum punya akun? <a href=<?= base_url('dashboard/register');?>>Daftar sekarang</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
