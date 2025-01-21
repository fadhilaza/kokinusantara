<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css">
</head>
<body>
    <div class="register-container">
        <img src="<?php echo base_url('assets/images/logokoki.png'); ?>" alt="Logo"> <!-- Ganti dengan logo Anda -->
        <h1 class="mb-4">REGISTER</h1>
        <?php if ( validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Nama/Username">
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Konfirmasi Password">
            </div>
            <button type="submit" class="btn btn-warning w-100 py-2">Simpan</button>
        </form>
        <p class="mt-3">Sudah punya akun? <a href="<?= base_url('dashboard/login'); ?>">Login sekarang</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
