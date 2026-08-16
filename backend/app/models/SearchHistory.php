<!-- Bảng lịch sử tìm kiếm -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class SearchHistory 
    {
        // Lấy lịch sử tìm kiếm của một độc giả
        public static function getByReader($readerId, $limit = 5)
        {
            global $conn;

            $sql = "SELECT history_id, keyword, searched_at
                    FROM search_histories
                    WHERE reader_id = ?
                    ORDER BY searched_at DESC
                    LIMIT ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $readerId, $limit);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }
?>