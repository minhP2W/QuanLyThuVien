<!-- Sidebar cho độc giả -->
<aside class="reader-sidebar" data-logged-in="<?= isset($_SESSION['reader']) ? 'true' : 'false' ?>">
    <!-- Phần trên -->
    <ul class="reader-sidebar-menu">
        <li>
            <a href="<?= BASE_URL ?>/index.php?page=home" class="<?= ($page ?? '') == 'home' ? 'active' : '' ?>">
                <i class="bi bi-house"></i>
                <span>Trang chủ</span>
            </a>
        </li>

        <li>
            <a href="#" class="reader-login-required">
                <i class="bi bi-book"></i>
                <span>Sách của tôi</span>
            </a>
        </li>

        <li>
            <a href="#" class="reader-login-required">
                <i class="bi bi-clock-history"></i>
                <span>Lịch sử mượn</span>
            </a>
        </li>

        <li>
            <a href="#" class="reader-login-required">
                <i class="bi bi-journal-plus"></i>
                <span>Đặt trước</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/index.php?page=favorite" 
               class="reader-login-required <?= ($page ?? '') == 'favorite' ? 'active' : '' ?>">
                <i class="bi bi-heart"></i>
                <span>Yêu thích</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/index.php?page=notification" 
               class="reader-login-required <?= ($page ?? '') == 'notification' ? 'active' : '' ?>">
                <i class="bi bi-bell"></i>
                <span>Thông báo</span>

                <?php if ($unreadNotificationCount > 0): ?>
                    <span class="badge"><?= $unreadNotificationCount ?></span>
                <?php endif; ?>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/index.php?page=profile_reader" 
               class="reader-login-required <?= ($page ?? '') == 'profile_reader' ? 'active' : '' ?>">
                <i class="bi bi-person"></i>
                <span>Hồ sơ cá nhân</span>
            </a>
        </li>
    </ul>

    <!-- Phần dưới -->
    <?php if (isset($_SESSION['reader'])): ?>
        <div class="reader-sidebar-bottom">
            <a href="#" id="logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    <?php endif; ?>
</aside>

<!-- Thông báo xác nhận đăng xuất -->
<?php if (isset($_SESSION['reader'])): ?>
    <div id="logout-modal" class="logout-modal">
        <div class="logout-modal-content">
            <div class="logout-modal-icon">
                <i class="bi bi-box-arrow-right"></i>
            </div>

            <h3>Xác nhận đăng xuất</h3>

            <p>Bạn có chắc chắn muốn đăng xuất không?</p>

            <div class="logout-modal-actions">
                <a href="<?= BASE_URL ?>/index.php?page=logout_reader" id="logout-confirm">
                    Có
                </a>

                <button type="button" id="logout-cancel">
                    Không
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>