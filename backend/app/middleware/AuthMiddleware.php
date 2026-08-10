<!-- Kiểm tra đăng nhập -->
<?php
    class AuthMiddleware
    {
        // Kiểm tra đăng nhập Admin hoặc Thủ thư
        public static function admin()
        {
            if (!isset($_SESSION['admin'])) {
                $_SESSION['warning'] = "Vui lòng đăng nhập để tiếp tục.";
                header("Location: " . BASE_URL . "/index.php?page=login_admin");
                exit;
            }
        }

        // Kiểm tra đăng nhập Độc giả
        public static function reader()
        {
            if (!isset($_SESSION['reader'])) {
                $_SESSION['warning'] = "Vui lòng đăng nhập để sử dụng chức năng này.";
                header("Location: " . BASE_URL . "/index.php?page=home");
                exit;
            }
        }
    }
?>