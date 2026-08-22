<!-- điều khiển trang sách của độc giả -->
<?php
    require_once __DIR__ . '/../BaseController.php';

    require_once __DIR__ . '/../../models/Category.php';
    require_once __DIR__ . '/../../models/Book.php';
    require_once __DIR__ . '/../../models/Favorite.php';
    require_once __DIR__ . '/../../models/SearchHistory.php';

    class BookReaderController extends BaseReaderController
    {
        // Hiển thị trang danh sách sách cho độc giả
        public static function book()
        {
            $readerId = $_SESSION['reader']['reader_id'] ?? null;

            $keyword = trim($_GET['keyword'] ?? '');
            
            // Lưu lịch sử khi thực hiện tìm kiếm
            // Không lưu lại khi chỉ chuyển trang
            if ($readerId !== null && $keyword !== '' && !isset($_GET['page_number'])) {
                SearchHistory::addOrUpdate($readerId, $keyword);
            }

            // Nhận nhiều thể loại
            $categoryIds = $_GET['category_id'] ?? [];

            if (!is_array($categoryIds)) {
                $categoryIds = [$categoryIds];
            }

            $categoryIds = array_filter(
                $categoryIds,
                fn($id) => ctype_digit((string)$id)
            );

            // Nhận nhiều năm
            $publishYears = $_GET['publish_year'] ?? [];

            if (!is_array($publishYears)) {
                $publishYears = [$publishYears];
            }

            $publishYears = array_filter(
                $publishYears,
                fn($year) => ctype_digit((string)$year)
            );

            // Tình trạng chỉ chọn một
            $status = $_GET['status'] ?? '';

            // Số sách mỗi trang
            $limit = 16;

            // Trang hiện tại
            $currentPage = max(
                1,
                (int)($_GET['page_number'] ?? 1)
            );

            // Tổng số sách sau khi lọc
            $totalBooks = Book::countBooksForReader(
                $keyword,
                $categoryIds,
                $publishYears,
                $status
            );

            // Tổng số trang
            $totalPages = max(
                1,
                (int)ceil($totalBooks / $limit)
            );

            // Không cho vượt quá trang cuối
            if ($currentPage > $totalPages) {
                $currentPage = $totalPages;
            }

            // OFFSET
            $offset = ($currentPage - 1) * $limit;

            // Lấy sách
            $books = Book::getBooksForReader(
                $keyword,
                $categoryIds,
                $publishYears,
                $status,
                $limit,
                $offset,
                $readerId
            );

            // Lấy danh sách thể loại
            $categories = Category::getAll();

            // Lấy danh sách năm
            $availableYears = Book::getPublishYears();

            $page = 'book_reader';

            // Hiển thị cảnh báo khi chưa đăng nhập nhưng nhấn nút thông báo
            if ($readerId === null && isset($_GET['notification']) && $_GET['notification'] === 'login_required')
            {
                $_SESSION['warning'] = 'Vui lòng đăng nhập trước khi sử dụng chức năng này.';
            }

            $navbarData = self::getNavbarData();
            $notifications = $navbarData['notifications'];
            $hasUnreadNotification = $navbarData['hasUnreadNotification'];
            $unreadNotificationCount = $navbarData['unreadNotificationCount'];

            require_once __DIR__ . '/../../../../frontend/reader/book_reader.php';
        }

        // Thêm hoặc xóa sách yêu thích
        public static function toggleFavorite()
        {
            $readerId = $_SESSION['reader']['reader_id'] ?? null;

            if ($readerId === null) {
                $_SESSION['warning'] = 'Vui lòng đăng nhập trước khi sử dụng chức năng này.';
                header("Location: " . BASE_URL . "/index.php?page=home");
                exit;
            }

            $bookId = (int)($_POST['book_id'] ?? 0);

            if ($bookId <= 0) {
                $_SESSION['warning'] = 'Sách không hợp lệ.';
                header("Location: " . BASE_URL . "/index.php?page=book_reader");
                exit;
            }

            // Nhận trang cần quay lại
            $returnPage = $_POST['return_page'] ?? 'book_reader';

            // Đã yêu thích → bỏ yêu thích
            if (Favorite::exists($readerId, $bookId)) {

                if (Favorite::remove($readerId, $bookId)) {
                    $_SESSION['success'] = 'Đã xóa sách khỏi danh sách yêu thích.';
                }

            } else {

                // Chưa yêu thích → thêm yêu thích
                if (Favorite::add($readerId, $bookId)) {
                    $_SESSION['success'] = 'Đã thêm sách vào danh sách yêu thích.';
                }
            }

            // Quay lại đúng trang
            $returnUrl = $_POST['return_url'] ?? '';

            if (!empty($returnUrl)) {
                header("Location: " . $returnUrl);
            } elseif ($returnPage === 'favorite') {
                header("Location: " . BASE_URL . "/index.php?page=favorite");
            } else {
                header("Location: " . BASE_URL . "/index.php?page=book_reader");
            }

            exit;
        }

        // Hiển thị trang sách yêu thích
        public static function favorite()
        {
            $page = 'favorite';

            $readerId = $_SESSION['reader']['reader_id'] ?? null;

            // Trang yêu thích bắt buộc phải đăng nhập
            if ($readerId === null) {
                $_SESSION['warning'] = 'Vui lòng đăng nhập trước khi sử dụng chức năng này.';

                header("Location: " . BASE_URL . "/index.php?page=home");
                exit;
            }

            // Lấy sách yêu thích của Reader
            $favoriteBooks = Favorite::getBooksByReader($readerId);

            $navbarData = self::getNavbarData();

            $notifications = $navbarData['notifications'];
            $hasUnreadNotification = $navbarData['hasUnreadNotification'];
            $unreadNotificationCount = $navbarData['unreadNotificationCount'];

            require_once __DIR__ . '/../../../../frontend/reader/favorite.php';
        }

        // Hiển thị trang thể loại sách
        public static function category()
        {
            $page = 'category_reader';
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

            // Lấy tất cả thể loại
            $categories = Category::getAllWithBookCount();

            require_once __DIR__ . '/../../../../frontend/reader/category_reader.php';
        }
    }
?>