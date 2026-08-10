<!-- Trang hiển thị và chỉnh sửa hồ sơ cá nhân cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Hồ sơ cá nhân</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar_reader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer_reader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/profile_reader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css">
</head>
<body>
    <?php require_once 'navbar_reader.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/navbar_reader.js"></script>

    <?php require_once 'sidebar_reader.php';?>

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
        
        <!-- Hiển thị hồ sơ cá nhân độc giả -->
        <div class="profile-card" id="profile-view">
            <div class="profile-row">
                <span>Họ và tên</span>
                <strong><?= htmlspecialchars($reader['full_name']) ?></strong>
            </div>

            <div class="profile-row">
                <span>Mã độc giả</span>
                <strong><?= htmlspecialchars($reader['reader_code']) ?></strong>
            </div>

            <div class="profile-row">
                <span>Giới tính</span>
                <strong>
                    <?=
                        $reader['gender'] === 'Male' ? 'Nam' :
                        ($reader['gender'] === 'Female' ? 'Nữ' : 'Khác')
                    ?>
                </strong>
            </div>

            <div class="profile-row">
                <span>Ngày sinh</span>
                <strong>
                    <?= !empty($reader['birth_date'])
                        ? date('d/m/Y', strtotime($reader['birth_date']))
                        : 'Chưa cập nhật'
                    ?>
                </strong>
            </div>

            <div class="profile-row">
                <span>Email</span>
                <strong><?= htmlspecialchars($reader['email']) ?></strong>
            </div>

            <div class="profile-row">
                <span>Số điện thoại</span>
                <strong><?= htmlspecialchars($reader['phone']) ?></strong>
            </div>

            <div class="profile-row">
                <span>Địa chỉ</span>
                <strong><?= $reader['address'] ?: 'Chưa cập nhật' ?></strong>
            </div>
        </div>

        <div class="profile-actions" id="view-actions">
            <button type="button" id="edit-profile-btn" class="btn-primary">
                Chỉnh sửa thông tin
            </button>

            <a href="<?= BASE_URL ?>/index.php?page=changePassword_reader" class="btn-secondary" id="change-password-btn">
                Đổi mật khẩu
            </a>
        </div>

        <!-- Cập nhật thông tin cá nhân độc giả -->
        <form id="edit-profile-form" class="profile-card profile-edit-form" method="POST" action="<?= BASE_URL ?>/index.php?page=profile_reader">
            <div class="profile-row">
                <span>Họ và tên</span>
                <input
                    type="text"
                    value="<?= htmlspecialchars($reader['full_name']) ?>"
                    readonly>
            </div>

            <div class="profile-row">
                <span>Mã độc giả</span>
                <input
                    type="text"
                    value="<?= htmlspecialchars($reader['reader_code']) ?>"
                    readonly>
            </div>

            <div class="profile-row">
                <span>Giới tính</span>
                <select disabled>
                    <option value="Male" <?= $reader['gender']=='Male'?'selected':'' ?>>Nam</option>
                    <option value="Female" <?= $reader['gender']=='Female'?'selected':'' ?>>Nữ</option>
                    <option value="Other" <?= $reader['gender']=='Other'?'selected':'' ?>>Khác</option>
                </select>
            </div>

            <div class="profile-row">
                <span>Ngày sinh</span>
                <input
                    type="date"
                    value="<?= $reader['birth_date'] ?>"
                    disabled>
            </div>

            <div class="profile-row">
                <span>Email</span>
                <input
                    type="email"
                    name="email"
                    value="<?= htmlspecialchars($reader['email']) ?>">
            </div>

            <div class="profile-row">
                <span>Số điện thoại</span>
                <input
                    type="text"
                    name="phone"
                    value="<?= htmlspecialchars($reader['phone']) ?>">
            </div>

            <div class="profile-row">
                <span>Địa chỉ</span>
                <input
                    type="text"
                    name="address"
                    value="<?= htmlspecialchars($reader['address']) ?>">
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

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/profile.js"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js"></script>

    <?php require_once 'footer_reader.php';?>
</body>
</html>