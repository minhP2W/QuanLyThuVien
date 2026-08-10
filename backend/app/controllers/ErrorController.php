<!-- quản lý việc hiển thị các trang lỗi của hệ thống -->
<?php
    class ErrorController // extends BaseController
    {
        public static function error401()
        {
            require __DIR__ . '/../errors/401.php';
        }

        public static function error403()
        {
            require __DIR__ . '/../errors/403.php';
        }

        public static function error404()
        {
            require __DIR__ . '/../errors/404.php';
        }

        public static function error500()
        {
            require __DIR__ . '/../errors/500.php';
        }
    }
?>