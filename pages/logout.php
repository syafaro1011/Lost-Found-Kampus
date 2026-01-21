<?php
session_start();

// Cek apakah session terdaftar
if(isset($_SESSION['username'])) {
    // Session terdaftar, saatnya logout
    session_unset(); // Hapus semua variabel session
    session_destroy(); // Hapus session data
    echo 'Logout berhasil. Klik <a href="http://localhost/UAS/pages/login.php">di sini</a> untuk login kembali.';
    echo '<br>Anda akan dialihkan ke halaman login dalam 3 detik.';
    echo '<script type="text/javascript">setTimeout(function() { window.location.href = "http://localhost/UAS/pages/login.php"; }, 3000);</script>';
}
?>