<!-- Navbar cho độc giả -->
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
                <a href="#">
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

    <div class="reader-nav-right">
        <button type="button" class="reader-notification">
            <i class="bi bi-bell"></i>

            <span class="notification-dot"></span>
        </button>

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