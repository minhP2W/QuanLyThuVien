<!-- Trang đặt trước cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách của tôi - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/reservation.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js?v=1.0"></script>

    <?php require_once 'sidebar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>
    
    <?php require_once 'footer.php';?>
</body>
</html>