<!-- điều khiển trang quản lý danh mục sách cho quản trị viên -->
<?php
    class CatalogAdminController
    {
        public static function manageCatalog()
        {
            $page = 'manageCatalog';
            require_once __DIR__ . '/../../../../frontend/admin/manageCatalog.php';
        }
    }
?>