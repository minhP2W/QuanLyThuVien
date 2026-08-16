<!-- Bảng đánh giá sách -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Review
    {
        // Thống kê đánh giá sách
        public static function getDashboardStats()
        {
            global $conn;

            $sql = "SELECT COALESCE(AVG(rating), 0) AS average_rating, COUNT(*) AS total_reviews,
                        SUM(
                            CASE
                                WHEN rating = 5 THEN 1
                                ELSE 0
                            END
                        ) AS five_star,
                        SUM(
                            CASE
                                WHEN rating = 4 THEN 1
                                ELSE 0
                            END
                        ) AS four_star,
                        SUM(
                            CASE
                                WHEN rating = 3 THEN 1
                                ELSE 0
                            END
                        ) AS three_star,
                        SUM(
                            CASE
                                WHEN rating = 2 THEN 1
                                ELSE 0
                            END
                        ) AS two_star,
                        SUM(
                            CASE
                                WHEN rating = 1 THEN 1
                                ELSE 0
                            END
                        ) AS one_star
                    FROM reviews";

            $result = $conn->query($sql);

            return $result ? $result->fetch_assoc() : [];
        }
    }
?>