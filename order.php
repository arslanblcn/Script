<?php 
session_start();
include "config.php";
if(isset($_POST['giveOrder'])){
    $ordered = false;
    $user_id =  $_SESSION['id'];
    $food_name = serialize($_POST['food_name']);
    $restorant_name = $_POST['restorant_name'];
    (float)$total_cost = (float)htmlspecialchars(trim($_POST['total_cost']));
    $number_of_food = serialize($_POST['number_of_food']);
    $date = date('Y-m-d');
    $status = "Sipariş Alındı";
    $data = [
        'order_date' => $date,
        'total_cost' => $total_cost,
        'food_name' => $food_name,
        'number_of_food' => $number_of_food,
        'person_id' => $user_id,
        'restorant_name' => $restorant_name,
        'stat' => $status,
    ];
    $stmt = $conn->prepare("INSERT INTO orders (order_date, total_cost, food_name, number_of_food, person_id, restorant_name, stat) 
        VALUES (:order_date, :total_cost, :food_name, :number_of_food, :person_id, :restorant_name, :stat)");
    $stmt->execute($data);
    if($stmt){header("Location:" . $_SERVER['HTTP_REFERER'] . "&order=success");}
}
?>