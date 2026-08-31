<!-- điều khiển trang quản lý độc giả cho quản trị viên/thủ thư -->
<?php
    class ReaderController
    {
        public static function manageReader()
        {
            $page = 'manageReader';
            require_once __DIR__ . '/../../../../frontend/admin/manageReader.php';
        }
    }
?>