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

        // Thêm hoặc cập nhật lịch sử tìm kiếm
        public static function addOrUpdate($readerId, $keyword)
        {
            global $conn;

            // Kiểm tra từ khóa đã tồn tại
            $sql = "SELECT history_id
                    FROM search_histories
                    WHERE reader_id = ? AND keyword = ?
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $readerId, $keyword);
            $stmt->execute();

            $result = $stmt->get_result();
            $history = $result->fetch_assoc();

            if ($history) {
                // Đã tồn tại → cập nhật thời gian tìm kiếm
                $sql = "UPDATE search_histories
                        SET searched_at = CURRENT_TIMESTAMP
                        WHERE history_id = ?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $history['history_id']);

            } else {
                // Chưa tồn tại → thêm mới
                $sql = "INSERT INTO search_histories (reader_id, keyword)
                        VALUES (?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $readerId, $keyword);
            }

            return $stmt->execute();
        }
    }
?>