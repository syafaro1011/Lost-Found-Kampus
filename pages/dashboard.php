<?php
session_start();
require '../config/db.php';

// Proteksi Halaman: Jika belum login, tendang balik ke login
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=restricted");
    exit();
}

// LOGIKA AUTO-DELETE 1 MINGGU
$sql_auto_delete = "DELETE FROM items WHERE tanggal < DATE_SUB(NOW(), INTERVAL 7 DAY)";
$pdo->exec($sql_auto_delete);

// Ambil data dengan JOIN 3 Tabel (Items, Categories, Users)
$query = "SELECT items.*, categories.nama_kategori, users.nama AS pelapor 
          FROM items 
          JOIN categories ON items.category_id = categories.id 
          JOIN users ON items.user_id = users.id 
          ORDER BY items.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$data_barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lost & Found</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-search"></i> Lost & Found</a>
            <div class="navbar-nav ms-auto align-items-center">
                <span class="nav-link text-white me-3">Halo, <strong><?= $_SESSION['nama']; ?></strong></span>
                <a class="btn btn-danger btn-sm" href="../api.php?action=logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Daftar Laporan Barang</h4>
                <p class="text-muted">Kelola barang hilang dan temuan kampus</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle"></i> Tambah Laporan
                </button>
                <a href="../cetak_laporan.php" target="_blank" class="btn btn-secondary shadow-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                </a>
            </div>
        </div>

        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill"></i> Data berhasil diproses!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if (count($data_barang) > 0): ?>
                <?php foreach ($data_barang as $row): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="../assets/uploads/<?= $row['foto']; ?>" class="card-img-top"
                                alt="<?= $row['judul_laporan']; ?>">

                            <div class="card-body">
                                <div class="mb-2">
                                    <?php if ($row['status'] == 'lost'): ?>
                                        <span class="badge bg-danger">Hilang</span>
                                    <?php elseif ($row['status'] == 'found'): ?>
                                        <span class="badge bg-warning text-dark">Ditemukan</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php endif; ?>
                                    <span class="badge bg-info text-dark"><?= $row['nama_kategori']; ?></span>
                                </div>

                                <h6 class="card-title fw-bold text-truncate"><?= $row['judul_laporan']; ?></h6>
                                <p class="card-text small text-muted mb-2">
                                    <i class="bi bi-geo-alt text-danger"></i> <?= $row['lokasi']; ?>
                                </p>
                                <p class="card-text small text-muted">
                                    <i class="bi bi-person text-primary"></i> <?= $row['pelapor']; ?>
                                </p>
                            </div>

                            <div class="card-footer bg-white border-0 pb-3">
                                <div class="d-grid gap-2">
                                    <a href="detail_barang.php?id=<?= $row['id']; ?>"
                                        class="btn btn-outline-primary btn-sm">Lihat Detail</a>

                                    <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                                        <a href="../api.php?action=delete&id=<?= $row['id']; ?>"
                                            class="btn btn-sm text-danger small text-decoration-none text-center"
                                            onclick="return confirm('Yakin ingin menghapus laporan ini?')">Hapus Saya</a>
                                    <?php else: ?>
                                        <span class="text-muted small text-center">Bukan Milik Anda</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-box-seam display-1 text-muted"></i>
                    <p class="mt-3">Belum ada laporan barang.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <!-- Modal Tambah Laporan Baru -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-pencil-square"></i> Buat Laporan Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="../api.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="action" value="insert_item">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Laporan</label>
                            <input type="text" name="judul" class="form-control"
                                placeholder="Contoh: Ditemukan Kunci Motor" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $stmt_cat = $pdo->query("SELECT * FROM categories");
                                    $categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($categories as $cat):
                                        ?>
                                        <option value="<?= $cat['id']; ?>"><?= $cat['nama_kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="lost">Saya Kehilangan (Lost)</option>
                                    <option value="found">Saya Menemukan (Found)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Kantin Teknik"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Barang</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                placeholder="Jelaskan ciri-ciri barang..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Barang</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>