<!-- Xử lý đăng ký, đăng nhập, đăng xuất, quản lý mật khẩu, hiển thị và cập nhật thông tin cho độc giả -->
<?php
    require_once __DIR__ . '/../../models/Reader.php';

    class ReaderAuthController // extends BaseController
    {
        // Đăng ký tài khoản độc giả
        public static function register()
        {
            // Đã đăng nhập thì không được vào lại trang đăng ký
            if (isset($_SESSION['reader'])) {
                header("Location: " . BASE_URL . "/index.php?page=home");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $full_name  = trim($_POST['full_name']);
                $gender     = trim($_POST['gender']);
                $birth_date = !empty($_POST['birthday']) ? $_POST['birthday'] : null;
                $email      = trim($_POST['email']);
                $phone      = trim($_POST['phone']);
                $address    = !empty($_POST['address']) ? trim($_POST['address']) : null;
                $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // Kiểm tra email
                if (Reader::findByEmail($email)) {
                    $error = "Email đã được sử dụng!";
                }

                // Kiểm tra số điện thoại
                elseif (Reader::findByPhone($phone)) {
                    $error = "Số điện thoại đã được sử dụng!";
                }

                else {
                    // Sinh mã độc giả
                    $reader_code = Reader::generateReaderCode();

                    // Lưu CSDL
                    $reader_id = Reader::register(
                        $reader_code,
                        $full_name,
                        $gender,
                        $birth_date,
                        $email,
                        $phone,
                        $password,
                        $address
                    );

                    // Cho phép đăng ký khi thông tin đăng ký hợp lệ
                    if ($reader_id) {
                        $_SESSION['reader'] = [
                            'reader_id'   => $reader_id,
                            'reader_code' => $reader_code,
                            'full_name'   => $full_name,
                            'status'      => 'active'
                        ];

                        $_SESSION['success'] = "Đăng ký thành công!";

                        header("Location: " . BASE_URL . "/index.php?page=home");
                        exit;
                    }
                    // Báo lỗi khi đăng ký thông tin không hợp lệ
                    $error = "Đăng ký thất bại!";
                }
            }
            $page = 'register';
            require __DIR__ . '/../../../../frontend/reader/register.php';
        }

        // Đăng nhập tài khoản độc giả
        public static function login()
        {
            // Đã đăng nhập thì không được vào lại trang đăng nhập
            if (isset($_SESSION['reader'])) {
                header("Location: " . BASE_URL . "/index.php?page=home");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $reader_code = trim($_POST['reader_code'] ?? '');
                $password = trim($_POST['password'] ?? '');
                $reader = Reader::findByReaderCode($reader_code);

                // Cho phép đăng nhập khi thông tin đăng nhập đúng
                if ($reader && $reader['status'] === 'active' && password_verify($password, $reader['password'])) {
                    $_SESSION['reader'] = [
                        'reader_id'   => $reader['reader_id'],
                        'reader_code' => $reader['reader_code'],
                        'full_name'   => $reader['full_name'],
                        'status'      => $reader['status'],
                        'created_at'  => $reader['created_at']
                    ];

                    $_SESSION['success'] = "Đăng nhập thành công!";
                    header("Location: index.php?page=home");
                    exit;
                }
                // Báo lỗi khi sai thông tin đăng nhập
                $_SESSION['error'] = "Sai mã độc giả hoặc mật khẩu, vui lòng nhập lại!";
                header("Location: index.php?page=login_reader");
                exit;
            }
            $page = 'login_reader';
            require __DIR__ . '/../../../../frontend/reader/login_reader.php';
        }

        // Đăng xuất tài khoản độc giả
        public static function logout()
        {
            unset($_SESSION['reader']);
            $_SESSION['success'] = "Đăng xuất thành công!";
            header("Location: " . BASE_URL . "/index.php?page=home");
            exit;
        }

        // Lấy lại mật khẩu tài khoản độc giả
        public static function forgotPassword()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $reader_code = trim($_POST['reader_code'] ?? '');
                $reader = Reader::findByReaderCode($reader_code);

                if ($reader) {
                    // Đặt lại mật khẩu thành 123456
                    Reader::resetPassword(
                        $reader_code,
                        password_hash('123456', PASSWORD_DEFAULT)
                    );

                    $_SESSION['showPassword'] = true;

                    header("Location: index.php?page=forgotPassword_reader");
                    exit;
                }
                // Báo lỗi khi mã độc giả không tồn tại
                $_SESSION['error'] = "Mã độc giả không tồn tại.";
                header("Location: index.php?page=forgotPassword_reader");
                exit;
            }
            // Lấy thông báo từ SESSION để hiển thị rồi xóa khỏi SESSION sau khi dùng
            $showPassword = $_SESSION['showPassword'] ?? false;
            unset($_SESSION['showPassword']);

            $error = $_SESSION['error'] ?? null;
            unset($_SESSION['error']);

            require_once __DIR__ . '/../../../../frontend/reader/forgotPassword_reader.php';
        }
    }
?>