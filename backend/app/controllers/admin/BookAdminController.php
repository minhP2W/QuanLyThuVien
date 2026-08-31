<!-- điều khiển trang quản lý sách cho thủ thư -->
<?php
    class BookAdminController
    {
        public static function manageBook()
        {
            $page = 'manageBook';
            require_once __DIR__ . '/../../../../frontend/admin/manageBook.php';
        }
    }
?>