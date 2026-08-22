<!-- điều khiển trang chủ của độc giả -->
<?php
    require_once __DIR__ . '/ReaderAuthController.php';

    require_once __DIR__ . '/../../models/SearchHistory.php';
    require_once __DIR__ . '/../../models/Book.php';
    require_once __DIR__ . '/../../models/Category.php';

    require_once __DIR__ . '/../BaseController.php';

    class HomeController extends BaseReaderController
    {
        // Trang chủ của độc giả
        public static function index()
        {
            $page = 'home';
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

            // Lấy dữ liệu trang chủ
            $searchHistories = SearchHistory::getByReader($readerId);
            $newBooks        = Book::getNewBooks(5);
            $featuredBooks   = Book::getFeaturedBooks(5);
            $categories      = Category::getCategoriesWithBookCount(5);

            require __DIR__ . '/../../../../frontend/reader/home.php';
        }

        // Trang giới thiệu của độc giả
        public static function about()
        {
            $page = 'about';
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

            require __DIR__ . '/../../../../frontend/reader/about.php';
        }
    }
?>