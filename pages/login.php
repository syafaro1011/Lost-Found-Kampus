<?php 
session_start(); 

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
    <title>Login - E-Learning UTB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="login-wrapper">
    <div class="container">
        <div class="row login-container">
            <div class="col-lg-5 illustration-side d-none d-lg-flex">
                <div class="illustration-content">
                    <!-- Lost Items Floating -->
                    <div class="profile-card d-flex flex-column align-items-center" style="padding: 15px;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div style="width: 50px; height: 50px; background: #ff9800; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-wallet" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="width: 50px; height: 50px; background: #2196f3; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-mobile-alt" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="width: 50px; height: 50px; background: #e91e63; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-key" style="color: white; font-size: 24px;"></i>
                            </div>
                        </div>
                        <p style="margin-top: 10px; font-size: 12px; color: #666;">Barang Yang Sering Hilang</p>
                    </div>

                    <!-- Magnifying Glass with Items -->
                    <div style="position: relative; z-index: 2; margin: 30px 0;">
                        <svg class="person-illustration" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                            <!-- Magnifying Glass Handle -->
                            <rect x="190" y="180" width="12" height="80" rx="6" fill="#424242" transform="rotate(45 196 220)"/>
                            
                            <!-- Magnifying Glass Circle -->
                            <circle cx="150" cy="140" r="70" fill="none" stroke="#424242" stroke-width="8"/>
                            <circle cx="150" cy="140" r="65" fill="#e3f2fd" opacity="0.3"/>
                            
                            <!-- Shine effect on glass -->
                            <ellipse cx="130" cy="120" rx="20" ry="30" fill="white" opacity="0.4" transform="rotate(-45 130 120)"/>
                            
                            <!-- Items inside magnifying glass -->
                            <!-- Backpack -->
                            <g transform="translate(110, 120)">
                                <rect x="0" y="10" width="30" height="35" rx="5" fill="#f44336"/>
                                <rect x="5" y="15" width="20" height="25" rx="3" fill="#ef5350"/>
                                <ellipse cx="15" cy="10" rx="12" ry="8" fill="#f44336"/>
                                <rect x="8" y="0" width="5" height="12" rx="2" fill="#c62828"/>
                                <rect x="17" y="0" width="5" height="12" rx="2" fill="#c62828"/>
                            </g>
                            
                            <!-- Smartphone -->
                            <g transform="translate(155, 125)">
                                <rect x="0" y="0" width="25" height="40" rx="3" fill="#424242"/>
                                <rect x="2" y="4" width="21" height="32" rx="1" fill="#2196f3"/>
                                <circle cx="12.5" cy="38" r="2" fill="#666"/>
                            </g>
                            
                            <!-- Wallet -->
                            <g transform="translate(120, 165)">
                                <rect x="0" y="0" width="35" height="20" rx="2" fill="#795548"/>
                                <rect x="2" y="2" width="31" height="16" rx="1" fill="#8d6e63"/>
                                <line x1="5" y1="10" x2="30" y2="10" stroke="#5d4037" stroke-width="1"/>
                            </g>
                            
                            <!-- Small sparkles around items -->
                            <circle cx="105" cy="115" r="3" fill="#ffd700" opacity="0.8"/>
                            <circle cx="185" cy="125" r="2.5" fill="#ffd700" opacity="0.8"/>
                            <circle cx="125" cy="180" r="2" fill="#ffd700" opacity="0.8"/>
                            <circle cx="170" cy="165" r="3" fill="#ffd700" opacity="0.8"/>
                        </svg>
                    </div>
                    
                    <div style="text-align: center; margin-top: 20px;">
                        <h4 style="color: #1976d2; font-weight: 700; margin-bottom: 10px;">Lost & Found System</h4>
                        <p style="color: #666; font-size: 14px;">Temukan barang hilang Anda dengan mudah</p>
                    </div>
                </div>

                <!-- Floating Icons -->
                <div class="floating-icons">
                    <i class="fas fa-search heart-icon" style="color: #4caf50;"></i>
                    
                    <!-- ID Card -->
                    <div class="icon-element icon-chart" style="background: #ff5722;">
                        <i class="fas fa-id-card" style="font-size: 24px;"></i>
                    </div>
                    
                    <!-- Location Pin -->
                    <div class="icon-element icon-message" style="background: white; padding: 12px;">
                        <i class="fas fa-map-marker-alt" style="color: #f44336; font-size: 28px;"></i>
                    </div>
                    
                    <!-- Watch -->
                    <div class="icon-element icon-doc" style="background: #9c27b0;">
                        <i class="fas fa-clock" style="font-size: 20px; color: white;"></i>
                    </div>
                    
                    <!-- Glasses -->
                    <div class="icon-element icon-email" style="background: #00bcd4; padding: 12px 15px;">
                        <i class="fas fa-glasses" style="font-size: 18px; color: white;"></i>
                    </div>
                </div>
            </div>

            <!-- Form Side -->
            <div class="col-lg-7 form-side">
                <!-- Logo -->
                <div class="logo-header">
                    <div class="logo-utb">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="logo-text">
                        <h6>UNIVERSITAS</h6>
                        <h5>XXXXX XXXXXXX</h5>
                    </div>
                </div>

                <h2 class="form-title">Login - Lost & Found</h2>
                <p class="form-subtitle">Selamat Datang kembali, silahkan login ke akun Anda untuk melanjutkan</p>

                <!-- Alert -->
                <?php if(isset($_GET['pesan'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <small>
                            <?php 
                                if($_GET['pesan'] == "gagal") echo "Username atau Password salah!";
                                if($_GET['pesan'] == "restricted") echo "Maaf, Anda harus login dahulu.";
                                if($_GET['pesan'] == "logout") echo "Berhasil keluar sistem.";
                            ?>
                        </small>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="../api.php" method="POST" id="loginForm">
                    <input type="hidden" name="action" value="login">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?= isset($_COOKIE['last_user']) ? $_COOKIE['last_user'] : ''; ?>" 
                               placeholder="2021XXXXXXX" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="•••••" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-login w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>