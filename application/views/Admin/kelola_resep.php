<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/admin4.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="<?= base_url('admin'); ?>" class="active"><span class="fw-bold">DASHBOARD ADMIN</span></a>
        <a href="<?= base_url('admin/kelola_resep'); ?>">Kelola Resep</a>
        <a href="<?= base_url('admin/kelola_pengguna'); ?>">Kelola Pengguna</a>
        <a href="<?= base_url('admin/laporan_ulasan'); ?>">Laporan Ulasan</a>
        <a href="<?= base_url('admin/logout'); ?>">Logout</a>
    </div>

    <div class="content">
        <h1 class="fw-bold">Kelola Resep</h1>

        <div class="search-bar">
        <input class="w-25 border-rounded p-1" type="text" style="border-radius: 10px; color: black" placeholder="Cari resep...">
        <button class="btn btn-warning p-1"><a class="text-dark text-decoration-none" href="<?= base_url('admin/tambah_resep'); ?>">Tambah Resep</a></button>
        </div>

        <table class="mt-4">
            <thead>
                <tr>
                    <th>Judul Resep</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Porsi</th>
                    <th>Durasi Masak</th>
                    <th>Kategori Resep</th>
                    <th>Bahan</th>
                    <th>Bumbu</th>
                    <th>Langkah</th>
                    <th>Foto Resep</th>
                    <th>Video Resep</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resep as $resep) : ?>
                <tr>
                    <td><?php echo $resep['judul']; ?></td>
                    <td><?php echo $resep['deskripsi']; ?></td>
                    <td><?php echo $resep['jumlah_porsi']; ?></td>
                    <td><?php echo $resep['waktu_masak']; ?></td>
                    <td><?php echo $resep['id_kategori']; ?></td>
                    <td><?php echo $resep['bahan']; ?></td>
                    <td><?php echo $resep['bumbu']; ?></td>
                    <td><?php echo $resep['langkah']; ?></td>
                    <td><?php echo $resep['foto']; ?></td>
                    <td><?php echo $resep['video']; ?></td>
                    <td><span class="status active">Active</span></td>
                    <td><a href="<?php echo base_url('admin/edit_resep/' . $resep['id_resep']); ?>" class="btn btn-warning">Edit</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Content -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
