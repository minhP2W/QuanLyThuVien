<!-- Xử lý quản lý mật khẩu, hiển thị và cập nhật thông tin cho độc giả -->
<?php
    require_once __DIR__ . '/../../models/Reader.php';

    require_once __DIR__ . '/BaseReaderController.php';

    class ReaderProfileController extends BaseReaderController
    {
        // Hiển thị và cập nhật thông tin cá nhân độc giả
        public static function profile()
        {   
            $reader_id = $_SESSION['reader']['reader_id'];
            $navbarData = self::getNavbarData();
            $notifications = $navbarData['notifications'];
            $hasUnreadNotification = $navbarData['hasUnreadNotification'];
            $unreadNotificationCount = $navbarData['unreadNotificationCount'];
            $reader = Reader::findById($reader_id);

            $currentReader = Reader::findById($_SESSION['reader']['reader_id']);
            $currentEmail = $currentReader['email'];
            $currentPhone = $currentReader['phone'];
            $currentAddress = $currentReader['address'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email']);
                $phone = trim($_POST['phone']);
                $address = trim($_POST['address']);

                // Trùng email với độc giả khác
                if (Reader::emailExists($email, $reader_id)) {
                    $error = "Email đã được sử dụng.";
                }
                // Trùng số điện thoại với độc giả khác
                elseif (Reader::phoneExists($phone, $reader_id)) {
                    $error = "Số điện thoại đã được sử dụng.";
                }
                // Không có thay đổi thông tin
                elseif ($email === $currentEmail && $phone === $currentPhone && $address === $currentAddress) {
                    $error = "Không có sự thay đổi thông tin.";
                }
                // Cập nhật thông tin
                else {
                    Reader::updateProfile(
                        $reader_id,
                        $email,
                        $phone,
                        $address
                    );

                    $_SESSION['reader']['address'] = $address;
                    $_SESSION['success'] = "Cập nhật thông tin thành công!";

                    header("Location: " . BASE_URL . "/index.php?page=profile_reader");
                    exit;
                }
            }
            $page = "profile_reader";
            require __DIR__ . "/../../../../frontend/reader/profile_reader.php";
        }

        // Thay đổi mật khẩu tài khoản độc giả
        public static function changePassword()
        {
            $reader_id = $_SESSION['reader']['reader_id'];
            $navbarData = self::getNavbarData();
            $notifications = $navbarData['notifications'];
            $hasUnreadNotification = $navbarData['hasUnreadNotification'];
            $unreadNotificationCount = $navbarData['unreadNotificationCount'];
            $reader = Reader::findById($reader_id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $oldPassword = trim($_POST['old_password']);
                $newPassword = trim($_POST['new_password']);
                $confirmPassword = trim($_POST['confirm_password']);

                // Kiểm tra mật khẩu cũ
                if (!password_verify($oldPassword, $reader['password'])) {
                    $error = "Mật khẩu hiện tại không chính xác.";

                    require_once __DIR__ . '/../../../../frontend/reader/changePassword_reader.php';
                    return;
                }

                // Kiểm tra xác nhận mật khẩu
                if ($newPassword !== $confirmPassword) {
                    $error = "Mật khẩu mới và xác nhận mật khẩu mới không khớp.";

                    require_once __DIR__ . '/../../../../frontend/reader/changePassword_reader.php';
                    return;
                }

                // Không cho trùng mật khẩu cũ
                if (password_verify($newPassword, $reader['password'])) {
                    $error = "Mật khẩu mới phải khác mật khẩu hiện tại.";

                    require_once __DIR__ . '/../../../../frontend/reader/changePassword_reader.php';
                    return;
                }

                // Mã hóa mật khẩu mới
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Cập nhật CSDL
                Reader::changePassword(
                    $_SESSION['reader']['reader_id'],
                    $hashedPassword
                );

                $_SESSION['success'] = "Đổi mật khẩu thành công!";

                header("Location: " . BASE_URL . "/index.php?page=profile_reader");
                exit;
            }
            require_once __DIR__ . '/../../../../frontend/reader/changePassword_reader.php';
        }
    }
?>