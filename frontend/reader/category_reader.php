<!-- Trang thể loại sách cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thể loại sách - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/category_reader.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js?v=1.0"></script>

    <?php require_once 'sidebar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>

    <!-- Hiển thị cảnh báo chưa vào được chức năng khi chưa đăng ký/đăng nhập -->
    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert-warning" id="alert-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span><?= $_SESSION['warning']; ?></span>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

    <!-- Nội dung trang thể loại -->
    <main class="reader-category">
        <!-- Tiêu đề -->
        <div class="category-page-header">
            <div>
                <h1>Thể loại sách</h1>
            </div>
        </div>

        <!-- Danh sách thể loại -->
        <div class="category-grid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a href="<?= BASE_URL ?>/index.php?page=book_reader&category_id[]=<?= (int)$category['category_id'] ?>" class="category-card">
                        <!-- Icon -->
                        <div class="category-icon" style="background: <?= htmlspecialchars($category['icon_color'] ?? '#3974d5') ?>20;
                                                          color: <?= htmlspecialchars($category['icon_color'] ?? '#3974d5') ?>;">
                            <i class="<?= htmlspecialchars($category['icon'] ?? 'bi bi-book') ?>"></i>
                        </div>

                        <!-- Thông tin -->
                        <div class="category-info">
                            <h3>
                                <?= htmlspecialchars($category['category_name']) ?>
                            </h3>

                            <span>
                                <?= (int)$category['book_count'] ?> cuốn sách
                            </span>
                        </div>

                        <!-- Mũi tên -->
                        <div class="category-arrow">
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-data">
                    Không có thể loại nào.
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>

    <?php require_once 'footer.php';?>
</body>
</html>