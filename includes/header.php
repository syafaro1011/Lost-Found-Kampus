<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=restricted");
    exit();
}
?>
<nav>
    <p>Halo, <?php echo $_SESSION['nama']; ?></p>
    <a href="dashboard.php">Dashboard</a> | 
    <a href="tambah_barang.php">Tambah Laporan</a> | 
    <a href="api.php?action=logout">Logout</a>
</nav>
<hr>