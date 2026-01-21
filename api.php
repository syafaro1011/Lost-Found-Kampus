<?php
session_start();
include "config/db.php";

// AUTO DELETE
$pdo->exec("DELETE FROM items WHERE tanggal < DATE_SUB(NOW(), INTERVAL 7 DAY)");

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : 'view'); 

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

    case 'view':
        // Filter Cari
        $keyword = isset($_GET['search']) ? $_GET['search'] : "";
        
        $sql = "SELECT items.*, categories.nama_kategori, users.nama AS pelapor 
                FROM items 
                JOIN categories ON items.category_id = categories.id 
                JOIN users ON items.user_id = users.id";

        if ($keyword != "") {
            $sql .= " WHERE items.judul_laporan LIKE ? OR items.lokasi LIKE ?";
            $sql .= " ORDER BY items.id DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(["%$keyword%", "%$keyword%"]);
        } else {
            $sql .= " ORDER BY items.id DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }
        $data_barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

    // MENAMBAH BARANG (LOST/FOUND)
    case 'insert_item':
        if (!isset($_SESSION['user_id']))
            header("Location: pages/login.php");

        $user_id = $_SESSION['user_id'];
        $category_id = $_POST['category_id'];
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $lokasi = $_POST['lokasi'];
        $status = $_POST['status'];

        // Upload Foto
        $nama_foto = $_FILES['foto']['name'];
        $tmp_foto = $_FILES['foto']['tmp_name'];

        // Buat nama unik untuk foto
        $foto_baru = time() . "_" . $nama_foto;
        $path = "assets/uploads/" . $foto_baru;

        if (move_uploaded_file($tmp_foto, $path)) {
            $stmt = $pdo->prepare("INSERT INTO items (user_id, category_id, judul_laporan, deskripsi, lokasi, foto, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $category_id, $judul, $deskripsi, $lokasi, $foto_baru, $status]);

            header("Location: pages/dashboard.php?pesan=berhasil");
        } else {
            echo "Gagal upload gambar.";
        }
        break;
        

    // MENGUPDATE DATA ITEM
    case 'update_item':
        if (!isset($_SESSION['user_id'])) exit;

        $id          = $_POST['id'];
        $category_id = $_POST['category_id'];
        $judul       = $_POST['judul'];
        $deskripsi   = $_POST['deskripsi'];
        $lokasi      = $_POST['lokasi'];
        $status      = $_POST['status'];
        $user_id_session = $_SESSION['user_id'];

        // Cek apakah benar ini miliknya
        $stmt_cek = $pdo->prepare("SELECT foto, user_id FROM items WHERE id = ?");
        $stmt_cek->execute([$id]);
        $item = $stmt_cek->fetch();

        if ($item && $item['user_id'] == $user_id_session) {
            // Cek apakah user upload foto baru
            if ($_FILES['foto']['name'] != "") {
                $nama_foto = $_FILES['foto']['name'];
                $foto_baru = time() . "_" . $nama_foto;
                move_uploaded_file($_FILES['foto']['tmp_name'], "assets/uploads/" . $foto_baru);
                $foto_final = $foto_baru;
            } else {
                $foto_final = $item['foto']; // Pakai foto lama
            }

            $sql = "UPDATE items SET category_id=?, judul_laporan=?, deskripsi=?, lokasi=?, foto=?, status=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$category_id, $judul, $deskripsi, $lokasi, $foto_final, $status, $id]);

            header("Location: pages/dashboard.php?pesan=berhasil_update");
        } else {
            header("Location: pages/dashboard.php?pesan=akses_ditolak");
        }
        exit();
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
}
?>