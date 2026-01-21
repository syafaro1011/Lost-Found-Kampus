<?php
require '../api.php';

// Proteksi Halaman
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=restricted");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-search"></i> Lost & Found</a>
            <div class="navbar-nav ms-auto align-items-center">
                <span class="nav-link text-white me-3">Halo, <strong><?= $_SESSION['nama']; ?></strong></span>
                <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <h4>Semua Barang Yang Ditemukan Berada Di Pos Security</h4>
            <div class="col-md-4">
                <h4 class="mb-0">Daftar Laporan</h4>
                <p class="text-muted small">Auto-delete laporan > 7 hari aktif</p>
            </div>

            <!-- Pencarian -->
            <div class="col-md-5">
                <form action="" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari barang atau lokasi..."
                        value="<?= $keyword ?>">
                    <button type="submit" class="btn btn-outline-success">Cari</button>
                </form>
            </div>

            <!-- Tombol Tambah & Cetak -->
            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i> Lapor

                </button>
                <a href="../cetak_laporan.php" target="_blank" class="btn btn-secondary"><i
                        class="bi bi-printer"></i></a>
            </div>
        </div>

        <!-- Alert -->
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php
                if ($_GET['pesan'] == "berhasil")
                    echo "Laporan berhasil ditambahkan!";
                if ($_GET['pesan'] == "berhasil_update")
                    echo "Laporan berhasil diedit!";
                if ($_GET['pesan'] == "berhasil_hapus")
                    echo "Laporan berhasil dihapus!";
                if ($_GET['pesan'] == "akses_ditolak")
                    echo "Gagal! Anda hanya bisa menghapus laporan milik sendiri.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Card Item -->
        <div class="row">
            <?php if (count($data_barang) > 0): ?>
                <?php foreach ($data_barang as $row): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="../assets/uploads/<?= $row['foto']; ?>" class="card-img-top">
                            <div class="card-body">
                                <div class="mb-2">
                                    <span
                                        class="badge bg-<?= $row['status'] == 'lost' ? 'danger' : 'success' ?>"><?= strtoupper($row['status']) ?></span>
                                    <span class="badge bg-info text-dark"><?= $row['nama_kategori'] ?></span>
                                </div>
                                <h6 class="fw-bold text-truncate"><?= $row['judul_laporan'] ?></h6>
                                <p class="small text-muted mb-1"><i class="bi bi-geo-alt"></i> <?= $row['lokasi'] ?></p>
                                <p class="small text-muted"><i class="bi bi-person"></i> Pelapor: <?= $row['pelapor'] ?></p>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3">
                                <div class="d-grid gap-2">

                                    <!-- Button Detail -->
                                    <a href="detail_barang.php?id=<?= $row['id'] ?>"
                                        class="btn btn-outline-primary btn-sm">Detail</a>

                                    <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                                        <!-- Button Edit -->
                                        <button type="button" class="btn btn-sm btn-warning mb-1" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $row['id'] ?>"
                                            data-judul="<?= $row['judul_laporan'] ?>" data-lokasi="<?= $row['lokasi'] ?>"
                                            data-deskripsi="<?= $row['deskripsi'] ?>" data-status="<?= $row['status'] ?>"
                                            data-category="<?= $row['category_id'] ?>">
                                            Edit
                                        </button>

                                        <!-- Button Hapus -->
                                        <a href="../api.php?action=delete&id=<?= $row['id'] ?>"
                                            class="btn btn-sm text-danger text-decoration-none text-center"
                                            onclick="return confirm('Hapus laporan anda?')">Hapus Milik Saya</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Barang tidak ditemukan atau belum ada laporan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Tambah Laporan Baru -->
    <?php include 'modal_tambah.php'; ?>
    <?php include 'modal_edit.php'; ?>

    <script>
        var modalEdit = document.getElementById('modalEdit')
        modalEdit.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget

            // Mengisi input di dalam modal menggunakan data dari tombol
            document.getElementById('edit-id').value = button.getAttribute('data-id')
            document.getElementById('edit-judul').value = button.getAttribute('data-judul')
            document.getElementById('edit-lokasi').value = button.getAttribute('data-lokasi')
            document.getElementById('edit-deskripsi').value = button.getAttribute('data-deskripsi')
            document.getElementById('edit-status').value = button.getAttribute('data-status')
            document.getElementById('edit-category').value = button.getAttribute('data-category')
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>