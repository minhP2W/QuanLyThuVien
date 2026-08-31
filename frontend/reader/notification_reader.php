<!-- Trang thông báo cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/notification_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js"></script>

    <?php require_once 'sidebar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>

    <div class="notification-page">
        <!-- Tiêu đề -->
        <div class="notification-page-header">
            <div class="notification-page-title">
                <h2>Thông báo</h2>
            </div>

            <!-- Bộ lọc -->
            <div class="notification-filter">
                <a href="<?= BASE_URL ?>/index.php?page=notification_reader&status=all" class="<?= $status === 'all' ? 'active' : '' ?>">
                    Tất cả
                </a>

                <a href="<?= BASE_URL ?>/index.php?page=notification_reader&status=unread" class="<?= $status === 'unread' ? 'active' : '' ?>">
                    Chưa đọc
                </a>

                <a href="<?= BASE_URL ?>/index.php?page=notification_reader&status=read" class="<?= $status === 'read' ? 'active' : '' ?>">
                    Đã đọc
                </a>
            </div>
        </div>


        <!-- Danh sách -->
        <div class="notification-page-list">
            <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification-page-item 
                        <?= (int)$notification['is_read'] === 0 ? 'unread' : 'read' ?>">

                        <!-- Icon -->
                        <div class="notification-page-icon">
                            <i class="bi bi-bell"></i>
                        </div>

                        <!-- Nội dung -->
                        <div class="notification-page-content">
                            <h4>
                                <?= htmlspecialchars($notification['title']) ?>
                            </h4>

                            <p>
                                <?= htmlspecialchars($notification['content']) ?>
                            </p>

                            <span class="notification-page-time">
                                <?= date('d/m/Y H:i', strtotime($notification['created_at'])) ?>
                            </span>
                        </div>

                        <!-- Trạng thái -->
                        <div class="notification-status">
                            <?php if ((int)$notification['is_read'] === 0): ?>
                                <span class="unread-label">
                                    Chưa đọc
                                </span>
                            <?php else: ?>
                                <span class="read-label">
                                    Đã đọc
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Không có thông báo -->
                <div class="notification-page-empty">
                    <i class="bi bi-bell-slash"></i>

                    <h4>Không có thông báo</h4>

                    <p>
                        Hiện tại chưa có thông báo nào.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once 'footer.php';?>
</body>
</html>