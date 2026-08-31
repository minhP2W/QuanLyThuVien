<!-- điều khiển trang thống kê cho quản trị viên -->
<?php
    class StatisticController
    {
        public static function statistic()
        {
            $page = 'statistic';
            require_once __DIR__ . '/../../../../frontend/admin/statistic.php';
        }
    }
?>