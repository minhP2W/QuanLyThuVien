<!-- Trang lấy lại mật khẩu cho quản trị viên/thủ thư -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lấy lại mật khẩu - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/login_admin.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/forgotPassword.css?v=1.0">
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

            <h2>Quên mật khẩu</h2>

            <p>Nhập tên đăng nhập để lấy lại mật khẩu.</p>

            <!-- Hiển thị thông báo lỗi nhập username -->
            <?php if (isset($error)): ?>
                <div class="alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <!-- Form lấy lại mật khẩu -->
            <?php if (!$showPassword): ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Tên đăng nhập</label>

                        <div class="input-box">
                            <i class="bi bi-person"></i>

                            <input type="text" name="username" placeholder="Nhập tên đăng nhập" required>
                        </div>
                    </div>

                    <button class="login-btn" type="submit">
                        Lấy lại mật khẩu
                    </button>

                </form>
            <?php else: ?>
                
            <!-- Hiển thị mật khẩu được lấy lại -->
            <div class="password-result">
                <p>Mật khẩu đã được đặt lại thành</p>

                <div class="password">
                    123456
                </div>

                <p>Vui lòng đăng nhập và đổi mật khẩu sau khi đăng nhập.</p>
            </div>

            <a href="<?= BASE_URL ?>/index.php?page=login_admin" class="back-login">
                Quay lại đăng nhập
            </a>

            <?php endif; ?>
        </div>
    </div>
</body>
</html>