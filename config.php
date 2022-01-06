<?php
        $server = "localhost";
        $db_user = "admin";
        $db_password = "password";
        $db_name = "yemeksepeti";

        $dsn = "mysql:host=$server;dbname=$db_name;charset=UTF8";
        try {
                $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
                $conn = new PDO($dsn, $db_user, $db_password, $options);
        } catch (PDOException $e) {
                echo $e->getMessage();
        }
?>