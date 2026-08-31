<!-- điều khiển trang lập phiếu mượn sách, đặt trước sách cho thủ thư -->
<?php
    class BorrowAdminController
    {
        public static function borrow_admin()
        {
            $page = 'borrow_admin';
            require_once __DIR__ . '/../../../../frontend/admin/borrow_admin.php';
        }
    }
?>