<!-- Bảng đặt trước sách -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Reservation
    {
        // Đếm số lượt đặt sách đang chờ xử lý
        public static function getPendingCount()
        {
            global $conn;

            $sql = "SELECT COUNT(*) AS reservation_count
                    FROM reservations
                    WHERE status = 'Pending'";

            $result = $conn->query($sql);

            return $result->fetch_assoc()['reservation_count'];
        }
    }
?>