<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
<form action="" method="POST" enctype="multipart/form-data">
        <h3 class="fw-bold text-center mb-4">UNGGAH RESEP</h3>
              <div class="mb-3">
                  <label class="form-label" for="judul_resep">Judul Resep :</label>
                  <input type="text" name="judul_resep" class="form-control" id="judul_resep" placeholder="Masukkan judul resep" required>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="deskripsi">Deskripsi :</label>
                  <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3" placeholder="Masukkan deskripsi resep"></textarea>
              </div>

              <div class="row g-3 mb-3 align-items-center">
                  <div class="col-auto col-sm-3">
                    <label class="form-label" for="jumlah_porsi">Jumlah Porsi :</label>
                    <div class="input-group mb-3">
                      <input type="number" name="jumlah_porsi" class="form-control"  
                      min="1" max="40" placeholder="Jumlah porsi" required>
                      <span class="input-group-text" id="basic-addon2">Porsi</span>
                    </div>
                  </div>
              </div>

              <div class="row g-3 mb-3 align-items-center">
                  <div class="col-auto col-sm-3">
                    <label class="form-label" for="judul_resep">Durasi Masak :</label>
                    <div class="input-group mb-3">
                      <input type="number" name="durasi_masak" class="form-control" 
                      min="1" max="500" placeholder="Durasi masak" required>
                      <span class="input-group-text" id="basic-addon2">Menit</span>
                    </div>
                  </div>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="kategori_resep">Kategori Resep :</label>
                  <select name="kategori_resep" class="form-select w-25" id="kategori_resep" required>
                      <option selected disabled>Pilih Kategori</option>
                      <?php foreach ($kategori as $row): ?>
                      <option value="<?= $row['id_kategori']; ?>"><?= $row['nama']; ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="bahan">Bahan :</label>
                  <textarea name="bahan" class="form-control" id="bahan" rows="3" placeholder="Masukkan bahan-bahan resep" required></textarea>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="bumbu">Bumbu :</label>
                  <textarea name="bumbu" class="form-control" id="bumbu" rows="3" placeholder="Masukkan bumbu resep" required></textarea>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="langkah">Langkah :</label>
                  <textarea name="langkah" class="form-control" id="langkah" rows="3" placeholder="Masukkan langkah-langkah resep" required></textarea>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="foto_resep">Foto Resep :</label>
                  <input type="file" name="foto_resep" class="form-control form-control-sm w-50" id="foto_resep" required>
              </div>

              <div class="mb-3">
                  <label class="form-label" for="video_resep">Video Resep :</label>
                  <input type="file" name="video_resep" class="form-control form-control-sm w-50" id="video_resep">
              </div>

              <div class="text-center">
                  <button type="submit" class="btn btn-warning w-25 px-4 mt-3">Unggah Resep</button>
              </div>
          </div>
      </form>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
