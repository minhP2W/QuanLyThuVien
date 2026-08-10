<!-- Trang quản trị cho quản trị viên/thủ thư -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Trang quản trị</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/sidebar_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css">
</head>
<body>
    <?php require_once 'sidebar_admin.php';?>

    <!-- Hiển thị thông báo đăng nhập thành công -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success" id="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span><?= $_SESSION['success']; ?></span>
        </div>

    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/admin/dashboard.js"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js"></script>
</body>
</html>