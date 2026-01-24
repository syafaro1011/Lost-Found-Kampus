<?php
session_start();
require '../config/db.php';

// Proteksi Halaman
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=restricted");
    exit();
}

// Query JOIN untuk ambil detail barang secara lengkap
$id = isset($_GET['id']) ? $_GET['id'] : '';
$stmt = $pdo->prepare("SELECT items.*, categories.nama_kategori, users.nama
                       FROM items 
                       JOIN categories ON items.category_id = categories.id 
                       JOIN users ON items.user_id = users.id 
                       WHERE items.id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Barang tidak ditemukan!");
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - <?= $item['judul_laporan'] ?? 'Lost & Found'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/detail_barang.css">
</head>

<body>

    <div class="container">
        <!-- Back Button -->
        <a href="dashboard.php" class="back-btn">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Dashboard</span>
        </a>

        <div class="row">
            <!-- Image Section -->
            <div class="col-lg-6 mb-4">
                <div class="image-card">
                    <div class="image-wrapper" data-bs-toggle="modal" data-bs-target="#imageModal">
                        <img src="../assets/uploads/<?= $item['foto'] ?? 'placeholder.jpg'; ?>" class="item-image"
                            alt="<?= $item['judul_laporan'] ?? 'Foto Barang'; ?>" id="mainImage"
                            onerror="this.src='https://via.placeholder.com/300?text=Image+Error'">
                        <div class="zoom-overlay">
                            <i class="bi bi-zoom-in"></i> Klik untuk perbesar
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Section -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <!-- Status Badge -->
                    <span class="status-badge <?= ($item['status'] ?? 'lost') == 'lost' ? 'lost' : 'found'; ?>"
                        id="statusBadge">
                        <i
                            class="bi bi-<?= ($item['status'] ?? 'lost') == 'lost' ? 'exclamation-circle' : 'check-circle'; ?>"></i>
                        <?= strtoupper($item['status'] ?? 'LOST'); ?>
                    </span>

                    <!-- Title -->
                    <h1 class="item-title"><?= $item['judul_laporan'] ?? 'Judul Laporan'; ?></h1>

                    <!-- Category -->
                    <div class="mb-4">
                        <span class="category-tag">
                            <i class="bi bi-tag"></i>
                            <?= $item['nama_kategori'] ?? 'Kategori'; ?>
                        </span>
                    </div>

                    <hr class="detail-divider">

                    <!-- Location -->
                    <div class="info-section">
                        <div class="info-label">
                            <i class="bi bi-geo-alt-fill"></i>
                            Lokasi
                        </div>
                        <div class="info-content">
                            <?= $item['lokasi'] ?? 'Lokasi tidak tersedia'; ?>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="info-section">
                        <div class="info-label">
                            <i class="bi bi-card-text"></i>
                            Deskripsi Barang
                        </div>
                        <div class="info-content">
                            <?= $item['deskripsi'] ?? 'Deskripsi tidak tersedia'; ?>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="info-section">
                        <div class="info-label">
                            <i class="bi bi-calendar-event"></i>
                            Tanggal Lapor
                        </div>
                        <div class="info-content">
                            <?= isset($item['tanggal']) ? date('d F Y, H:i', strtotime($item['tanggal'])) : date('d F Y'); ?>
                        </div>
                    </div>

                    <!-- Reporter Info -->
                    <div class="reporter-card">
                        <div class="reporter-label">
                            <i class="bi bi-person-circle"></i>
                            Dilaporkan oleh
                        </div>
                        <h5 class="reporter-name"><?= $item['nama'] ?? 'Anonymous'; ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img src="../assets/uploads/<?= $item['foto'] ?? 'placeholder.jpg'; ?>" class="modal-image"
                        alt="Foto Barang"
                        onerror="this.src='https://via.placeholder.com/800x600/424242/fff?text=No+Image'">
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/detail_barang.js"></script>

</body>

</html>