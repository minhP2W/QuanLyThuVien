<!-- Trang sách của tôi cho độc giả -->
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
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/myBook.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js?v=1.0"></script>

    <?php require_once 'sidebar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>

    <div class="reader-my-books">
        <div class="page-header">
            <div>
                <h2>Sách của tôi</h2>
                <p>Danh sách sách bạn đang mượn</p>
            </div>

            <span class="book-count">
                <?= count($myBooks) ?> sách
            </span>
        </div>

        <?php if (!empty($myBooks)): ?>
            <div class="my-book-grid">
                <?php foreach ($myBooks as $book): ?>
                    <div class="my-book-card">
                        <!-- Ảnh bìa -->
                        <div class="my-book-cover">
                            <?php if (!empty($book['cover_image'])): ?>
                                <img src="<?= BASE_URL . '/frontend/assets/images/' . htmlspecialchars($book['cover_image']) ?>"
                                     alt="<?= htmlspecialchars($book['title']) ?>">
                            <?php else: ?>
                                <div class="my-no-cover">
                                    <i class="bi bi-book"></i>
                                    <span>Không có ảnh</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Thông tin -->
                        <div class="my-book-info">
                            <h3 title="<?= htmlspecialchars($book['title']) ?>">
                                <?= htmlspecialchars($book['title']) ?>
                            </h3>

                            <p class="my-book-author">
                                <?= htmlspecialchars($book['author_name'] ?? 'Chưa cập nhật') ?>
                            </p>

                            <!-- Ngày mượn -->
                            <div class="borrow-info">
                                <div class="borrow-row">
                                    <span>
                                        <i class="bi bi-calendar-check"></i>
                                        Ngày mượn
                                    </span>

                                    <strong>
                                        <?= !empty($book['borrow_date'])
                                            ? date('d/m/Y', strtotime($book['borrow_date']))
                                            : '--'
                                        ?>
                                    </strong>
                                </div>

                                <!-- Hạn trả -->
                                <div class="borrow-row">
                                    <span>
                                        <i class="bi bi-calendar-event"></i>
                                        Hạn trả
                                    </span>

                                    <strong class="<?= $book['status'] === 'Overdue' ? 'overdue' : '' ?>">
                                        <?= !empty($book['due_date'])
                                            ? date('d/m/Y', strtotime($book['due_date']))
                                            : '--'
                                        ?>
                                    </strong>
                                </div>
                            </div>

                            <!-- Trạng thái -->
                            <?php if ($book['status'] === 'Overdue'): ?>
                                <span class="borrow-status overdue-status">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Quá hạn
                                </span>

                            <?php else: ?>

                                <span class="borrow-status borrowing-status">
                                    <i class="bi bi-bookmark-check"></i>
                                    Đang mượn
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-my-books">
                <div class="empty-icon">
                    <i class="bi bi-book"></i>
                </div>

                <h3>Chưa có sách đang mượn</h3>

                <p>
                    Hiện tại bạn không có sách nào đang được mượn.
                </p>

                <a href="<?= BASE_URL ?>/index.php?page=book" class="browse-books">
                    <i class="bi bi-search"></i>
                    Tìm sách
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <?php require_once 'footer.php';?>
</body>
</html>