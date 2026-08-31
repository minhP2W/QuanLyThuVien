<!-- Trang lịch sử mượn cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử mượn - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/borrowHistory.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js?v=1.0"></script>

    <?php require_once 'sidebar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>

    <main class="history-page">
        <div class="history-container">
            <!-- Header -->
            <div class="history-header">
                <div>
                    <h2>Lịch sử mượn</h2>

                    <p>
                        Danh sách các phiếu mượn sách của bạn
                    </p>
                </div>

                <span class="history-count">
                    <?= count($borrowHistory) ?> lượt mượn
                </span>
            </div>

            <?php if (!empty($borrowHistory)): ?>
                <div class="history-list">
                    <?php foreach ($borrowHistory as $borrow): ?>
                        <div class="history-card">
                            <!-- Header phiếu -->
                            <div class="history-card-header">
                                <div class="borrow-title">
                                    <i class="bi bi-journal-bookmark"></i>

                                    <strong>
                                        Phiếu mượn #<?= htmlspecialchars($borrow['borrow_id']) ?>
                                    </strong>
                                </div>

                                <?php if ($borrow['status'] === 'Returned'): ?>
                                    <span class="returned-status">
                                        <i class="bi bi-check-circle"></i>
                                        Đã trả
                                    </span>

                                <?php elseif ($borrow['status'] === 'Overdue'): ?>
                                    <span class="overdue-status">
                                        <i class="bi bi-exclamation-circle"></i>
                                        Quá hạn
                                    </span>

                                <?php elseif ($borrow['status'] === 'Lost'): ?>
                                    <span class="lost-status">
                                        <i class="bi bi-x-circle"></i>
                                        Đã mất
                                    </span>

                                <?php else: ?>
                                    <span class="borrowing-status">
                                        <i class="bi bi-bookmark-check"></i>
                                        Đang mượn
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Thông tin phiếu -->
                            <div class="history-info">
                                <div class="history-row">
                                    <span>
                                        <i class="bi bi-calendar-check"></i>
                                        Ngày mượn
                                    </span>

                                    <strong>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($borrow['borrow_date'])
                                        ) ?>
                                    </strong>
                                </div>

                                <div class="history-row">
                                    <span>
                                        <i class="bi bi-calendar-event"></i>
                                        Hạn trả
                                    </span>

                                    <strong>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($borrow['due_date'])
                                        ) ?>
                                    </strong>
                                </div>

                                <div class="history-row">
                                    <span>
                                        <i class="bi bi-book"></i>
                                        Sách đã mượn
                                    </span>

                                    <div class="borrow-books">
                                        <?php foreach ($borrow['books'] as $book): ?>
                                            <div class="borrow-book">
                                                <div class="borrow-book-info">
                                                    <h4>
                                                        <?= htmlspecialchars($book['title']) ?>
                                                    </h4>

                                                    <p>
                                                        <i class="bi bi-calendar"></i>
                                                        <?= htmlspecialchars($book['publish_year'] ?? 'Chưa cập nhật') ?>
                                                    </p>

                                                    <p>
                                                        <i class="bi bi-person"></i>
                                                        <?= htmlspecialchars($book['author_name'] ?? 'Chưa cập nhật') ?>
                                                    </p>

                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="history-row">
                                    <span>
                                        <i class="bi bi-bookshelf"></i>
                                        Số lượng
                                    </span>

                                    <strong>
                                        <?= count($borrow['books']) ?> sách
                                    </strong>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Không có lịch sử -->
                <div class="empty-history">
                    <i class="bi bi-clock-history"></i>

                    <h3>Chưa có lịch sử mượn</h3>

                    <p>
                        Bạn chưa hoàn thành lượt mượn sách nào.
                    </p>

                    <a href="<?= BASE_URL ?>/index.php?page=book">
                        <i class="bi bi-book"></i>
                        Khám phá sách
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <?php require_once 'footer.php';?>
</body>
</html>