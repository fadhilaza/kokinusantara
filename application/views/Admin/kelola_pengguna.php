<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
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
        <h1 class="fw-bold">Kelola Pengguna</h1>

        <div class="search-bar mb-3">
            <input class="w-25 border-rounded p-1" type="text" style="border-radius: 10px; color: black" placeholder="Cari pengguna...">
            <button class="btn btn-warning p-1"><a class="text-dark text-decoration-none" href="<?= base_url('admin/tambah_pengguna'); ?>">Tambah Pengguna</a></button>
        </div>  
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert <?= $this->session->flashdata('alert-class'); ?> alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('message'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <table class="mt-4">
            <thead>
                <tr>
                    <th>ID Pengguna</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Tanggal Registrasi</th>
                    <th>Status Premium</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_pengguna)): ?>
                <?php foreach ($data_pengguna as $user): ?>
                <tr>
                    <td><?php echo $user['id_pengguna']; ?></td>
                    <td><?php echo $user['nama_pengguna']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>******</td>
                    <td><?php echo $user['tanggal_registrasi']; ?></td> 
                    <td>
                        <?php if ($user['status_aktif'] == 1): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn btn-warning me-2 py-1" href="<?= base_url('admin/edit_pengguna/'.$user['id_pengguna']); ?>">Edit</a>
                        <a class="btn btn-danger py-1" href="<?= base_url('admin/hapus_pengguna/'.$user['id_pengguna']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Delete</a>
                    </td>
                </tr> 
                <?php endforeach; ?>
                <?php endif; ?>  
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
