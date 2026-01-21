<?php
session_start();
include "config/db.php"; 

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

switch ($action) {
    // LOGIN
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Mengatur Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];

            // Mengatur Cookies (berlaku 1 hari)
            setcookie("last_user", $username, time() + (86400 * 30), "/");

            header("Location: pages/dashboard.php");
        } else {
            header("Location: pages/login.php?pesan=gagal");
        }
        break;

    // MENAMBAH BARANG (LOST/FOUND)
    case 'insert_item':
        if (!isset($_SESSION['user_id'])) header("Location: pages/login.php");

        $user_id     = $_SESSION['user_id'];
        $category_id = $_POST['category_id'];
        $judul       = $_POST['judul'];
        $deskripsi   = $_POST['deskripsi'];
        $lokasi      = $_POST['lokasi'];
        $status      = $_POST['status'];

        // Upload Foto
        $nama_foto = $_FILES['foto']['name'];
        $tmp_foto  = $_FILES['foto']['tmp_name'];
        
        // Buat nama unik untuk foto
        $foto_baru = time() . "_" . $nama_foto;
        $path      = "assets/uploads/" . $foto_baru;

        if (move_uploaded_file($tmp_foto, $path)) {
            $stmt = $pdo->prepare("INSERT INTO items (user_id, category_id, judul_laporan, deskripsi, lokasi, foto, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $category_id, $judul, $deskripsi, $lokasi, $foto_baru, $status]);

            header("Location: pages/dashboard.php?pesan=berhasil");
        } else {
            echo "Gagal upload gambar.";
        }
        break;

    // MENGHAPUS DATA 
    case 'delete':
    $id = $_GET['id'];
    $user_id_session = $_SESSION['user_id'];

    // Cek dulu apakah barang ini benar milik user yang sedang login
    $stmt_cek = $pdo->prepare("SELECT user_id FROM items WHERE id = ?");
    $stmt_cek->execute([$id]);
    $item = $stmt_cek->fetch();

    if ($item && $item['user_id'] == $user_id_session) {
        $stmt_del = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $stmt_del->execute([$id]);
        header("Location: pages/dashboard.php?pesan=berhasil_hapus");
    } else {
        header("Location: pages/dashboard.php?pesan=akses_ditolak");
    }
    break;

    // LOGOUT
    case 'logout':
        session_destroy();
        header("Location: pages/login.php?pesan=logout");
        break;

    default:
        header("Location: pages/index.php");
        break;
}
?>