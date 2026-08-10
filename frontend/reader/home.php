<!-- Trang chủ cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Trang chủ</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/home.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar_reader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer_reader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css">
</head>
<body>
    <?php require_once 'navbar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar_reader.js"></script>

    <?php require_once 'sidebar_reader.php';?>

    <!-- Hiển thị thông báo đăng ký, đăng nhập thành công -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success" id="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span><?= $_SESSION['success']; ?></span>
        </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Hiển thị cảnh báo chưa vào được chức năng khi chưa đăng ký/đăng nhập -->
    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert-warning" id="alert-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span><?= $_SESSION['warning']; ?></span>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/home.js"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js"></script>

    <?php require_once 'footer_reader.php';?>
</body>
</html>