<!-- điều khiển trang chủ của Reader -->
<?php
    require_once __DIR__ . '/ReaderAuthController.php';

    require_once __DIR__ . '/BaseReaderController.php';

    class NotificationController extends BaseReaderController
    {
        // Trang thông báo của độc giả
        public static function notification()
        {
            $page = 'notification';
            $readerId = $_SESSION['reader']['reader_id'] ?? null;

            // Hiển thị cảnh báo khi chưa đăng nhập nhưng nhấn nút thông báo
            if ($readerId === null && isset($_GET['notification']) && $_GET['notification'] === 'login_required') 
            {
                $_SESSION['warning'] = 'Vui lòng đăng nhập trước khi sử dụng chức năng này.';
            }

            $navbarData = self::getNavbarData();
            $notifications = $navbarData['notifications'];
            $hasUnreadNotification = $navbarData['hasUnreadNotification'];
            $unreadNotificationCount = $navbarData['unreadNotificationCount'];

            require __DIR__ . '/../../../../frontend/reader/notification.php';
        }
    }
?>