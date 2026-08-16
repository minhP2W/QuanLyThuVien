<!-- điều khiển trang chủ của Admin/Thủ thư -->
<?php
    require_once __DIR__ . '/AdminAuthController.php';

    require_once __DIR__ . '/../../models/Book.php';
    require_once __DIR__ . '/../../models/Reader.php';
    require_once __DIR__ . '/../../models/Borrow.php';
    require_once __DIR__ . '/../../models/Fine.php';
    require_once __DIR__ . '/../../models/Reservation.php';
    require_once __DIR__ . '/../../models/Review.php';

    class DashboardController // extends BaseController
    {
        public static function index()
        {
            // Thống kê
            $bookStats = Book::getDashboardStats();
            $totalReaders = Reader::getTotalActiveReaders();
            $borrowStats = Borrow::getDashboardStats();
            $fineStats = Fine::getDashboardStats();

            // Biểu đồ + việc cần xử lý
            $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
            $borrowReturnStatistics = Borrow::getBorrowReturnStatistics($year);

            $conditionStats = Fine::getConditionStats();
            $pendingTasks = [
                'overdue_count' =>
                    $borrowStats['overdue_slips'] ?? 0,

                'reservation_count' =>
                    Reservation::getPendingCount(),

                'out_of_stock_count' =>
                    Book::getOutOfStockCount(),

                'damaged_count' =>
                    $conditionStats['damaged_count'] ?? 0,

                'lost_count' =>
                    $conditionStats['lost_count'] ?? 0
            ];

            // Sách mượn nhiều
            $popularBooks = Borrow::getPopularBooks(5);

            // Hoạt động gần đây
            $recentBorrows = Borrow::getRecentBorrows(5);

            // Đánh giá + tiền phạt
            $reviewStatistics = Review::getDashboardStats();
            
            $fineStatistics = Fine::getDashboardStats();

            $page = 'dashboard';
            $role = $_SESSION['admin']['role'];
            require __DIR__ . '/../../../../frontend/admin/dashboard.php';
        }
    }
?>