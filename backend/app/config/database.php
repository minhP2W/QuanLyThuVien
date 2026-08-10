<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'librio';

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
?>