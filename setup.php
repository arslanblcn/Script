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

    function createRestorant($conn){
        $sql = "CREATE TABLE restorants (id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            restorant_name VARCHAR(60) NOT NULL,
            phone_number VARCHAR(15) NOT NULL,
            restorant_type VARCHAR(15) NOT NULL,
            cit VARCHAR(20) NOT NULL,
            city VARCHAR(20) NOT NULL,
            ditrict VARCHAR(25) NOT NULL,
            neighborhood VARCHAR(25) NOT NULL,
            current_address VARCHAR(25) NOT NULL,
            owner_firstname VARCHAR(25) NOT NULL,
            owner_lastname VARCHAR(25) NOT NULL,
            owner_phone VARCHAR(13) NOT NULL,
            personel_firstname VARCHAR(25) NOT NULL,
            personel_lastname VARCHAR(25) NOT NULL,
            personel_phone VARCHAR(13) NOT NULL)";
        if($conn -> query($sql) === TRUE){echo "[+] Restorants' table has been created";}
        else{echo "[-] Error when creating table " . $conn->error;}
    }
    function createMenu($conn){
        $sql = "CREATE TABLE restorant_menu (id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            food VARCHAR(45) NOT NULL,
            food_img BLOB NOT NULL,
            food_cost VARCHAR(5) NOT NULL,
            food_number INT(30) NOT NULL,
            food_material VARCHAR(20) NOT NULL,
            restorant_id INT(4) NOT NULL)";
        if($conn -> query($sql) === TRUE){echo "[+] Menu table has been created";}
        else{echo "[-] Error when creating table " . $conn->error;}
    }
    function orderDetail($conn){
        $sql = "CREATE TABLE orders (id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            order_date DATETIME NOT NULL,
            total_cost INT(5) NOT NULL,
            food_cost VARCHAR(5) NOT NULL,
            person_id INT(5) NOT NULL,
            restorant_menuid INT(4) NOT NULL)";
        if($conn -> query($sql) === TRUE){echo "[+] Order table has been created";}
        else{echo "[-] Error when creating table " . $conn->error;}
    }
createUser($conn);
createRestorant($conn);
createMenu($conn);
orderDetail($conn);
?>