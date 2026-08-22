<!-- Bảng thông báo -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Notification
    {
        // Lấy dữ liệu 5 thông báo gần nhất cho độc giả
        public static function getLatestByReader($readerId, $limit = 5)
        {
            global $conn;

            $sql = "SELECT notification_id, title, content, is_read, created_at
                    FROM notifications
                    WHERE reader_id = ?
                    ORDER BY created_at DESC
                    LIMIT ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $readerId, $limit);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Đếm số thông báo chưa đọc
        public static function countUnreadByReader($readerId)
        {
            global $conn;

            $sql = "SELECT COUNT(*) AS unread_count
                    FROM notifications
                    WHERE reader_id = ?
                    AND is_read = 0";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $readerId);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            return (int)$row['unread_count'];
        }

        // Thay đổi trạng thái đọc thông báo
        public static function markAsRead($notificationId, $readerId)
        {
            global $conn;

            $sql = "UPDATE notifications
                    SET is_read = 1
                    WHERE notification_id = ?
                    AND reader_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $notificationId, $readerId);

            return $stmt->execute();
        }

        // Lấy dữ liệu thông báo cho Navbar và Sidebar
        public static function getNavbarData($readerId)
        {
            $notifications = [];
            $hasUnreadNotification = false;
            $unreadNotificationCount = 0;

            if ($readerId !== null) {
                $notifications = self::getLatestByReader($readerId, 5);
                $unreadNotificationCount = self::countUnreadByReader($readerId);
                $hasUnreadNotification = $unreadNotificationCount > 0;
            }

            return [
                'notifications' => $notifications,
                'hasUnreadNotification' => $hasUnreadNotification,
                'unreadNotificationCount' => $unreadNotificationCount
            ];
        }

        // Lấy danh sách thông báo
        public static function getAllByReader($readerId, $status = 'all')
        {
            global $conn;

            $sql = "SELECT notification_id, title, content, is_read, created_at
                    FROM notifications
                    WHERE reader_id = ?";

            if ($status === 'unread') {
                $sql .= " AND is_read = 0";
            } elseif ($status === 'read') {
                $sql .= " AND is_read = 1";
            }

            $sql .= " ORDER BY created_at DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $readerId);
            $stmt->execute();

            $result = $stmt->get_result();

            $notifications = [];

            while ($row = $result->fetch_assoc()) {
                $notifications[] = $row;
            }

            $stmt->close();

            return $notifications;
        }

        // Đánh dấu tất cả đã đọc
        public static function markAllAsRead($readerId)
        {
            global $conn;

            $sql = "UPDATE notifications
                    SET is_read = 1
                    WHERE reader_id = ?
                    AND is_read = 0";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $readerId);
            $stmt->execute();

            $stmt->close();
        }
    }
?>