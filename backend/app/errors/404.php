<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Lỗi 404: Không tìm thấy trang</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/error.css?v=1.0">
</head>
<body>
    <div class="error-container">
        <i class="bi bi-search error-icon"></i>

        <h1>404</h1>

        <h2>Không tìm thấy trang</h2>

        <p>
            Trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển.
        </p>

        <?php
            // Lấy địa chỉ trang trước đó, nếu không có thì để trống
            $referrer = $_SERVER['HTTP_REFERER'] ?? '';

            // Kiểm tra người dùng vừa đi từ trang nào sang 404, nếu từ Dashboard thì quay về Dashboard, còn lại quay về Home
            if (strpos($referrer, 'page=dashboard') !== false) {
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