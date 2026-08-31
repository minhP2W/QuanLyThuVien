<!-- Trang sách yêu thích cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách yêu thích - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/favorite.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
</head>
<body data-logged-in="<?= isset($_SESSION['reader']) ? 'true' : 'false' ?>" data-base-url="<?= BASE_URL ?>">
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js?v=1.0"></script>

    <?php require_once 'sidebar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>

    <!-- Hiển thị thông báo thêm sách yêu thích thành công -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success" id="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span><?= $_SESSION['success']; ?></span>
        </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Nội dung sách yêu thích -->
    <main class="favorite-page">
        <div class="favorite-container">
            <div class="favorite-header">
                <div>
                    <h2>
                        Sách yêu thích
                    </h2>
                </div>

                <span class="favorite-count">
                    <?= count($favoriteBooks) ?> sách
                </span>
            </div>

            <?php if (empty($favoriteBooks)): ?>
                <div class="empty-favorite">
                    <i class="bi bi-heart"></i>

                    <h3>Chưa có sách yêu thích</h3>

                    <p>
                        Bạn chưa thêm cuốn sách nào vào danh sách yêu thích.
                    </p>

                    <a href="<?= BASE_URL ?>/index.php?page=book_reader">
                        <i class="bi bi-book"></i>
                        Khám phá sách
                    </a>
                </div>
            <?php else: ?>
                <div class="favorite-grid">
                    <?php foreach ($favoriteBooks as $book): ?>
                        <div class="book-card">
                            <div class="book-cover">
                                <img src="<?= BASE_URL ?>/frontend/assets/images/<?= htmlspecialchars($book['cover_image']) ?>"
                                    alt="<?= htmlspecialchars($book['title']) ?>">

                                <button type="button" class="favorite-btn active reader-login-required" data-book-id="<?= $book['book_id'] ?>"
                                        data-return-page="favorite">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </div>

                            <div class="book-info">
                                <h3>
                                    <?= htmlspecialchars($book['title']) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($book['author_name'] ?? 'Chưa cập nhật') ?>
                                </p>

                                <p>
                                    <?= htmlspecialchars($book['publish_year']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/book.js?v=1.0"></script>

    <?php require_once 'footer.php';?>
</body>
</html>