<?php
session_start();
require '../config/db.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Query JOIN untuk ambil detail barang secara lengkap
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
    <title>Detail Barang - <?= $item['judul_laporan']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <a href="dashboard.php" class="btn btn-secondary mb-3">&larr; Kembali ke Dashboard</a>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <img src="../assets/uploads/<?= $item['foto']; ?>" class="img-fluid rounded shadow" alt="Foto Barang">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <span class="badge <?= $item['status'] == 'lost' ? 'bg-danger' : 'bg-success'; ?> w-25 mb-3">
                    <?= strtoupper($item['status']); ?>
                </span>
                <h2 class="fw-bold"><?= $item['judul_laporan']; ?></h2>
                <h5 class="text-primary"><?= $item['nama_kategori']; ?></h5>
                <hr>
                
                <p><strong>Lokasi:</strong><br><?= $item['lokasi']; ?></p>
                <p><strong>Deskripsi:</strong><br><?= $item['deskripsi']; ?></p>
                <p><strong>Tanggal Lapor:</strong><br><?= date('d F Y', strtotime($item['tanggal'])); ?></p>
                
                <div class="bg-light p-3 rounded">
                    <p class="mb-1 text-muted">Hubungi Pelapor:</p>
                    <h5 class="mb-0 fw-bold"><?= $item['nama']; ?></h5>
        
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>