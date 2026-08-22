<!-- Trang hiển thị và chỉnh sửa hồ sơ cá nhân cho quản trị viên/thủ thư -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/sidebar_admin.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/admin/profile_admin.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
</head>
<body>
    <?php require_once 'sidebar_admin.php';?>

    <div class="profile-container">
        <div class="profile-header">
            <h2 id="profile-title">Hồ sơ cá nhân</h2>
        </div>

        <!-- Hiển thị lỗi trùng thông tin -->
        <?php if(isset($error)): ?>
            <div class="alert-error">
                <i class="bi bi-x-circle-fill"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Hiển thị thông báo cập nhật thông tin thành công -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert-success" id="alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span><?= $_SESSION['success'] ?></span>
            </div>

            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <!-- Hiển thị hồ sơ cá nhân quản trị viên/thủ thư -->
        <div class="profile-card" id="profile-view">
            <div class="profile-row">
                <span>Họ và tên</span>
                <strong><?= htmlspecialchars($user['full_name']) ?></strong>
            </div>

            <div class="profile-row">
                <span>Tên người dùng</span>
                <strong><?= htmlspecialchars($user['username']) ?></strong>
            </div>

            <div class="profile-row">
                <span>Vai trò</span>
                <strong>
                    <?=
                        $user['role'] === 'admin' ? 'Quản trị viên' : 'Thủ thư'
                    ?>
                </strong>
            </div>
        </div>

        <div class="profile-actions" id="view-actions">
            <button type="button" id="edit-profile-btn" class="btn-primary">
                Chỉnh sửa thông tin
            </button>

            <a href="<?= BASE_URL ?>/index.php?page=changePassword_admin" class="btn-secondary" id="change-password-btn">
                Đổi mật khẩu
            </a>
        </div>

        <!-- Cập nhật thông tin cá nhân quản trị viên/thủ thư -->
        <form id="edit-profile-form" class="profile-card profile-edit-form" method="POST" action="<?= BASE_URL ?>/index.php?page=profile_admin">
            <div class="profile-row">
                <span>Họ và tên</span>
                <input
                    type="text"
                    name="full_name"
                    value="<?= htmlspecialchars($user['full_name']) ?>">
            </div>

            <div class="profile-row">
                <span>Tên người dùng</span>
                <input
                    type="text"
                    value="<?= htmlspecialchars($user['username']) ?>"
                    readonly>
            </div>

            <div class="profile-row">
                <span>Vai trò</span>
                <select disabled>
                    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Quản trị viên</option>
                    <option value="staff" <?= $user['role']=='staff'?'selected':'' ?>>Thủ thư</option>
                </select>
            </div>

            <div class="profile-actions">
                <button type="submit" class="btn-primary">
                    Lưu thay đổi
                </button>

                <button type="button" id="cancel-edit" class="btn-secondary">
                    Hủy
                </button>
            </div>
        </form>
    </div>

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/profile.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>
</body>
</html>