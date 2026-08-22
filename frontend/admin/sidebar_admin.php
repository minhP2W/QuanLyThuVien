<!-- Sidebar cho quản trị viên/thủ thư -->
<aside class="admin-sidebar">
    <!-- Phần trên -->
    <div class="admin-sidebar-top">

        <!-- Logo -->
        <div class="admin-sidebar-logo">
            <a href="<?= BASE_URL ?>/index.php?page=dashboard">
                <img src="<?= BASE_URL ?>/frontend/assets/images/logo.png" alt="Librio Logo">
            </a>
        </div>

        <!-- Tên + quyền -->
        <div class="admin-user-info">
            <div class="admin-user-name">
                <?= htmlspecialchars($_SESSION['admin']['full_name']) ?>
            </div>

            <div class="admin-user-role">
                <?= $_SESSION['admin']['role'] === 'admin'
                        ? 'Quản trị viên'
                        : 'Thủ thư'; ?>
            </div>
        </div>

        <!-- Menu -->
        <ul class="admin-sidebar-menu">
            <!-- Chung -->
            <li>
                <a href="<?= BASE_URL ?>/index.php?page=dashboard" class="<?= ($page ?? '') == 'dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-people"></i>
                    <span>Quản lý độc giả</span>
                </a>
            </li>
            
            <!-- chức năng của admin -->
            <?php if ($_SESSION['admin']['role'] === 'admin'): ?>
                <li>
                    <a href="#">
                        <i class="bi bi-person-badge"></i>
                        <span>Quản lý thủ thư</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-person"></i>
                        <span>Tác giả</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-tags"></i>
                        <span>Thể loại</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-building"></i>
                        <span>Nhà xuất bản</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-bar-chart"></i>
                        <span>Thống kê</span>
                    </a>
                </li>

            <!-- chức năng của thủ thư -->
            <?php else: ?>
                <li>
                    <a href="#">
                        <i class="bi bi-book"></i>
                        <span>Quản lý sách</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-journal-plus"></i>
                        <span>Phiếu mượn</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-journal-check"></i>
                        <span>Phiếu trả</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-cash-coin"></i>
                        <span>Tiền phạt</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="bi bi-bell"></i>
                        <span>Thông báo</span>
                    </a>
                </li>

            <!-- Chung -->
            <?php endif; ?>
            <li>
                <a href="<?= BASE_URL ?>/index.php?page=profile_admin" class="<?= ($page ?? '') == 'profile_admin' ? 'active' : '' ?>">
                    <i class="bi bi-person-circle"></i>
                    <span>Hồ sơ cá nhân</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Phần dưới -->
    <div class="admin-sidebar-footer">
        <div class="admin-sidebar-bottom">
            <a href="#" id="logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
            </a>
        </div>

        <div class="admin-sidebar-version">
            Librio v1.0 &copy; <?= date('Y') ?>
        </div>
    </div>
</aside>

<!-- Thông báo xác nhận đăng xuất -->
<div id="logout-modal" class="logout-modal">
    <div class="logout-modal-content">
        <div class="logout-modal-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>

        <h3>Xác nhận đăng xuất</h3>

        <p>Bạn có chắc chắn muốn đăng xuất không?</p>

        <div class="logout-modal-actions">
            <a href="<?= BASE_URL ?>/index.php?page=logout_admin" id="logout-confirm">
                Có
            </a>

            <button type="button" id="logout-cancel">
                Không
            </button>
        </div>
    </div>
</div>