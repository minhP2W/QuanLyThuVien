<!-- điều khiển trang quản lý thông báo cho thủ thư -->
<?php
    class NotificationAdminController
    {
        public static function notification()
        {
            $page = 'notification_admin';
            require_once __DIR__ . '/../../../../frontend/admin/notification_admin.php';
        }
    }
?>