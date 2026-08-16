<!-- Bảng phiếu mượn + Bảng chi tiết phiếu mượn -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Borrow
    {
        // Thống kê phiếu mượn đang mượn và đã quá hạn
        public static function getDashboardStats()
        {
            global $conn;

            $sql = "SELECT COALESCE(SUM(
                        CASE
                            WHEN status = 'Borrowing'
                            THEN 1
                            ELSE 0
                        END
                    ), 0) AS borrowing_slips,
                        COALESCE(SUM(
                            CASE
                                WHEN status = 'Borrowing'
                                AND due_date < CURDATE()
                                THEN 1
                                ELSE 0
                            END
                        ), 0) AS overdue_slips
                    FROM borrow_slips";

            $result = $conn->query($sql);

            return $result ? $result->fetch_assoc() : [];
        }

        // Thống kê số lượt mượn và trả sách theo từng tháng trong năm được chọn
        public static function getBorrowReturnStatistics($year)
        {
            global $conn;

            $sql = "WITH months AS (
                        SELECT 1 AS month_number
                        UNION ALL SELECT 2
                        UNION ALL SELECT 3
                        UNION ALL SELECT 4
                        UNION ALL SELECT 5
                        UNION ALL SELECT 6
                        UNION ALL SELECT 7
                        UNION ALL SELECT 8
                        UNION ALL SELECT 9
                        UNION ALL SELECT 10
                        UNION ALL SELECT 11
                        UNION ALL SELECT 12
                    ),
                    borrow_stats AS (
                        SELECT MONTH(borrow_date) AS month_number,
                            COUNT(*) AS borrow_count
                        FROM borrow_slips
                        WHERE YEAR(borrow_date) = ?
                        GROUP BY MONTH(borrow_date)
                    ),
                    return_stats AS (
                        SELECT MONTH(return_date) AS month_number,
                            COUNT(*) AS return_count
                        FROM return_slips
                        WHERE YEAR(return_date) = ?
                        GROUP BY MONTH(return_date)
                    )
                    SELECT 
                        m.month_number,
                        CONCAT('Tháng ', m.month_number) AS month_name,
                        COALESCE(b.borrow_count, 0) AS borrow_count,
                        COALESCE(r.return_count, 0) AS return_count
                    FROM months m
                    LEFT JOIN borrow_stats b
                        ON m.month_number = b.month_number
                    LEFT JOIN return_stats r
                        ON m.month_number = r.month_number
                    ORDER BY m.month_number";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $year, $year);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Lấy danh sách sách được mượn nhiều nhất
        public static function getPopularBooks($limit = 5)
        {
            global $conn;

            $sql = "SELECT b.book_id, b.title, a.author_name, SUM(bd.quantity) AS borrow_count
                    FROM borrow_details bd
                    INNER JOIN books b
                        ON bd.book_id = b.book_id
                    LEFT JOIN authors a
                        ON b.author_id = a.author_id
                    GROUP BY b.book_id, b.title, a.author_name
                    ORDER BY borrow_count DESC
                    LIMIT ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Lấy danh sách phiếu mượn gần đây nhất
        public static function getRecentBorrows($limit = 5)
        {
            global $conn;

            $sql = "SELECT bs.borrow_id, r.reader_code, r.full_name AS reader_name,
                        GROUP_CONCAT(
                            b.title
                            ORDER BY b.title
                            SEPARATOR ', '
                        ) AS book_names, bs.borrow_date, bs.due_date, u.full_name AS staff_name, bs.status
                    FROM borrow_slips bs
                    INNER JOIN readers r
                        ON bs.reader_id = r.reader_id
                    INNER JOIN borrow_details bd
                        ON bs.borrow_id = bd.borrow_id
                    INNER JOIN books b
                        ON bd.book_id = b.book_id
                    INNER JOIN users u
                        ON bs.staff_id = u.user_id
                    GROUP BY bs.borrow_id, r.reader_code, r.full_name, bs.borrow_date, bs.due_date, u.full_name, bs.status
                    ORDER BY
                        bs.borrow_date DESC,
                        bs.borrow_id DESC
                    LIMIT ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }
?>