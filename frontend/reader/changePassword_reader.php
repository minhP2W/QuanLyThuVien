<!-- Trang thay đổi mật khẩu cho độc giả -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Đổi mật khẩu</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/changePassword_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js"></script>

    <?php require_once 'sidebar_reader.php';?>

    <div class="change-password-container">
        <div class="change-password-header">
            <h2>Đổi mật khẩu</h2>
        </div>

        <!-- Hiển thị lỗi trùng thông tin -->
        <?php if(isset($error)): ?>
            <div class="alert-error">
                <i class="bi bi-x-circle-fill"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <!-- Form đổi mật khẩu cho độc giả -->
        <form action="<?= BASE_URL ?>/index.php?page=changePassword_reader" method="POST" class="change-password-card">
            <div class="form-group">
                <label>Mật khẩu hiện tại</label>
                <div class="password-box">
                    <input type="password" name="old_password" id="old-password" placeholder="Nhập mật khẩu hiện tại" required>
                    <i class="bi bi-eye-slash toggle-password" id="toggleOldPassword"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Mật khẩu mới</label>
                <div class="password-box">
                    <input type="password" name="new_password" id="new-password" placeholder="Nhập mật khẩu mới" required>
                    <i class="bi bi-eye-slash toggle-password" id="toggleNewPassword"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Xác nhận mật khẩu mới</label>
                <div class="password-box">
                    <input type="password" name="confirm_password" id="confirm-password" placeholder="Nhập lại mật khẩu mới" required>
                    <i class="bi bi-eye-slash toggle-password" id="toggleConfirmPassword"></i>
                </div>
            </div>

            <div class="change-password-actions">
                <button type="submit" class="btn-primary">
                    Đổi mật khẩu
                </button>

                <a href="<?= BASE_URL ?>/index.php?page=profile_reader" class="btn-secondary">
                    Quay lại
                </a>
            </div>

        </form>
    </div>

    <script src="<?= BASE_URL ?>/frontend/assets/js/changePassword.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>

    <?php require_once 'footer.php';?>
</body>
</html>