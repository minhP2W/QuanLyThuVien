<!-- Bảng sách -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Book
    {
        // Lấy danh sách sách mới nhất
        public static function getNewBooks($limit = 5)
        {
            global $conn;

            $sql = "SELECT b.book_id, b.title, b.cover_image, b.publish_year, a.author_name
                    FROM books b
                    LEFT JOIN authors a
                        ON b.author_id = a.author_id
                    ORDER BY b.book_id DESC
                    LIMIT ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Lấy các sách nổi bật có đánh giá cao nhất
        public static function getFeaturedBooks($limit = 5)
        {
            global $conn;

            $sql = "SELECT b.book_id, b.title, b.cover_image, b.publish_year, a.author_name, COALESCE(AVG(r.rating), 0) AS average_rating
                    FROM books b
                    LEFT JOIN authors a
                        ON b.author_id = a.author_id
                    LEFT JOIN reviews r
                        ON b.book_id = r.book_id
                    GROUP BY b.book_id, b.title, b.cover_image, b.publish_year, a.author_name
                    HAVING COUNT(r.review_id) > 0
                    ORDER BY average_rating DESC
                    LIMIT ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Lấy thông kê tổng số sách
        public static function getDashboardStats()
        {
            global $conn;

            $sql = "SELECT COUNT(*) AS total_titles, COALESCE(SUM(total_quantity), 0) AS total_books, COALESCE(SUM(available_quantity), 0) AS available_books
                    FROM books";

            $result = $conn->query($sql);

            return $result ? $result->fetch_assoc() : [];
        }

        // Đếm số đầu sách đã hết hàng
        public static function getOutOfStockCount()
        {
            global $conn;

            $sql = "SELECT COUNT(*) AS out_of_stock_count
                    FROM books
                    WHERE available_quantity = 0";

            $result = $conn->query($sql);

            return $result->fetch_assoc()['out_of_stock_count'];
        }
    }
?>