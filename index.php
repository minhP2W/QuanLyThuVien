<!-- entry point -->
<?php
    session_start(); // bắt đầu phiên làm việc của người dùng

    require_once __DIR__ . '/backend/app/config/config.php'; // nạp file config.php chỉ 1 lần, sử dụng cấu hình chung
                                                             // không tìm thấy file -> dừng chương trình & báo lỗi

    require_once __DIR__ . '/backend/app/router.php'; // Giao toàn bộ việc điều hướng cho router
?>