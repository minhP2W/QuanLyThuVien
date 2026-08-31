<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lỗi 500: Lỗi hệ thống - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/error.css?v=1.0">
</head>
<body>
    <div class="error-container">
        <i class="bi bi-exclamation-octagon-fill error-icon"></i>

        <h1>500</h1>

        <h2>Đã xảy ra lỗi hệ thống</h2>

        <p>
            Máy chủ đang gặp sự cố. Vui lòng thử lại sau hoặc liên hệ quản trị viên nếu lỗi vẫn tiếp diễn.
        </p>

        <a href="<?= BASE_URL ?>/index.php?page=home" class="btn-back">
            <i class="bi bi-house-door-fill"></i>
            Quay về trang chủ
        </a>

    </div>
</body>
</html>