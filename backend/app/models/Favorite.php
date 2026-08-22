<!-- Bảng sách yêu thích -->
<?php
    require_once __DIR__ . '/../config/database.php';

    class Favorite
    {
        // Thêm sách vào yêu thích
        public static function add($readerId, $bookId)
        {
            global $conn;

            $sql = "INSERT IGNORE INTO favorites (reader_id, book_id)
                    VALUES (?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $readerId, $bookId);

            return $stmt->execute();
        }

        // Kiểm tra sách đã được yêu thích chưa
        public static function exists($readerId, $bookId)
        {
            global $conn;

            $sql = "SELECT favorite_id
                    FROM favorites
                    WHERE reader_id = ?
                    AND book_id = ?
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $readerId, $bookId);
            $stmt->execute();

            return $stmt->get_result()->num_rows > 0;
        }

        // Lấy danh sách sách yêu thích của Reader
        public static function getBooksByReader($readerId)
        {
            global $conn;

            $sql = "SELECT f.favorite_id, f.created_at, b.book_id, b.title, b.cover_image, b.publish_year, b.available_quantity, a.author_name,
                           c.category_name
                    FROM favorites f
                    INNER JOIN books b
                        ON f.book_id = b.book_id
                    INNER JOIN authors a
                        ON b.author_id = a.author_id
                    INNER JOIN categories c
                        ON b.category_id = c.category_id
                    WHERE f.reader_id = ?
                    ORDER BY f.favorite_id DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $readerId);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Xóa sách khỏi yêu thích
        public static function remove($readerId, $bookId)
        {
            global $conn;

            $sql = "DELETE FROM favorites
                    WHERE reader_id = ?
                    AND book_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $readerId, $bookId);

            return $stmt->execute();
        }
    }
?>