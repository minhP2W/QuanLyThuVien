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

            $sql = "SELECT COUNT(*) AS total_titles, COALESCE(SUM(total_quantity), 0) AS total_books, 
                           COALESCE(SUM(available_quantity), 0) AS available_books
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

        // Lấy các năm xuất bản có trong CSDL
        public static function getPublishYears()
        {
            global $conn;

            $sql = "SELECT DISTINCT publish_year
                    FROM books
                    WHERE publish_year IS NOT NULL
                    ORDER BY publish_year DESC";

            $result = $conn->query($sql);

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Lấy danh sách sách
        public static function getBooksForReader(
            $keyword = '',
            $categoryIds = [],
            $publishYears = [],
            $status = '',
            $limit = 16,
            $offset = 0,
            $readerId = null
        ) {
            global $conn;

            $sql = "SELECT 
                        b.book_id,
                        b.title,
                        b.publish_year,
                        b.total_quantity,
                        b.available_quantity,
                        b.cover_image,
                        a.author_name,
                        c.category_name,
                        f.favorite_id
                    FROM books b
                    INNER JOIN authors a
                        ON b.author_id = a.author_id
                    INNER JOIN categories c
                        ON b.category_id = c.category_id
                    LEFT JOIN favorites f
                        ON b.book_id = f.book_id
                        AND f.reader_id = ?
                    WHERE 1=1";

            $params = [];
            $types = "";

            // Reader hiện tại
            $params[] = $readerId;
            $types .= "i";

            // Tìm theo tên sách hoặc tác giả
            if ($keyword !== '') {
                $sql .= " AND (
                            b.title LIKE ?
                            OR a.author_name LIKE ?
                        )";

                $search = "%" . $keyword . "%";

                $params[] = $search;
                $params[] = $search;
                $types .= "ss";
            }

            // Lọc nhiều thể loại
            if (!empty($categoryIds)) {
                $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

                $sql .= " AND b.category_id IN ($placeholders)";

                foreach ($categoryIds as $categoryId) {
                    $params[] = (int)$categoryId;
                    $types .= "i";
                }
            }

            // Lọc nhiều năm
            if (!empty($publishYears)) {
                $placeholders = implode(',', array_fill(0, count($publishYears), '?'));

                $sql .= " AND b.publish_year IN ($placeholders)";

                foreach ($publishYears as $year) {
                    $params[] = (int)$year;
                    $types .= "i";
                }
            }

            // Lọc tình trạng
            if ($status === 'available') {
                $sql .= " AND b.available_quantity > 0";

            } elseif ($status === 'unavailable') {
                $sql .= " AND b.available_quantity = 0";
            }

            // Sách yêu thích lên đầu
            $sql .= " ORDER BY
                        CASE
                            WHEN f.favorite_id IS NOT NULL THEN 0
                            ELSE 1
                        END,
                        f.favorite_id DESC,
                        b.book_id DESC
                    LIMIT ? OFFSET ?";

            $params[] = (int)$limit;
            $params[] = (int)$offset;
            $types .= "ii";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param($types, ...$params);

            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Đếm tổng số sách
        public static function countBooksForReader(
            $keyword = '',
            $categoryIds = [],
            $publishYears = [],
            $status = ''
        ) {
            global $conn;

            $sql = "SELECT COUNT(*) AS total
                    FROM books b
                    INNER JOIN authors a
                        ON b.author_id = a.author_id
                    INNER JOIN categories c
                        ON b.category_id = c.category_id
                    WHERE 1=1";

            $params = [];
            $types = "";

            // Tìm theo tên sách hoặc tác giả
            if ($keyword !== '') {
                $sql .= " AND (
                            b.title LIKE ?
                            OR a.author_name LIKE ?
                        )";

                $search = "%" . $keyword . "%";

                $params[] = $search;
                $params[] = $search;
                $types .= "ss";
            }

            // Nhiều thể loại
            if (!empty($categoryIds)) {
                $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

                $sql .= " AND b.category_id IN ($placeholders)";

                foreach ($categoryIds as $categoryId) {
                    $params[] = (int)$categoryId;
                    $types .= "i";
                }
            }

            // Nhiều năm
            if (!empty($publishYears)) {
                $placeholders = implode(',', array_fill(0, count($publishYears), '?'));

                $sql .= " AND b.publish_year IN ($placeholders)";

                foreach ($publishYears as $year) {
                    $params[] = (int)$year;
                    $types .= "i";
                }
            }

            // Tình trạng
            if ($status === 'available') {
                $sql .= " AND b.available_quantity > 0";

            } elseif ($status === 'unavailable') {
                $sql .= " AND b.available_quantity = 0";
            }

            $stmt = $conn->prepare($sql);

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();

            return (int)$result['total'];
        }
    }
?>