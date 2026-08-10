<!-- Trang đăng ký cho độc giả -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librio - Đăng ký</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/register.css">
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-logo">
                <img src="<?= BASE_URL ?>/frontend/assets/images/logo.png" alt="Librio">
            </div>

            <h2>Đăng ký</h2>

            <p>Dành cho Độc giả</p>

            <div class="required-note">
                <span>*</span> là thông tin bắt buộc
            </div>

            <form action="<?= BASE_URL ?>/index.php?page=register" method="POST">
                <div class="form-grid">
                    <!-- Họ tên -->
                    <div class="form-group">
                        <label>
                            Họ và tên
                            <span class="required">*</span>
                        </label>

                        <div class="input-box">
                            <i class="bi bi-person"></i>
                            <input
                                type="text"
                                name="full_name"
                                placeholder="Nhập họ và tên"
                                required
                            >
                        </div>
                    </div>

                    <!-- Giới tính -->
                    <div class="form-group">
                        <label>
                            Giới tính
                            <span class="required">*</span>
                        </label>

                        <div class="input-box">
                            <i class="bi bi-gender-ambiguous"></i>

                            <select name="gender" required>
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Male">Nam</option>
                                <option value="Female">Nữ</option>
                                <option value="Other">Khác</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ngày sinh -->
                    <div class="form-group">
                        <label>Ngày sinh</label>

                        <div class="input-box">
                            <i class="bi bi-calendar-event"></i>
                            <input type="date" name="birthday">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label>
                            Email
                            <span class="required">*</span>
                        </label>

                        <div class="input-box">
                            <i class="bi bi-envelope"></i>
                            <input
                                type="email"
                                name="email"
                                placeholder="Nhập email"
                                required
                            >
                        </div>
                    </div>

                    <!-- Điện thoại -->
                    <div class="form-group">
                        <label>
                            Số điện thoại
                            <span class="required">*</span>
                        </label>

                        <div class="input-box">
                            <i class="bi bi-telephone"></i>
                            <input
                                type="text"
                                name="phone"
                                placeholder="Nhập số điện thoại"
                                required
                            >
                        </div>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="form-group">
                        <label>Địa chỉ</label>

                        <div class="input-box">
                            <i class="bi bi-geo-alt"></i>
                            <input
                                type="text"
                                name="address"
                                placeholder="Nhập địa chỉ"
                            >
                        </div>
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="form-group">
                    <label>
                        Mật khẩu
                        <span class="required">*</span>
                    </label>

                    <div class="input-box">
                        <i class="bi bi-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Nhập mật khẩu"
                            required
                        >

                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" class="register-btn">
                    Đăng ký
                </button>

                <div class="register-option">
                    <span>Đã có tài khoản?</span>
                    <a href="<?= BASE_URL ?>/index.php?page=login_reader">
                        Đăng nhập ngay
                    </a>
                </div>

            </form>

        </div>
    </div>

    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/register.js"></script>
</body>
</html>