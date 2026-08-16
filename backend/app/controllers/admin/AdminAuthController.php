<!-- Xử lý đăng ký, đăng nhập, đăng xuất, quản lý mật khẩu, hiển thị và cập nhật thông tin cho quản trị viên/thủ thư -->
<?php
    require_once __DIR__ . '/../../models/User.php';

    class AdminAuthController // extends BaseController
    {
        // Đăng nhập tài khoản quản trị viên/thủ thư
        public static function login()
        {
            // Đã đăng nhập thì không được vào lại trang đăng nhập
            if (isset($_SESSION['admin'])) {
                header("Location: " . BASE_URL . "/index.php?page=dashboard");
                exit;
            }
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = trim($_POST['username'] ?? '');
                $password = trim($_POST['password'] ?? '');
                $user = User::findByUsername($username);
                
                // Cho phép đăng nhập khi thông tin đăng nhập đúng
                if ($user && password_verify($password, $user['password'])) {
                    unset($_SESSION['reader']);

                    $_SESSION['admin'] = [
                        'user_id' => $user['user_id'],
                        'username' => $user['username'],
                        'full_name' => $user['full_name'],
                        'role' => $user['role']
                    ];

                    $_SESSION['success'] = "Đăng nhập thành công!";
                    header("Location: index.php?page=dashboard");
                    exit;
                }

                // Báo lỗi khi sai thông tin đăng nhập
                $_SESSION['error'] = "Sai tên đăng nhập hoặc mật khẩu, vui lòng nhập lại!";
                header("Location: " . BASE_URL . "/index.php?page=login_admin");
                exit;
            }
            $page = 'login_admin';
            require __DIR__ . '/../../../../frontend/admin/login_admin.php';
        }

        // Đăng xuất tài khoản quản trị viên/thủ thư
        public static function logout()
        {
            unset($_SESSION['admin']);
            $_SESSION['success'] = "Đăng xuất thành công!";
            header("Location: " . BASE_URL . "/index.php?page=login_admin");
            exit;
        }

        // Lấy lại mật khẩu quản trị viên/thủ thư
        public static function forgotPassword()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = trim($_POST['username'] ?? '');
                $user = User::findByUsername($username);

                if ($user) {
                    // Đặt lại mật khẩu thành 123456
                    User::resetPassword(
                        $username,
                        password_hash('123456', PASSWORD_DEFAULT)
                    );

                    $_SESSION['showPassword'] = true;

                    header("Location: " . BASE_URL . "/index.php?page=forgotPassword_admin");
                    exit;
                }
                // Báo lỗi khi tên đăng nhập không tồn tại
                $_SESSION['error'] = "Tên đăng nhập không tồn tại.";

                header("Location: " . BASE_URL . "/index.php?page=forgotPassword_admin");
                exit;
            }
            // Lấy thông báo từ SESSION để hiển thị rồi xóa khỏi SESSION sau khi dùng
            $showPassword = $_SESSION['showPassword'] ?? false;
            unset($_SESSION['showPassword']);

            $error = $_SESSION['error'] ?? null;
            unset($_SESSION['error']);

            require_once __DIR__ . '/../../../../frontend/admin/forgotPassword_admin.php';
        }
    }
?>