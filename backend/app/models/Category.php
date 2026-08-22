<!-- Bảng thể loại -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Category
    {
        // Lấy các thể loại có nhiều sách nhất
        public static function getCategoriesWithBookCount($limit = 5)
        {
            global $conn;

            $sql = "SELECT c.category_id, c.category_name, c.icon, c.icon_color, COUNT(b.book_id) AS book_count
                    FROM categories c
                    LEFT JOIN books b
                        ON c.category_id = b.category_id
                    GROUP BY c.category_id, c.category_name, c.icon, c.icon_color
                    ORDER BY book_count DESC
                    LIMIT ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Lấy tất cả thể loại
        public static function getAll()
        {
            global $conn;

            $sql = "SELECT category_id, category_name, icon, icon_color
                    FROM categories
                    ORDER BY category_name ASC";

            $result = $conn->query($sql);

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Lấy tất cả thể loại kèm số lượng sách
        public static function getAllWithBookCount()
        {
            global $conn;

            $sql = "SELECT c.category_id, c.category_name, c.icon, c.icon_color,
                        COUNT(b.book_id) AS book_count
                    FROM categories c
                    LEFT JOIN books b
                        ON c.category_id = b.category_id
                    GROUP BY c.category_id, c.category_name, c.icon, c.icon_color
                    ORDER BY c.category_name ASC";

            $result = $conn->query($sql);

            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
?>