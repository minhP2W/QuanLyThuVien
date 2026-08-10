<!-- Bảng User (quản trị viên, thủ thư) -->
<?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class User
    {
        // Lấy tài khoản theo username
        public static function findByUsername($username)
        {
            global $conn;

            $sql = "SELECT * 
                    FROM users 
                    WHERE username = ? 
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc(); // Lấy 1 dòng dữ liệu dưới dạng mảng kết hợp
        }

        // Lấy lại password theo username
        public static function resetPassword($username, $password)
        {
            global $conn;

            $sql = "UPDATE users 
                    SET password = ? 
                    WHERE username = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $password, $username);

            return $stmt->execute();
        }

        // Tìm quản trị viên theo id quản trị viên
        public static function findById($user_id)
        {
            global $conn;

            $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }

        // Cập nhật thông tin quản trị viên/thủ thư
        public static function updateProfile($user_id, $full_name)
        {
            global $conn;

            $sql = "UPDATE users
                    SET full_name = ?
                    WHERE user_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $full_name, $user_id);

            return $stmt->execute();
        }

        // Cập nhật mật khẩu
        public static function changePassword($user_id, $password)
        {
            global $conn;

            $sql = "UPDATE users
                    SET password = ?
                    WHERE user_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $password, $user_id);

            return $stmt->execute();
        }
    }
?>