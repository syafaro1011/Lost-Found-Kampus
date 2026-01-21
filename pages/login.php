<?php 
session_start(); 

// Jika sudah login, paksa ke dashboard agar tidak login berulang kali
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lost & Found</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-9 col-lg-7 d-flex card-login bg-white overflow-hidden p-0">
            
            <div class="col-md-5 d-none d-md-block bg-success p-5 text-white text-center d-flex align-items-center">
                <div>
                    <h3>Selamat Datang!</h3>
                    <p>Temukan barangmu yang hilang atau laporkan temuanmu di sini.</p>
                </div>
            </div>

            <div class="col-md-7 p-5">
                <h3 class="mb-4 fw-bold">Login</h3>

                <?php if(isset($_GET['pesan'])): ?>
                    <div class="alert alert-danger py-2" role="alert">
                        <small>
                            <?php 
                                if($_GET['pesan'] == "gagal") echo "Username atau Password salah!";
                                if($_GET['pesan'] == "restricted") echo "Maaf, Anda harus login dahulu.";
                                if($_GET['pesan'] == "logout") echo "Berhasil keluar sistem.";
                            ?>
                        </small>
                    </div>
                <?php endif; ?>

                <form action="../api.php" method="POST">
                    <input type="hidden" name="action" value="login">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?= isset($_COOKIE['last_user']) ? $_COOKIE['last_user'] : ''; ?>" 
                               placeholder="Masukkan username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" 
                               placeholder="Masukkan password" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Masuk Sekarang</button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <small class="text-muted">&copy; 2026 Proyek UAS Web</small>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>