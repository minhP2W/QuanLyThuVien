<!-- Trang danh sách sách cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/book.css?v=1.0">
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

    <!-- Hiển thị cảnh báo chưa vào được chức năng khi chưa đăng ký/đăng nhập -->
    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert-warning" id="alert-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span><?= $_SESSION['warning']; ?></span>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

    <main class="reader-books">
        <div class="books-header">
            <div>
                <h1>Sách</h1>
            </div>

            <?php
                $startBook = $totalBooks > 0
                    ? $offset + 1
                    : 0;

                $endBook = min(
                    $offset + $limit,
                    $totalBooks
                );
            ?>

            <div class="books-count">
                Sách <?= $startBook ?> - <?= $endBook ?>
            </div>
        </div>


        <div class="books-layout">
            <!-- Bộ lọc -->
            <aside class="book-filter">
                <div class="filter-header">
                    <i class="bi bi-funnel"></i>
                    <h2>Bộ lọc</h2>
                </div>

                <form method="GET" action="<?= BASE_URL ?>/index.php" class="filter-form">
                    <input type="hidden" name="page" value="book">

                    <!-- Từ khóa -->
                    <div class="filter-group">
                        <label for="keyword">
                            Tìm kiếm
                        </label>

                        <div class="filter-search">
                            <i class="bi bi-search"></i>

                            <input type="text" id="keyword" name="keyword" value="<?= htmlspecialchars($keyword) ?>"
                                   placeholder="Tên sách, tác giả...">
                        </div>
                    </div>

                    <!-- Thể loại -->
                    <div class="filter-group">
                        <label>
                            Thể loại
                        </label>

                        <div class="checkbox-list">
                            <?php foreach ($categories as $category): ?>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="category_id[]" value="<?= $category['category_id'] ?>"
                                        <?= in_array(
                                            (string)$category['category_id'],
                                            array_map('strval', $categoryIds)
                                        ) ? 'checked' : '' ?>>

                                    <span>
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Năm xuất bản -->
                    <div class="filter-group">
                        <label>
                            Năm xuất bản
                        </label>

                       <div class="checkbox-list year-list">
                            <?php foreach ($availableYears as $yearData): ?>
                                <?php $year = $yearData['publish_year']; ?>

                                <label class="checkbox-item">
                                    <input type="checkbox" name="publish_year[]" value="<?= $year ?>"
                                        <?= in_array(
                                            (string)$year,
                                            array_map('strval', $publishYears)
                                        ) ? 'checked' : '' ?>>

                                    <span><?= $year ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Tình trạng -->
                    <div class="filter-group">
                        <label>
                            Tình trạng
                        </label>

                        <div class="radio-list">
                            <label class="radio-item">
                                <input type="radio" name="status" value="" <?= $status === '' ? 'checked' : '' ?>>

                                <span>Tất cả</span>
                            </label>

                            <label class="radio-item">
                                <input type="radio" name="status" value="available" <?= $status === 'available' ? 'checked' : '' ?>>

                                <span>Còn sách</span>
                            </label>


                            <label class="radio-item">
                                <input type="radio" name="status" value="unavailable" <?= $status === 'unavailable' ? 'checked' : '' ?>>

                                <span>Hết sách</span>
                            </label>
                        </div>
                    </div>

                    <!-- Áp dụng -->
                    <button type="submit" class="filter-submit">
                        Áp dụng bộ lọc
                    </button>

                    <!-- Xóa -->
                    <a href="<?= BASE_URL ?>/index.php?page=book" class="filter-reset">
                        Xóa bộ lọc
                    </a>
                </form>
            </aside>

            <!-- Danh sách sách -->
            <section class="books-result">
                <?php if (!empty($books)): ?>
                    <div class="book-grid">
                        <?php foreach ($books as $book): ?>
                            <div class="book-card">
                                <button type="button"
                                        class="favorite-btn reader-login-required <?= !empty($book['favorite_id']) ? 'active' : '' ?>"
                                        data-book-id="<?= $book['book_id'] ?>" data-return-page="book">
                                    <i class="bi <?= !empty($book['favorite_id']) ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                                </button>

                                <a href="<?= BASE_URL ?>/index.php?page=book_detail&id=<?= $book['book_id'] ?>" class="book-link">
                                    <div class="book-cover">
                                        <?php if (!empty($book['cover_image'])): ?>
                                            <img src="<?= BASE_URL ?>/frontend/assets/images/<?= htmlspecialchars($book['cover_image']) ?>"
                                                alt="<?= htmlspecialchars($book['title']) ?>">
                                        <?php else: ?>
                                            <div class="no-cover">
                                                Không có ảnh
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="book-info">
                                        <h2 title="<?= htmlspecialchars($book['title']) ?>">
                                            <?= htmlspecialchars($book['title']) ?>
                                        </h2>

                                        <p class="book-author">
                                            <?= htmlspecialchars($book['author_name']) ?>
                                        </p>

                                        <div class="book-meta">
                                            <span>
                                                <?= htmlspecialchars($book['category_name']) ?>
                                            </span>

                                            <?php if (!empty($book['publish_year'])): ?>
                                                <span>
                                                    <?= $book['publish_year'] ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($book['available_quantity'] > 0): ?>
                                            <div class="book-status available">
                                                <i class="bi bi-check-circle"></i>
                                                Còn <?= $book['available_quantity'] ?> cuốn
                                            </div>
                                        <?php else: ?>
                                            <div class="book-status unavailable">
                                                <i class="bi bi-x-circle"></i>
                                                Hết sách
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php
                        $paginationParams = [
                            'page' => 'book',
                            'keyword' => $keyword,
                            'category_id' => $categoryIds,
                            'publish_year' => $publishYears,
                            'status' => $status
                        ];
                    ?>

                    <?php if ($totalPages >= 1): ?>
                        <div class="pagination">
                            <!-- Trang trước -->
                            <?php if ($currentPage > 1): ?>
                                <?php
                                    $paginationParams['page_number'] = $currentPage - 1;

                                    $previousUrl = BASE_URL . '/index.php?' . http_build_query($paginationParams);
                                ?>

                                <a href="<?= htmlspecialchars($previousUrl) ?>" class="pagination-btn" title="Trang trước">
                                    <i class="bi bi-chevron-left"></i>
                                </a>

                            <?php else: ?>
                                <span class="pagination-btn disabled">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            <?php endif; ?>

                            <!-- Số trang -->
                            <?php for (
                                $pageNumber = 1;
                                $pageNumber <= $totalPages;
                                $pageNumber++
                            ): ?>
                                <?php if ($pageNumber == $currentPage): ?>
                                    <span class="pagination-number active">
                                        <?= $pageNumber ?>
                                    </span>
                                <?php else: ?>
                                    <?php
                                        $paginationParams['page_number'] = $pageNumber;

                                        $pageUrl = BASE_URL . '/index.php?' . http_build_query($paginationParams);
                                    ?>

                                    <a href="<?= htmlspecialchars($pageUrl) ?>" class="pagination-number">
                                        <?= $pageNumber ?>
                                    </a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <!-- Trang sau -->
                            <?php if ($currentPage < $totalPages): ?>
                                <?php
                                    $paginationParams['page_number'] = $currentPage + 1;

                                    $nextUrl = BASE_URL . '/index.php?' . http_build_query($paginationParams);
                                ?>

                                <a href="<?= htmlspecialchars($nextUrl) ?>" class="pagination-btn" title="Trang sau">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            <?php else: ?>
                                <span class="pagination-btn disabled">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="empty-books">
                        <i class="bi bi-search"></i>

                        <p>
                            Không tìm thấy sách phù hợp với bộ lọc.
                        </p>

                        <a href="<?= BASE_URL ?>/index.php?page=book">
                            Xem tất cả sách
                        </a>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/book.js?v=1.0"></script>

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>

    <?php require_once 'footer.php';?>
</body>
</html>