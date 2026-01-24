<?php
include "config/db.php";

// Ambil data barang untuk dilihat publik
$stmt = $pdo->query("SELECT items.*, categories.nama_kategori FROM items 
                     JOIN categories ON items.category_id = categories.id
                     ORDER BY items.id DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found Portal - Temukan Barang Hilang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/landing.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-search"></i>
                Lost & Found Portal
            </a>
            <a href="pages/login.php" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Temukan Barang Hilang</h1>
                    <p class="hero-subtitle">
                        Platform terpercaya untuk melaporkan dan menemukan barang hilang di kampus. 
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="pages/dashboard.php" class="btn btn-light btn-lg px-4">
                            <i class="bi bi-search"></i> Cari Barang
                        </a>
                        <a href="pages/login.php" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-plus-circle"></i> Laporkan
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" style="max-width: 100%; height: auto;">
                        <!-- Magnifying glass -->
                        <circle cx="200" cy="150" r="80" fill="none" stroke="white" stroke-width="8"/>
                        <circle cx="200" cy="150" r="70" fill="rgba(255,255,255,0.2)"/>
                        <line x1="260" y1="205" x2="320" y2="265" stroke="white" stroke-width="10" stroke-linecap="round"/>
                        
                        <!-- Items inside -->
                        <circle cx="180" cy="140" r="15" fill="white" opacity="0.8"/>
                        <rect x="195" y="155" width="20" height="25" rx="3" fill="white" opacity="0.8"/>
                        <circle cx="215" cy="135" r="12" fill="white" opacity="0.8"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-inbox stat-icon"></i>
                        <div class="stat-number"><?= count($items); ?></div>
                        <div class="stat-label">Total Laporan</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-check-circle stat-icon"></i>
                        <div class="stat-number"><?= count(array_filter($items, fn($i) => $i['status'] == 'found')); ?></div>
                        <div class="stat-label">Barang Ditemukan</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-exclamation-circle stat-icon"></i>
                        <div class="stat-number"><?= count(array_filter($items, fn($i) => $i['status'] == 'lost')); ?></div>
                        <div class="stat-label">Barang Hilang</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5><i class="bi bi-search"></i> Lost & Found</h5>
                    <p>Platform terpercaya untuk membantu Anda menemukan barang yang hilang di kampus.</p>
                </div>
                <div class="footer-section">
                    <h5>Kontak</h5>
                    <p><i class="bi bi-envelope"></i> info@lostandfound.com</p>
                    <p><i class="bi bi-telephone"></i> +62 XXX-XXXX-XXXX</p>
                    <p><i class="bi bi-geo-alt"></i> Universitas XXX XXXXX</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Lost & Found Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px'
        };
    </script>
</body>
</html>