<!-- điều khiển trang quản lý thủ thư cho quản trị viên -->
<?php
    class StaffAdminController
    {
        public static function manageStaff()
        {
            $page = 'manageStaff';
            require_once __DIR__ . '/../../../../frontend/admin/manageStaff.php';
        }
    }
?>