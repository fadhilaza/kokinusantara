<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/admin.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="<?= base_url('admin'); ?>" class="active"><span class="fw-bold fs-6">DASHBOARD ADMIN</span></a>
        <a href="<?= base_url('admin/kelola_resep'); ?>">Kelola Resep</a>
        <a href="<?= base_url('admin/kelola_pengguna'); ?>">Kelola Pengguna</a>
        <a href="<?= base_url('admin/laporan_ulasan'); ?>">Laporan Ulasan</a>
        <a href="<?= base_url('admin/logout'); ?>">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 class="fw-bold">Dashboard Overview</h1>
        <div class="dashboard-overview">
            <div class="overview-box">
                <h4>Total Resep</h4>
                <p><?php echo $total_resep; ?></p>
            </div>
            <div class="overview-box">
                <h4>Total Pengguna</h4>
                <p><?= $total_pengguna; ?></p>
            </div>
            <div class="overview-box">
                <h4>Total Ulasan</h4>
                <p><?= $total_ulasan; ?></p>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="activity-section">
            <h3>Aktivitas Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Aktivitas</th>
                        <th>Pengguna</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($aktivitas)): ?>
                        <?php foreach ($aktivitas as $row): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= $row['aktivitas']; ?></td>
                                <td><?= $row['nama_pengguna']; ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif ($row['status'] == 'Pending'): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php elseif ($row['status'] == 'Inactive'): ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Tidak ada aktivitas ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
