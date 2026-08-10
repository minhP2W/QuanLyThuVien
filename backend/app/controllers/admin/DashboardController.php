<!-- điều khiển trang chủ của Admin/Thủ thư -->
<?php
    require_once __DIR__ . '/AdminAuthController.php';

    class DashboardController // extends BaseController
    {
        public static function index()
        {
            $page = 'dashboard';
            $role = $_SESSION['admin']['role'];
            require __DIR__ . '/../../../../frontend/admin/dashboard.php';
        }
    }
?>