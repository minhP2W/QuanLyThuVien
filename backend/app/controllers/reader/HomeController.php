<!-- điều khiển trang chủ của Reader -->
<?php
    require_once __DIR__ . '/ReaderAuthController.php';

    class HomeController // extends BaseController
    {
        public static function index()
        {
            $page = 'home';
            require __DIR__ . '/../../../../frontend/reader/home.php';
        }

        public static function about()
        {
            $page = 'about';
            require __DIR__ . '/../../../../frontend/reader/about.php';
        }
    }
?>