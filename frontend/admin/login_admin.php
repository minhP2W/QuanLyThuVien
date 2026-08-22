<!-- Trang đăng nhập cho quản trị viên/thủ thư -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/login_admin.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="login-logo">
                <a href="<?= BASE_URL ?>/index.php?page=dashboard">
                    <img src="<?= BASE_URL ?>/frontend/assets/images/logo.png" alt="Librio">
                </a>
            </div>

            <h2>Đăng nhập</h2>

            <p>
                Dành cho Quản trị viên và Thủ thư
            </p>

            <!-- Hiển thị cảnh báo chưa đăng nhập -->
            <?php if (isset($_SESSION['warning'])): ?>
                <div class="alert-warning" id="alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= $_SESSION['warning']; ?></span>
                </div>
                <?php unset($_SESSION['warning']); ?>
            <?php endif; ?>

            <!-- Hiển thị thông báo đăng xuất thành công -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert-success" id="alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <!-- Hiển thị thông báo lỗi đăng nhập -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert-error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <!-- Form đăng nhập -->
            <form action="<?= BASE_URL ?>/index.php?page=login_admin" method="POST">
                <div class="form-group">
                    <label>Tên đăng nhập</label>

                    <div class="input-box">
                        <i class="bi bi-person"></i>
                        <input type="text" name="username" placeholder="Nhập tên đăng nhập" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mật khẩu</label>

                    <div class="input-box">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required>
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <div class="login-option">
                    <a href="<?= BASE_URL ?>/index.php?page=forgotPassword_admin">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="login-btn">
                    Đăng nhập
                </button>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/frontend/assets/js/login.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>
</body>
</html>