<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lỗi 403: Không có quyền truy cập - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/error.css?v=1.0">
</head>
<body>
    <div class="error-container">
        <i class="bi bi-shield-lock-fill error-icon"></i>

        <h1>403</h1>

        <h2>Truy cập bị từ chối</h2>

        <p>
            Bạn không có quyền truy cập vào trang này.
        </p>

        <?php
            if (isset($_SESSION['admin'])) {
                $backUrl = BASE_URL . '/index.php?page=dashboard';
                $backText = 'Quay về trang quản trị';
            } else {
                $backUrl = BASE_URL . '/index.php?page=home';
                $backText = 'Quay về trang chủ';
            }
        ?>

        <a href="<?= $backUrl ?>" class="btn-back">
            <i class="bi bi-house-door-fill"></i>
            <?= $backText ?>
        </a>
    </div>
</body>
</html>