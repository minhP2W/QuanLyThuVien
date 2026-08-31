<!-- điều khiển trang thông báo của độc giả -->
<?php
    require_once __DIR__ . '/ReaderAuthController.php';
    
    require_once __DIR__ . '/../BaseController.php';

    require_once __DIR__ . '/../../models/Notification.php';

    class NotificationReaderController extends BaseReaderController
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

            // Dữ liệu dùng cho navbar và sidebar
            $navbarData = self::getNavbarData();
            $notifications = $navbarData['notifications'];
            $hasUnreadNotification = $navbarData['hasUnreadNotification'];
            $unreadNotificationCount = $navbarData['unreadNotificationCount'];

            // Filter thông báo
            $status = $_GET['status'] ?? 'all';

            if (!in_array($status, ['all', 'unread', 'read'])) {
                $status = 'all';
            }

            // Nếu đã đăng nhập thì lấy danh sách thông báo
            if ($readerId !== null) {

                // Lấy danh sách trước khi đánh dấu đã đọc
                $notifications = Notification::getAllByReader(
                    $readerId,
                    $status
                );
            }

            require __DIR__ . '/../../../../frontend/reader/notification_reader.php';
        }
    }
?>