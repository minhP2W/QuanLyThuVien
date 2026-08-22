<!-- Controller cơ sở, chứa các hàm dùng chung -->
<?php
    require_once __DIR__ . '/../models/Notification.php';

    class BaseReaderController
    {
        // Lấy dữ liệu thông báo cho navbar và sidebar của độc giả
        protected static function getNavbarData()
        {
            $readerId = $_SESSION['reader']['reader_id'] ?? null;

            $notificationData = Notification::getNavbarData($readerId);

            return [
                'notifications' => $notificationData['notifications'],
                'hasUnreadNotification' => $notificationData['hasUnreadNotification'],
                'unreadNotificationCount' => $notificationData['unreadNotificationCount']
            ];
        }
    }
?>