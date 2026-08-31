<!-- điều khiển trang lập phiếu mượn sách, tiền phạt cho thủ thư -->
<?php
    class ReturnAdminController
    {
        public static function return_admin()
        {
            $page = 'return_admin';
            require_once __DIR__ . '/../../../../frontend/admin/return_admin.php';
        }
    }
?>