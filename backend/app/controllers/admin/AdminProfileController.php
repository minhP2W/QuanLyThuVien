<!-- Xử lý quản lý mật khẩu, hiển thị và cập nhật thông tin cho quản trị viên/thủ thư -->
<?php
    require_once __DIR__ . '/../../models/User.php';

    class AdminProfileController // extends BaseController
    {
        // Hiển thị và cập nhật thông tin cá nhân độc giả
        public static function profile()
        {
            $user_id = $_SESSION['admin']['user_id'];
            $user = User::findById($user_id);

            $currentUser = User::findById($_SESSION['admin']['user_id']);
            $currentFull_name = $currentUser['full_name'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $full_name = trim($_POST['full_name']);

                // Không có thay đổi thông tin
                if ($full_name === $currentFull_name) {
                    $error = "Không có sự thay đổi thông tin.";
                }
                // Cập nhật thông tin
                else {
                    User::updateProfile(
                        $user_id,
                        $full_name
                    );

                    $_SESSION['admin']['full_name'] = $full_name;
                    $_SESSION['success'] = "Cập nhật thông tin thành công!";

                    header("Location: " . BASE_URL . "/index.php?page=profile_admin");
                    exit;
                }
            }
            $page = "profile_admin";
            require __DIR__ . "/../../../../frontend/admin/profile_admin.php";
        }

        // Thay đổi mật khẩu tài khoản quản trị viên/thủ thư
        public static function changePassword()
        {
            $user = User::findById($_SESSION['admin']['user_id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $oldPassword = trim($_POST['old_password']);
                $newPassword = trim($_POST['new_password']);
                $confirmPassword = trim($_POST['confirm_password']);

                // Kiểm tra mật khẩu cũ
                if (!password_verify($oldPassword, $user['password'])) {
                    $error = "Mật khẩu hiện tại không chính xác.";

                    require_once __DIR__ . '/../../../../frontend/admin/changePassword_admin.php';
                    return;
                }

                // Kiểm tra xác nhận mật khẩu
                if ($newPassword !== $confirmPassword) {
                    $error = "Mật khẩu mới và xác nhận mật khẩu không khớp.";

                    require_once __DIR__ . '/../../../../frontend/admin/changePassword_admin.php';
                    return;
                }

                // Không cho trùng mật khẩu cũ
                if (password_verify($newPassword, $user['password'])) {
                    $error = "Mật khẩu mới phải khác mật khẩu hiện tại.";

                    require_once __DIR__ . '/../../../../frontend/admin/changePassword_admin.php';
                    return;
                }

                // Mã hóa mật khẩu mới
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Cập nhật CSDL
                User::changePassword(
                    $_SESSION['admin']['user_id'],
                    $hashedPassword
                );

                $_SESSION['success'] = "Đổi mật khẩu thành công!";

                header("Location: " . BASE_URL . "/index.php?page=profile_admin");
                exit;
            }

            require_once __DIR__ . '/../../../../frontend/admin/changePassword_admin.php';
        }
    }
?>