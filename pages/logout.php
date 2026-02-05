<?php
session_start();

// Proses Logout di balik layar
if (isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .logout-card {
            max-width: 400px;
            width: 100%;
            text-align: center;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body>

    <div class="card logout-card p-5">
        <div class="card-body">
            <div class="text-danger mb-4">
                <i class="bi bi-box-arrow-right" style="font-size: 4rem;"></i>
            </div>
            <h4 class="fw-bold">Berhasil Logout</h4>
            <p class="text-muted">Anda akan dialihkan sebentar lagi.</p>

            <div class="d-flex justify-content-center my-4">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <p class="small text-muted">Tidak ingin menunggu? <br>
                <a href="login.php" class="text-decoration-none fw-bold">Klik di sini untuk Login</a>
            </p>
        </div>
    </div>

    <script type="text/javascript">
        setTimeout(function () {
            window.location.href = "login.php?pesan=logout";
        }, 2500); 
    </script>

</body>

</html>