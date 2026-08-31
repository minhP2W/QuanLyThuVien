<!-- Bảng tiền phạt -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Fine
    {
        // Thống kê tiền phạt
        public static function getDashboardStats()
        {
            global $conn;

            $sql = "SELECT
                        COALESCE(SUM(fine), 0) AS total_fine,

                        COALESCE(SUM(
                            CASE
                                WHEN condition_status = 'Lost'
                                THEN fine
                                ELSE 0
                            END
                        ), 0) AS lost_fine,

                        COALESCE(SUM(
                            CASE
                                WHEN condition_status = 'Damaged'
                                THEN fine
                                ELSE 0
                            END
                        ), 0) AS damaged_fine,

                        COALESCE(SUM(
                            CASE
                                WHEN condition_status = 'Normal'
                                AND overdue_days > 0
                                THEN fine
                                ELSE 0
                            END
                        ), 0) AS overdue_fine

                    FROM fines";

            $result = $conn->query($sql);

            return $result ? $result->fetch_assoc() : [];
        }

        // Thống kê số sách bị hư hỏng và mất
        public static function getConditionStats()
        {
            global $conn;

            $sql = "SELECT
                        COALESCE(SUM(
                            CASE
                                WHEN condition_status = 'Damaged'
                                THEN 1
                                ELSE 0
                            END
                        ), 0) AS damaged_count,

                        COALESCE(SUM(
                            CASE
                                WHEN condition_status = 'Lost'
                                THEN 1
                                ELSE 0
                            END
                        ), 0) AS lost_count

                    FROM fines";

            $result = $conn->query($sql);

            return $result ? $result->fetch_assoc() : [];
        }
    }
?>