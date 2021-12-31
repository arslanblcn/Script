<?php
   require_once 'config.php';

    function createUser($conn){
        $sql = "CREATE TABLE users (id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(33) NOT NULL,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            city VARCHAR(20) NOT NULL,
            ditrict VARCHAR(25) NOT NULL)";
        if($conn -> query($sql) === TRUE){echo "[+] Users' table has been created";}
        else{echo "[-] Error when creating table " . $conn->error;}
    }
createUser($conn);
?>