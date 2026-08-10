<!-- Phân quyền quản trị viên & thủ thư -->
<?php
    class RoleMiddleware
    {
        public static function check($roles)
        {
            // Chưa có phiên SESSION thì phải đăng nhập
            if (!isset($_SESSION['admin'])) {
                header("Location: " . BASE_URL . "/index.php?page=login_admin");
                exit;
            }

            $roles = (array) $roles;
            
            // Không có quyền truy cập nếu không được cấp quyền
            if (!in_array($_SESSION['admin']['role'] ?? '', $roles, true)) {
                header("Location: " . BASE_URL . "/index.php?page=403_error");
                exit;
            }
        }
    }
?>