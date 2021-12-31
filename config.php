<?php
        $server = "localhost";
        $db_user = "admin";
        $db_password = "password";
        $db_name = "yemeksepeti";

        $conn = new mysqli($server, $db_user, $db_password, $db_name);
        if($conn -> connect_error){die("Connection Failed" . mysqli_connect_error());}
?>