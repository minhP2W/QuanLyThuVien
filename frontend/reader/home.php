<!-- Trang chủ cho độc giả -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Trang chủ</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/home.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js"></script>

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

    <main class="reader-home">
        <!-- Banner -->
        <section class="home-banner">
            <img src="<?= BASE_URL ?>/frontend/assets/images/banner.png"
                alt="Thư viện Librio"
                class="banner-image">

            <div class="banner-content">
                <h1>
                    Chào mừng bạn đến với<br>
                    Thư viện Librio
                </h1>

                <p>
                    Khám phá kho sách phong phú<br>
                    và tri thức vô tận.
                </p>

                <!-- Ô tìm kiếm -->
                <form action="<?= BASE_URL ?>/index.php" method="GET" class="search-form">
                    <input type="hidden" name="page" value="books">

                    <input
                        type="text"
                        name="keyword"
                        placeholder="Tìm kiếm sách, tác giả, thể loại..."
                        autocomplete="off"
                    >

                    <button type="submit" aria-label="Tìm kiếm">
                        Tìm kiếm
                    </button>
                </form>

                <!-- Lịch sử tìm kiếm -->
                <?php if (!empty($searchHistories)): ?>
                    <div class="search-history">
                        <span class="history-title">Lịch sử tìm kiếm:</span>

                        <div class="history-list">
                            <?php foreach ($searchHistories as $history): ?>
                                <a href="<?= BASE_URL ?>/index.php?page=book&keyword=<?= urlencode($history['keyword']) ?>"
                                class="history-item">
                                    <?= htmlspecialchars($history['keyword']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="search-history">
                        <span class="history-title">Lịch sử tìm kiếm:</span>
                        <span class="empty-history">Chưa có lịch sử tìm kiếm</span>
                    </div>
                <?php endif; ?>
            </div>
        </section>


        <!-- Sách mới -->
        <section class="book-section">
            <div class="section-header">
                <h2>Sách mới</h2>

                <a href="<?= BASE_URL ?>/index.php?page=book">
                    Xem tất cả →
                </a>
            </div>

            <div class="book-grid">
                <?php if (!empty($newBooks)): ?>
                    <?php foreach ($newBooks as $book): ?>
                        <a href="<?= BASE_URL ?>/index.php?page=book_detail&id=<?= $book['book_id'] ?>"
                        class="book-card">
                            <div class="book-cover">
                                <?php if (!empty($book['cover_image'])): ?>
                                    <img
                                        src="<?= BASE_URL ?>/frontend/assets/images/<?= htmlspecialchars($book['cover_image']) ?>"
                                        alt="<?= htmlspecialchars($book['title']) ?>"
                                    >
                                <?php else: ?>
                                    <div class="no-cover">
                                        Không có ảnh
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="book-info">
                                <h3>
                                    <?= htmlspecialchars($book['title']) ?>
                                </h3>

                                <p class="book-author">
                                    <?= htmlspecialchars($book['author_name'] ?? 'Chưa cập nhật') ?>
                                </p>

                                <span class="book-year">
                                    <?= htmlspecialchars($book['publish_year'] ?? '') ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p class="empty-data">
                        Chưa có sách mới.
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Sách nổi bật -->
        <section class="book-section">
            <div class="section-header">
                <h2>Sách nổi bật</h2>

                <a href="<?= BASE_URL ?>/index.php?page=book">
                    Xem tất cả →
                </a>
            </div>

            <div class="book-grid">
                <?php if (!empty($featuredBooks)): ?>
                    <?php foreach ($featuredBooks as $book): ?>
                        <a href="<?= BASE_URL ?>/index.php?page=book_detail&id=<?= $book['book_id'] ?>"
                        class="book-card">
                            <div class="book-cover">
                                <?php if (!empty($book['cover_image'])): ?>
                                    <img
                                        src="<?= BASE_URL ?>/frontend/assets/images/<?= htmlspecialchars($book['cover_image']) ?>"
                                        alt="<?= htmlspecialchars($book['title']) ?>"
                                    >
                                <?php else: ?>
                                    <div class="no-cover">
                                        Không có ảnh
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="book-info">
                                <h3>
                                    <?= htmlspecialchars($book['title']) ?>
                                </h3>

                                <p class="book-author">
                                    <?= htmlspecialchars($book['author_name'] ?? 'Chưa cập nhật') ?>
                                </p>

                                <div class="book-rating">
                                    <span class="star">★</span>

                                    <span>
                                        <?= number_format((float)($book['average_rating'] ?? 0), 1) ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-data">
                        Chưa có sách nổi bật.
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Thể loại -->
        <section class="category-section">
            <div class="section-header">
                <h2>Thể loại</h2>

                <a href="<?= BASE_URL ?>/index.php?page=category">
                    Xem tất cả →
                </a>
            </div>

            <div class="category-grid">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <a href="<?= BASE_URL ?>/index.php?page=books&category=<?= $category['category_id'] ?>"
                        class="category-card">
                            <div class="category-icon" style="background: <?= htmlspecialchars($category['icon_color']) ?>20;
                                                              color: <?= htmlspecialchars($category['icon_color']) ?>;">
                                <i class="bi <?= htmlspecialchars($category['icon']) ?>"></i>
                            </div>

                            <div class="category-info">
                                <h3>
                                    <?= htmlspecialchars($category['category_name']) ?>
                                </h3>

                                <span>
                                    (<?= (int)($category['book_count'] ?? 0) ?>)
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-data">
                        Chưa có thể loại.
                    </p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/home.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/sidebar_reader.js?v=1.0"></script>

    <?php require_once 'footer.php';?>
</body>
</html>