<!-- Navbar cho độc giả -->
<?php
    // Đảm bảo các biến thông báo luôn có giá trị mặc định và kiểm tra độc giả đã đăng nhập hay chưa
    $notifications = $notifications ?? [];
    $hasUnreadNotification = $hasUnreadNotification ?? false;

    $isReaderLoggedIn = isset($_SESSION['reader']);
?>

<nav class="reader-navbar">
    <div class="reader-nav-left">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>/index.php?page=home" class="reader-logo">
            <img src="<?= BASE_URL ?>/frontend/assets/images/logo.png" alt="Librio Logo">
        </a>

        <!-- Menu -->
        <ul class="reader-nav-menu">
            <li>
                <a href="<?= BASE_URL ?>/index.php?page=home" class="<?= ($page ?? '') == 'home' ? 'active' : '' ?>">
                    <i class="bi bi-house"></i>
                    <span>Trang chủ</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-book"></i>
                    <span>Sách</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-grid"></i>
                    <span>Thể loại</span>
                </a>
            </li>

            <li>
                <a href="<?= BASE_URL ?>/index.php?page=notification" 
                   class="reader-login-required <?= ($page ?? '') == 'notification' ? 'active' : '' ?>">
                    <i class="bi bi-bell"></i>
                    <span>Thông báo</span>
                </a>
            </li>

            <li>
                <a href="<?= BASE_URL ?>/index.php?page=about" class="<?= ($page ?? '') == 'about' ? 'active' : '' ?>">
                    <i class="bi bi-info-circle"></i>
                    <span>Giới thiệu</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Hiển thị thông báo -->
    <div class="reader-nav-right">
        <div class="reader-notification-wrapper">
            <button type="button" class="reader-notification" id="reader-notification-btn"
                    data-logged-in="<?= $isReaderLoggedIn ? 'true' : 'false' ?>"
                    data-home-url="<?= BASE_URL ?>/index.php?page=home">
                <i class="bi bi-bell"></i>

                <?php if ($isReaderLoggedIn && $hasUnreadNotification): ?>
                    <span class="notification-dot"></span>
                <?php endif; ?>
            </button>

            <!-- Dropdown thông báo -->
            <div class="reader-notification-dropdown" id="reader-notification-dropdown">
                <div class="reader-notification-header">
                    <h4>Thông báo</h4>
                </div>

                <div class="reader-notification-list">
                    <?php if (empty($notifications)): ?>
                        <div class="notification-empty">
                            <i class="bi bi-bell-slash"></i>
                            <p>Không có thông báo</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($notifications as $notification): ?>
                            <div class="notification-item
                                <?= (int)$notification['is_read'] === 0
                                    ? 'unread'
                                    : 'read' ?>">

                                <div class="notification-icon">
                                    <i class="bi bi-bell"></i>
                                </div>

                                <div class="notification-content">
                                    <h5>
                                        <?= htmlspecialchars($notification['title']) ?>
                                    </h5>

                                    <p>
                                        <?= htmlspecialchars($notification['content']) ?>
                                    </p>

                                    <span class="notification-time">
                                        <?= date(
                                            'd/m/Y H:i',
                                            strtotime($notification['created_at'])
                                        ) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Xem tất cả -->
                <?php if ($isReaderLoggedIn): ?>
                    <div class="notification-view-all">
                        <a href="<?= BASE_URL ?>/index.php?page=notification">
                            Xem tất cả
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Hiển thị thông tin độc giả -->
        <?php if (isset($_SESSION['reader'])): ?>
            <div class="reader-user-wrapper">
                <button type="button" class="reader-user" id="reader-user-btn">
                    <i class="bi bi-person-circle"></i>
                    <span><?= htmlspecialchars($_SESSION['reader']['full_name']) ?></span>
                    <i class="bi bi-chevron-down"></i>
                </button>

                <div class="reader-profile-dropdown" id="reader-profile-dropdown">
                    <div class="reader-dropdown-card">
                        <div class="reader-dropdown-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>

                        <div class="reader-dropdown-info">
                            <h4><?= htmlspecialchars($_SESSION['reader']['full_name']) ?></h4>

                            <span class="reader-dropdown-role">Độc giả</span>

                            <p>
                                <strong>Mã độc giả:</strong>
                                <?= htmlspecialchars($_SESSION['reader']['reader_code']) ?>
                            </p>

                            <p>
                                <strong>Ngày tham gia:</strong>
                                <?= date('d/m/Y', strtotime($_SESSION['reader']['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/index.php?page=login_reader" class="reader-login">
                Đăng nhập
            </a>
        <?php endif; ?>
    </div>
</nav>