<!-- Bảng độc giả (người đọc) -->
 <?php
    // kết nối database
    require_once __DIR__ . '/../config/database.php';

    class Reader
    {
        // Lấy tài khoản theo reader_code
        public static function findByReaderCode($reader_code)
        {
            global $conn;

            $sql = "SELECT * 
                    FROM readers 
                    WHERE reader_code = ? 
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $reader_code);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc(); // Lấy 1 dòng dữ liệu dưới dạng mảng kết hợp
        }

        // Lấy lại password theo reader_code
        public static function resetPassword($reader_code, $password)
        {
            global $conn;

            $sql = "UPDATE readers 
                    SET password = ? 
                    WHERE reader_code = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $password, $reader_code);

            return $stmt->execute();
        }

        // Đăng ký độc giả
        public static function register($reader_code, $full_name, $gender, $birth_date, $email, $phone, $password, $address)
        {
            global $conn;

            $sql = "INSERT INTO readers (reader_code, full_name, gender, birth_date, email, phone, password, address, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $reader_code, $full_name, $gender, $birth_date, $email, $phone, $password, $address);

            if ($stmt->execute()) {
                return $conn->insert_id; // trả về reader_id vừa thêm
            }
            return false;
        }


        // Kiểm tra email đã tồn tại chưa
        public static function findByEmail($email)
        {
            global $conn;

            $sql = "SELECT reader_id 
                    FROM readers 
                    WHERE email = ? 
                    LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();
        }

        // Kiểm tra số điện thoại đã tồn tại chưa
        public static function findByPhone($phone)
        {
            global $conn;

            $sql = "SELECT reader_id 
                    FROM readers 
                    WHERE phone = ? 
                    LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $phone);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result->fetch_assoc();
        }

        // Kiểm tra sự tồn tại của số điện thoại qua id độc giả
        public static function phoneExists($phone, $reader_id)
        {
            global $conn;

            $sql = "SELECT reader_id
                    FROM readers
                    WHERE phone = ?
                    AND reader_id <> ?
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $phone, $reader_id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }

        // Tạo mã độc giả mới
        public static function generateReaderCode()
        {
            global $conn;

            $sql = "SELECT reader_code 
                    FROM readers 
                    ORDER BY reader_code DESC 
                    LIMIT 1";
            $result = $conn->query($sql);

            if ($row = $result->fetch_assoc()) {
                $number = (int) substr($row['reader_code'], 2);
                $number++;
                return "DG" . str_pad($number, 3, "0", STR_PAD_LEFT);
            }
            return "DG001";
        }

        // Tìm độc giả theo id độc giả
        public static function findById($reader_id)
        {
            global $conn;

            $sql = "SELECT * 
                    FROM readers 
                    WHERE reader_id = ? 
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $reader_id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }

        // Kiểm tra sự tồn tại của email qua id độc giả
        public static function emailExists($email, $reader_id)
        {
            global $conn;

            $sql = "SELECT reader_id
                    FROM readers
                    WHERE email = ?
                    AND reader_id <> ?
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $email, $reader_id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }

        // Cập nhật thông tin độc giả
        public static function updateProfile($reader_id, $email, $phone, $address)
        {
            global $conn;

            $sql = "UPDATE readers
                    SET email = ?, phone = ?, address = ?
                    WHERE reader_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $email, $phone, $address, $reader_id);

            return $stmt->execute();
        }

        // Cập nhật mật khẩu
        public static function changePassword($reader_id, $password)
        {
            global $conn;

            $sql = "UPDATE readers
                    SET password = ?
                    WHERE reader_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $password, $reader_id);

            return $stmt->execute();
        }
    }
?>