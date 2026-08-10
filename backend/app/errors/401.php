<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Lỗi 401: Chưa đăng nhập</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/error.css">
</head>
<body>
    <div class="error-container">
        <i class="bi bi-person-lock error-icon"></i>

        <h1>401</h1>

        <h2>Chưa xác thực</h2>

        <p>
            Bạn cần đăng nhập để truy cập vào trang này.
        </p>

        <a href="<?= BASE_URL ?>/index.php?page=login_reader" class="btn-back">
            <i class="bi bi-box-arrow-in-right"></i>
            Đăng nhập
        </a>
    </div>
</body>
</html>