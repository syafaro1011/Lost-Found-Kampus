<?php
include "config/db.php";

// Ambil data barang untuk dilihat publik
$stmt = $pdo->query("SELECT items.*, categories.nama_kategori FROM items 
                     JOIN categories ON items.category_id = categories.id");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Lost & Found Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Portal Lost & Found</a>
            <a href="pages/login.php" class="btn btn-outline-light">Login</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Daftar Barang Hilang & Ditemukan</h2>
        <hr>
        <div class="row">
            <?php foreach($items as $row): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="assets/uploads/<?= $row['foto']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <span class="badge bg-<?= $row['status'] == 'lost' ? 'danger' : 'success'; ?> mb-2">
                            <?= ucfirst($row['status']); ?>
                        </span>
                        <h5 class="card-title"><?= $row['judul_laporan']; ?></h5>
                        <p class="card-text text-muted small"><?= $row['lokasi']; ?></p>
                        <p><?= substr($row['deskripsi'], 0, 50); ?>...</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>