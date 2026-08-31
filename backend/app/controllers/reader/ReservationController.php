<!-- điều khiển trang đặt trước sách của độc giả -->
<?php
    class ReservationController extends BaseReaderController
    {
        public static function reservation()
        {
            $page = 'reservation';
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

            require __DIR__ . '/../../../../frontend/reader/reservation.php';
        }
    }
?>