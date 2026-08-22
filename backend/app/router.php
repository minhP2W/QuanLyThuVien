<!-- Điều hướng request đến Controller phù hợp. -->
<?php
    // middleware
    require_once __DIR__ . '/middleware/AuthMiddleware.php';
    require_once __DIR__ . '/middleware/RoleMiddleware.php';

    // errors
    require_once __DIR__ . '/controllers/ErrorController.php';

    // admin_controllers
    require_once __DIR__ . '/controllers/admin/AdminAuthController.php';
    require_once __DIR__ . '/controllers/admin/DashboardController.php';
    require_once __DIR__ . '/controllers/admin/AdminProfileController.php';

    // reader_controllers
    require_once __DIR__ . '/controllers/reader/ReaderAuthController.php';
    require_once __DIR__ . '/controllers/reader/HomeController.php';
    require_once __DIR__ . '/controllers/reader/ReaderProfileController.php';
    require_once __DIR__ . '/controllers/reader/NotificationController.php';
    require_once __DIR__ . '/controllers/reader/BookReaderController.php';

    // "bộ điều hướng" website
    $page = $_GET['page'] ?? 'home';

    // Nếu rời khỏi trang thông báo thì đánh dấu tất cả thông báo là đã đọc
    if (isset($_SESSION['reader']['reader_id']) && isset($_SESSION['current_page']) && $_SESSION['current_page'] === 'notification' &&
        $page !== 'notification'
    ) {
        Notification::markAllAsRead($_SESSION['reader']['reader_id']);
    }

    // Lưu trang hiện tại
    $_SESSION['current_page'] = $page;

    switch ($page) {
        // Admin + Staff
        case 'login_admin':
            AdminAuthController::login();
            break;

        case 'logout_admin':
            AdminAuthController::logout();
            break;

        case 'forgotPassword_admin':
            AdminAuthController::forgotPassword();
            break;

        case 'dashboard':
            AuthMiddleware::admin();
            RoleMiddleware::check(['admin', 'staff']);
            DashboardController::index();
            break;

        case 'changePassword_admin':
            AuthMiddleware::admin();
            RoleMiddleware::check(['admin', 'staff']);
            AdminProfileController::changePassword();
            break;

        case 'profile_admin':
            AuthMiddleware::admin();
            RoleMiddleware::check(['admin', 'staff']);
            AdminProfileController::profile();
            break;

        // Reader
        case 'home':
            HomeController::index();
            break;

        case 'register':
            ReaderAuthController::register();
            break;

        case 'login_reader':
            ReaderAuthController::login();
            break;

        case 'logout_reader':
            ReaderAuthController::logout();
            break;

        case 'forgotPassword_reader':
            ReaderAuthController::forgotPassword();
            break;

        case 'about':
            HomeController::about();
            break;

        case 'profile_reader':
            AuthMiddleware::reader();
            ReaderProfileController::profile();
            break;

        case 'changePassword_reader':
            AuthMiddleware::reader();
            ReaderProfileController::changePassword();
            break;

        case 'notification':
            AuthMiddleware::reader();
            NotificationController::notification();
            break;

        case 'book_reader':
            BookReaderController::book();
            break;

        case 'favorite':
            AuthMiddleware::reader();
            BookReaderController::favorite();
            break;

        case 'toggleFavorite':
            BookReaderController::toggleFavorite();
            break;

        case 'category_reader':
            BookReaderController::category();
            break;

        // Error
        case '401_error':
            ErrorController::error401();
            break;

        case '403_error':
            ErrorController::error403();
            break;

        case '404_error':
            ErrorController::error404();
            break;

        case '500_error':
            ErrorController::error500();
            break;

        // Mặc định
        default:
            ErrorController::error404();
            break;
    }
?>