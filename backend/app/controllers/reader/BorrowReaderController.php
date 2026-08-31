<!-- điều khiển trang sách của tôi, lịch sử mượn của độc giả -->
<?php
    require_once __DIR__ . '/../../models/Borrow.php';

    class BorrowReaderController extends BaseReaderController
    {
        // Hiển thị trang sách của tôi cho độc giả
        public static function myBook()
        {
            $page = 'myBook';
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

            $borrowModel = new Borrow();

            $myBooks = $borrowModel->getMyBorrowedBooks($readerId);

            require __DIR__ . '/../../../../frontend/reader/myBook.php';
        }

        // Hiển trị trang lịch sử mượn cho độc giả
        public static function borrowHistory()
        {
            $page = 'borrowHistory';
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

            $borrowModel = new Borrow();

            $borrowHistory = $borrowModel->getBorrowHistory($readerId);

            require __DIR__ . '/../../../../frontend/reader/borrowHistory.php';
        }
    }
?>