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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <span class="text-primary">
                    <i class="bi bi-search"></i>
                    Lost & Found - Kampus</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <div class="user-info">
                        <span class="text-primary">
                            <i class="bi bi-person-circle"></i>
                            Halo, <strong><?= $_SESSION['nama'] ?? 'User'; ?></strong>
                        </span>
                        <a class="btn btn-danger btn-sm" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        
        <!-- Info Banner -->
        <div class="info-banner">
            <h6>
                <i class="bi bi-info-circle-fill"></i>
                Semua Barang Yang Ditemukan Berada Di Pos Security
            </h6>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center g-3">
                <!-- Title -->
                <div class="col-12 col-md-4">
                    <div class="page-title">
                        <h4>Daftar Laporan</h4>
                        <p class="page-subtitle mb-0">
                            <i class="bi bi-clock-history"></i>
                            Auto-delete laporan lebih dari 7 hari aktif
                        </p>
                    </div>
                </div>

                <!-- Bar Pencarian -->
                <div class="col-12 col-md-5">
                    <form action="" method="GET" class="d-flex gap-2">
                        <div class="search-wrapper flex-grow-1">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari barang atau lokasi..."
                                   value="<?= $keyword ?? ''; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-search">
                            <i class="bi bi-search"></i>
                            <span class="d-none d-sm-inline">Cari</span>
                        </button>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 col-md-3">
                    <div class="action-buttons justify-content-md-end">
                        <button type="button" class="btn btn-success btn-action" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="bi bi-plus-lg"></i>
                            <span>Lapor</span>
                        </button>
                        <a href="../cetak_laporan.php" target="_blank" class="btn btn-print btn-action" title="Cetak Laporan">
                            <i class="bi bi-printer"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert -->
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertMessage">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <?php
                        if ($_GET['pesan'] == "berhasil") echo "Laporan berhasil ditambahkan!";
                        if ($_GET['pesan'] == "berhasil_update") echo "Laporan berhasil diedit!";
                        if ($_GET['pesan'] == "berhasil_hapus") echo "Laporan berhasil dihapus!";
                        if ($_GET['pesan'] == "akses_ditolak") echo '<span class="text-danger">Gagal! Anda hanya bisa menghapus laporan milik sendiri.</span>';
                        ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Card Item -->
        <div class="row g-4">
            <?php if (count($data_barang) > 0): ?>
                <?php foreach ($data_barang as $row): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card item-card">
                            <div class="card-img-wrapper">
                                <img src="../assets/uploads/<?= $row['foto']; ?>" 
                                     class="card-img-top" 
                                     alt="<?= $row['judul_laporan'] ?>"
                                     loading="lazy">
                                <div class="card-img-overlay-badge">
                                    <span class="badge badge-custom bg-<?= $row['status'] == 'lost' ? 'danger' : 'success' ?>">
                                        <?= strtoupper($row['status']) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <span class="badge bg-info"><?= $row['nama_kategori'] ?></span>
                                </div>
                                <h6 class="card-title"><?= $row['judul_laporan'] ?></h6>
                                <p class="card-info mb-1">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span><?= $row['lokasi'] ?></span>
                                </p>
                                <p class="card-info mb-0">
                                    <i class="bi bi-person-fill"></i>
                                    <span><?= $row['pelapor'] ?></span>
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <a href="detail_barang.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-success btn-detail btn-card">
                                        <i class="bi bi-eye"></i> Lihat Lebih
                                    </a>

                                    <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                                        <button type="button" 
                                                class="btn btn-edit btn-card" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit" 
                                                data-id="<?= $row['id'] ?>"
                                                data-judul="<?= $row['judul_laporan'] ?>" 
                                                data-lokasi="<?= $row['lokasi'] ?>"
                                                data-deskripsi="<?= $row['deskripsi'] ?? '' ?>" 
                                                data-status="<?= $row['status'] ?>"
                                                data-category="<?= $row['category_id'] ?? 1 ?>">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>

                                        <button class="btn btn-delete btn-card" 
                                                onclick="confirmDelete(<?= $row['id'] ?>)">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Barang tidak ditemukan atau belum ada laporan.</p>
                        <button class="btn btn-primary btn-action mt-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="bi bi-plus-lg"></i>
                            Buat Laporan Pertama
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
            

    <!-- Modal Tambah Laporan Baru -->
    <?php include 'modal_tambah.php'; ?>
    <?php include 'modal_edit.php'; ?>

    <script>
        //Handler Edit
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

        // Confirm Delete
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus laporan ini?')) {
                // Animate card before delete
                event.target.closest('.item-card').style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    window.location.href = '../api.php?action=delete&id=' + id;
                }, 300);
            }
        }

        // Form validation
        const formEdit = document.getElementById('formEdit');
        if (formEdit) {
            formEdit.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Menyimpan...';
                submitBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    alert('Laporan berhasil diupdate!');
                    bootstrap.Modal.getInstance(modalEdit).hide();
                    submitBtn.innerHTML = 'Simpan Perubahan';
                    submitBtn.disabled = false;
                }, 1000);
            });
        }
    </script>
    <script src="../assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>