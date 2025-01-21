<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ulasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/admin.css">
</head>
<body>
    <div class="sidebar">
        <a href="<?= base_url('admin'); ?>" class="active"><span class="fw-bold fs-6">DASHBOARD ADMIN</span></a>
        <a href="<?= base_url('admin/kelola_resep'); ?>">Kelola Resep</a>
        <a href="<?= base_url('admin/kelola_pengguna'); ?>">Kelola Pengguna</a>
        <a href="<?= base_url('admin/laporan_ulasan'); ?>">Laporan Ulasan</a>
        <a href="<?= base_url('admin/logout'); ?>">Logout</a>
    </div>
    
    <div class="content">
        <h1 class="fw-bold">Laporan Ulasan</h1>

        <div class="dashboard-overview">
            <div class="overview-box">
                <h4>Total Ulasan</h4>
                <p><?= $total_ulasan; ?></p>
            </div>
            <div class="overview-box">
                <h4>Rating Rata-rata</h4>
                <p><?= number_format($rata_rata, 2); ?></p>
            </div>
            <div class="overview-box">
                <h4>Ulasan Hari Ini</h4>
                <p><?= $total_ulasan_hari_ini; ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Resep</th>
                    <th>Pengguna</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ulasan as $ulasan): ?>
                <tr>
                    <td><?= $ulasan['tanggal_ulasan']; ?></td>
                    <td><?= $ulasan['judul']; ?></td>
                    <td><?= $ulasan['nama_pengguna']; ?><br><span class="user-comment">"<?php echo $ulasan['komentar']; ?>"</span></td>
                    <td><span class="rating">
                        <?php $rating = $ulasan['penilaian']; // Nilai rating, misalnya 4
                        for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating ? '★' : '☆'; // Tampilkan bintang penuh (★) atau kosong (☆)
                    }
                    ?></span></td>
                    <td class="badge-container">
                        <span class="badge bg-success">Active</span>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/hapus_ulasan/' . $ulasan['id_ulasan']); ?>" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" class="btn btn-danger btn-sm py-1">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
