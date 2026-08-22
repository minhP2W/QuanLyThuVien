<!-- Trang giới thiệu và nội quy cho độc giả -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu - Librio</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="<?= BASE_URL ?>/frontend/assets/images/icon.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/about.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/sidebar_reader.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/reader/footer.css?v=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/frontend/assets/css/alert.css?v=1.0">
</head>
<body>
    <?php require_once 'navbar.php';?>
    <script src="<?= BASE_URL ?>/frontend/assets/js/reader/navbar.js"></script>

    <?php require_once 'sidebar_reader.php';?>

    <!-- Hiển thị cảnh báo chưa vào được chức năng khi chưa đăng ký/đăng nhập -->
    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert-warning" id="alert-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span><?= $_SESSION['warning']; ?></span>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

    <main class="reader-about">
        <h2 class="about-title">Giới thiệu và nội quy thư viện</h2>

        <section class="about-card">
            <h2><i class="bi bi-building"></i> Giới thiệu thư viện</h2>
            <p>
                Hệ thống website quản lý thư viện Librio được phát triển với mục tiêu hỗ trợ số hóa các hoạt động quản lý thư viện. 
                Hệ thống giúp người dùng dễ dàng tra cứu tài liệu, theo dõi tình trạng mượn sách, đồng thời hỗ trợ cán bộ thư viện quản lý sách 
                và độc giả một cách hiệu quả.
            </p>
        </section>

        <section class="about-card">
            <h2><i class="bi bi-clock-history"></i> Giờ mở cửa</h2>

            <ul>
                <li>Thứ Hai - Thứ Sáu: 08:00 - 17:00</li>
                <li>Thứ Bảy - Chủ Nhật: 08:30 - 11:30</li>
                <li>Ngày lễ: Nghỉ</li>
            </ul>
        </section>

        <section class="about-card">
            <h2><i class="bi bi-book"></i> Hướng dẫn mượn sách</h2>

            <ol>
                <li>Đăng nhập vào tài khoản độc giả.</li>
                <li>Tìm kiếm và chọn cuốn sách muốn mượn.</li>
                <li>Kiểm tra tình trạng sách và gửi yêu cầu đặt mượn (nếu sách còn).</li>
                <li>Chờ thủ thư xác nhận yêu cầu mượn sách.</li>
                <li>Đến thư viện, xuất trình mã độc giả để nhận sách.</li>
                <li>Kiểm tra thông tin phiếu mượn trước khi hoàn tất thủ tục nhận sách.</li>
            </ol>
        </section>

        <section class="about-card">
            <h2><i class="bi bi-arrow-return-left"></i> Hướng dẫn trả sách</h2>

            <ol>
                <li>Mang sách đến quầy trả sách trước hoặc đúng ngày đến hạn.</li>
                <li>Xuất trình mã độc giả để thủ thư tra cứu phiếu mượn.</li>
                <li>Thủ thư kiểm tra tình trạng sách và cập nhật thông tin trả sách trên hệ thống.</li>
                <li>Nếu có phí phạt (trả quá hạn hoặc làm hư hỏng, mất sách), thực hiện thanh toán theo quy định của thư viện.</li>
                <li>Xác nhận hoàn tất thủ tục trả sách.</li>
            </ol>
        </section>

        <section class="about-card">
            <h2><i class="bi bi-exclamation-circle"></i> Nội quy mượn trả</h2>

            <ul>
                <li>Độc giả chỉ được mượn sách khi có tài khoản hợp lệ và không bị khóa.</li>
                <li>Chỉ được mượn số lượng sách theo quy định của thư viện.</li>
                <li>Sách phải được giữ gìn cẩn thận, không viết, vẽ hoặc làm hư hỏng.</li>
                <li>Không tự ý chuyển sách đang mượn cho người khác.</li>
                <li>Trả sách đúng thời hạn ghi trên phiếu mượn.</li>
                <li>Thực hiện đầy đủ các quy định về phí phạt (nếu có).</li>
            </ul>
        </section>

        <section class="about-card">
            <h2><i class="bi bi-shield-exclamation"></i> Quy định xử lý vi phạm</h2>

            <ul>
                <li>Trả sách quá hạn sẽ bị áp dụng phí phạt theo quy định của thư viện.</li>
                <li>Làm hư hỏng hoặc làm mất sách phải bồi thường theo quy định.</li>
                <li>Độc giả có khoản phí phạt chưa thanh toán có thể bị tạm thời hạn chế quyền mượn sách.</li>
                <li>Trường hợp vi phạm nhiều lần, thư viện có quyền tạm khóa tài khoản độc giả cho đến khi hoàn thành các nghĩa vụ liên quan.</li>
            </ul>
        </section>

        <section class="about-card">
            <h2><i class="bi bi-telephone"></i> Liên hệ</h2>

            <p><strong>Địa chỉ:</strong> Thư viện Librio, phường Đông Ngạc, thành phố Hà Nội</p>
            <p><strong>Email:</strong> librio@example.com</p>
            <p><strong>Điện thoại:</strong> 0123 456 789</p>
        </section>
    </main>

    <?php require_once 'footer.php';?>

    <script src="<?= BASE_URL ?>/frontend/assets/js/sidebar.js?v=1.0"></script>
    <script src="<?= BASE_URL ?>/frontend/assets/js/alert.js?v=1.0"></script>
</body>
</html>