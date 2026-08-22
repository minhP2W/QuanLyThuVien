<!-- Trang quản trị cho quản trị viên/thủ thư -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/dashboard.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/sidebar_admin.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
</head>
<body>
    <?php require_once 'sidebar_admin.php';?>

    <!-- Hiển thị thông báo đăng nhập thành công -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success" id="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span><?= $_SESSION['success']; ?></span>
        </div>

    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="admin-dashboard">

        <!-- Header -->
        <div class="dashboard-header">
            <div>
                <h1>Dashboard</h1>
                <p>Tổng quan hoạt động thư viện</p>
            </div>

            <div class="dashboard-date">
                <i class="bi bi-calendar3"></i>
                <?= date('d/m/Y') ?>
            </div>
        </div>


        <!-- Thống kê -->
        <div class="dashboard-stats">
            <!-- Tổng số đầu sách -->
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-book"></i>
                </div>

                <div class="stat-info">
                    <span>Tổng số đầu sách</span>
                    <strong>
                        <?= number_format($bookStats['total_titles'] ?? 0) ?>
                    </strong>
                </div>
            </div>

            <!-- Tổng số bản sách -->
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-bookshelf"></i>
                </div>

                <div class="stat-info">
                    <span>Tổng số bản sách</span>
                    <strong>
                        <?= number_format($bookStats['total_books'] ?? 0) ?>
                    </strong>
                </div>
            </div>

            <!-- Độc giả -->
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-people"></i>
                </div>

                <div class="stat-info">
                    <span>Độc giả hoạt động</span>
                    <strong>
                        <?= number_format($totalReaders ?? 0) ?>
                    </strong>
                </div>
            </div>

            <!-- Đang mượn -->
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-journal-arrow-up"></i>
                </div>

                <div class="stat-info">
                    <span>Phiếu đang mượn</span>
                    <strong>
                        <?= number_format($borrowStats['borrowing_slips'] ?? 0) ?>
                    </strong>
                </div>
            </div>

            <!-- Quá hạn -->
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div class="stat-info">
                    <span>Phiếu quá hạn</span>
                    <strong>
                        <?= number_format($borrowStats['overdue_slips'] ?? 0) ?>
                    </strong>
                </div>
            </div>

            <!-- Tổng tiền phạt -->
            <div class="stat-card">
                <div class="stat-icon yellow">
                    <i class="bi bi-cash-coin"></i>
                </div>

                <div class="stat-info">
                    <span>Tổng tiền phạt</span>
                    <strong>
                        <?= number_format($fineStats['total_fine'] ?? 0) ?>đ
                    </strong>
                </div>
            </div>
        </div>

        <!-- Biểu đồ + Việc cần xử lý -->
        <div class="dashboard-main-grid">
            <!-- BIỂU ĐỒ -->
            <div class="dashboard-card chart-card">
                <div class="card-header">
                    <div>
                        <h2>Hoạt động mượn / trả</h2>
                        <p>Thống kê theo tháng trong năm <?= $year ?></p>
                    </div>

                    <form method="GET" action="<?= BASE_URL ?>/index.php" class="year-filter-form">
                        <input type="hidden" name="page" value="dashboard">

                        <select name="year" class="year-filter" onchange="this.form.submit()">
                            <option value="2026" <?= $year == 2026 ? 'selected' : '' ?>>
                                2026
                            </option>

                            <option value="2027" <?= $year == 2027 ? 'selected' : '' ?>>
                                2027
                            </option>
                        </select>
                    </form>
                </div>

                <div class="chart-wrapper">
                    <canvas id="borrowReturnChart"></canvas>
                </div>
            </div>

            <!-- VIỆC CẦN XỬ LÝ -->
            <div class="dashboard-card task-card">
                <div class="card-header">
                    <div>
                        <h2>Cần xử lý</h2>
                        <p>Các vấn đề cần quan tâm</p>
                    </div>
                </div>

                <div class="task-list">
                    <!-- Quá hạn -->
                    <a href="<?= BASE_URL ?>/index.php?page=borrow" class="task-item">
                        <div class="task-icon danger">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <div class="task-content">
                            <strong>
                                <?= number_format($pendingTasks['overdue_count'] ?? 0) ?>
                            </strong>

                            <span>phiếu mượn quá hạn</span>
                        </div>

                        <i class="bi bi-chevron-right task-arrow"></i>
                    </a>

                    <!-- Đặt trước -->
                    <a href="<?= BASE_URL ?>/index.php?page=reservation" class="task-item">
                        <div class="task-icon warning">
                            <i class="bi bi-bookmark"></i>
                        </div>

                        <div class="task-content">
                            <strong>
                                <?= number_format($pendingTasks['reservation_count'] ?? 0) ?>
                            </strong>

                            <span>yêu cầu đặt sách chờ xử lý</span>
                        </div>

                        <i class="bi bi-chevron-right task-arrow"></i>
                    </a>

                    <!-- Hết sách -->
                    <a href="<?= BASE_URL ?>/index.php?page=books" class="task-item">
                        <div class="task-icon blue">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div class="task-content">
                            <strong>
                                <?= number_format($pendingTasks['out_of_stock_count'] ?? 0) ?>
                            </strong>

                            <span>đầu sách đang hết</span>
                        </div>

                        <i class="bi bi-chevron-right task-arrow"></i>
                    </a>

                    <!-- Sách hỏng -->
                    <a href="<?= BASE_URL ?>/index.php?page=return" class="task-item">
                        <div class="task-icon orange">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>

                        <div class="task-content">
                            <strong>
                                <?= number_format($pendingTasks['damaged_count'] ?? 0) ?>
                            </strong>

                            <span>trường hợp sách bị hỏng</span>
                        </div>

                        <i class="bi bi-chevron-right task-arrow"></i>
                    </a>

                    <!-- Sách mất -->
                    <a href="<?= BASE_URL ?>/index.php?page=return" class="task-item">
                        <div class="task-icon red">
                            <i class="bi bi-x-circle"></i>
                        </div>

                        <div class="task-content">
                            <strong>
                                <?= number_format($pendingTasks['lost_count'] ?? 0) ?>
                            </strong>

                            <span>trường hợp sách bị mất</span>
                        </div>

                        <i class="bi bi-chevron-right task-arrow"></i>
                    </a>
                </div>
            </div>
        </div>


        <!-- Sách + Tình trạng kho -->
        <div class="dashboard-content-grid">
            <!-- SÁCH MƯỢN NHIỀU -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div>
                        <h2>Sách được mượn nhiều nhất</h2>
                        <p>Top 5 đầu sách có lượt mượn cao nhất</p>
                    </div>

                    <a href="<?= BASE_URL ?>/index.php?page=books">
                        Xem tất cả
                    </a>
                </div>

                <div class="popular-book-list">
                    <?php if (!empty($popularBooks)): ?>
                        <?php foreach ($popularBooks as $index => $book): ?>
                            <div class="popular-book-item">
                                <div class="book-rank">
                                    <?= $index + 1 ?>
                                </div>

                                <div class="popular-book-info">
                                    <strong>
                                        <?= htmlspecialchars($book['title']) ?>
                                    </strong>

                                    <span>
                                        <?= htmlspecialchars($book['author_name']) ?>
                                    </span>
                                </div>

                                <div class="borrow-count">
                                    <strong>
                                        <?= number_format($book['borrow_count']) ?>
                                    </strong>

                                    <span>lượt mượn</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-data">
                            Chưa có dữ liệu.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TÌNH TRẠNG KHO -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div>
                        <h2>Tình trạng sách</h2>
                        <p>Thống kê số lượng bản sách</p>
                    </div>
                </div>

                <?php
                    $totalBooks = (int)($bookStats['total_books'] ?? 0);
                    $availableBooks = (int)($bookStats['available_books'] ?? 0);
                    $borrowedBooks = $totalBooks - $availableBooks;

                    $availablePercent = $totalBooks > 0
                        ? round(($availableBooks / $totalBooks) * 100)
                        : 0;

                    $borrowedPercent = $totalBooks > 0
                        ? round(($borrowedBooks / $totalBooks) * 100)
                        : 0;
                ?>

                <div class="stock-summary">
                    <div class="stock-total">
                        <strong>
                            <?= number_format($totalBooks) ?>
                        </strong>

                        <span>tổng số bản sách</span>
                    </div>

                    <div class="stock-progress">
                        <div class="progress-label">
                            <span>Sẵn sàng cho mượn</span>

                            <strong>
                                <?= number_format($availableBooks) ?>
                            </strong>
                        </div>

                        <div class="progress-bar">
                            <div
                                class="progress-fill available"
                                style="width: <?= $availablePercent ?>%;">
                            </div>
                        </div>

                        <small>
                            <?= $availablePercent ?>%
                        </small>
                    </div>

                    <div class="stock-progress">
                        <div class="progress-label">
                            <span>Đang được mượn</span>

                            <strong>
                                <?= number_format($borrowedBooks) ?>
                            </strong>
                        </div>

                        <div class="progress-bar">
                            <div
                                class="progress-fill borrowed"
                                style="width: <?= $borrowedPercent ?>%;">
                            </div>
                        </div>

                        <small>
                            <?= $borrowedPercent ?>%
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hoạt động gần đây -->
        <div class="dashboard-card recent-card">
            <div class="card-header">
                <div>
                    <h2>Hoạt động mượn sách gần đây</h2>
                    <p>Các phiếu mượn mới nhất trong hệ thống</p>
                </div>

                <a href="<?= BASE_URL ?>/index.php?page=borrow">
                    Xem tất cả
                </a>
            </div>

            <div class="table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Mã phiếu</th>
                            <th>Độc giả</th>
                            <th>Sách</th>
                            <th>Ngày mượn</th>
                            <th>Hạn trả</th>
                            <th>Thủ thư</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($recentBorrows)): ?>
                            <?php foreach ($recentBorrows as $borrow): ?>
                                <?php
                                    $isOverdue =
                                        $borrow['status'] === 'Borrowing'
                                        && strtotime($borrow['due_date']) < strtotime(date('Y-m-d'));
                                ?>

                                <tr>
                                    <td>
                                        <strong>
                                            #<?= $borrow['borrow_id'] ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <div class="reader-cell">

                                            <div class="reader-avatar">
                                                <?= strtoupper(
                                                    mb_substr(
                                                        $borrow['reader_name'],
                                                        0,
                                                        1
                                                    )
                                                ) ?>
                                            </div>

                                            <div>
                                                <strong>
                                                    <?= htmlspecialchars($borrow['reader_name']) ?>
                                                </strong>

                                                <span>
                                                    <?= htmlspecialchars($borrow['reader_code']) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="book-name">
                                            <?= htmlspecialchars($borrow['book_names']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($borrow['borrow_date'])
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($borrow['due_date'])
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($borrow['staff_name']) ?>
                                    </td>

                                    <td>
                                        <?php if ($borrow['status'] === 'Returned'): ?>
                                            <span class="status-badge returned">
                                                Đã trả
                                            </span>
                                        <?php elseif ($isOverdue): ?>
                                            <span class="status-badge overdue">
                                                Quá hạn
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge borrowing">
                                                Đang mượn
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="empty-table">
                                    Chưa có dữ liệu mượn sách.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Đánh giá + Tiền phạt -->
        <div class="dashboard-content-grid">
            <!-- ĐÁNH GIÁ -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div>
                        <h2>Đánh giá sách</h2>
                        <p>Tổng quan đánh giá từ độc giả</p>
                    </div>
                </div>

                <div class="review-summary">
                    <div class="rating-number">
                        <strong>
                            <?= number_format(
                                (float)($reviewStatistics['average_rating'] ?? 0),
                                1
                            ) ?>
                        </strong>

                        <div class="rating-stars">
                            ★★★★★
                        </div>

                        <span>
                            <?= number_format(
                                $reviewStatistics['total_reviews'] ?? 0
                            ) ?>
                            lượt đánh giá
                        </span>
                    </div>

                    <div class="rating-bars">
                        <?php
                        $ratings = [
                            5 => $reviewStatistics['five_star'] ?? 0,
                            4 => $reviewStatistics['four_star'] ?? 0,
                            3 => $reviewStatistics['three_star'] ?? 0,
                            2 => $reviewStatistics['two_star'] ?? 0,
                            1 => $reviewStatistics['one_star'] ?? 0
                        ];

                        $totalReviews = (int)($reviewStatistics['total_reviews'] ?? 0);
                        ?>

                        <?php foreach ($ratings as $star => $count): ?>
                            <?php
                            $percent = $totalReviews > 0
                                ? round(($count / $totalReviews) * 100)
                                : 0;
                            ?>

                            <div class="rating-row">
                                <span><?= $star ?> ★</span>

                                <div class="rating-progress">
                                    <div
                                        style="width: <?= $percent ?>%;">
                                    </div>
                                </div>

                                <small><?= $count ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- TIỀN PHẠT -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div>
                        <h2>Thống kê tiền phạt</h2>
                        <p>Phân loại theo nguyên nhân</p>
                    </div>
                </div>

                <div class="fine-summary">
                    <div class="fine-total">
                        <span>Tổng tiền phạt</span>

                        <strong>
                            <?= number_format(
                                $fineStatistics['total_fine'] ?? 0
                            ) ?>đ
                        </strong>
                    </div>

                    <div class="fine-row">
                        <div>
                            <i class="bi bi-clock"></i>
                            Quá hạn
                        </div>

                        <strong>
                            <?= number_format(
                                $fineStatistics['overdue_fine'] ?? 0
                            ) ?>đ
                        </strong>
                    </div>

                    <div class="fine-row">
                        <div>
                            <i class="bi bi-exclamation-triangle"></i>
                            Hư hỏng
                        </div>

                        <strong>
                            <?= number_format(
                                $fineStatistics['damaged_fine'] ?? 0
                            ) ?>đ
                        </strong>
                    </div>

                    <div class="fine-row">
                        <div>
                            <i class="bi bi-x-circle"></i>
                            Làm mất
                        </div>

                        <strong>
                            <?= number_format(
                                $fineStatistics['lost_fine'] ?? 0
                            ) ?>đ
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Lấy dữ liệu PHP và chuyển thành JavaScript bằng json_encode()
        // Giữ nguyên tiếng Việt, không mã hóa thành \u...
        const borrowReturnData = <?= json_encode($borrowReturnStatistics, JSON_UNESCAPED_UNICODE) ?>;
    </script>

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/admin/dashboard.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>
</body>
</html>