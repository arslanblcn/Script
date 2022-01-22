<?php
session_start();
if (!isset($_SESSION['item'])) {
    $_SESSION['item'] = array();
}
if (isset($_POST['addCart'])) {
    $item_exist = false;
    $food_name = htmlspecialchars(trim($_POST['food_name']));
    $number_of_food = (int)htmlspecialchars(trim($_POST['number_of_food']));
    $food_cost = (float)htmlspecialchars(trim($_POST['food_cost']));
    (float)$total_cost = floatval($number_of_food * $food_cost);
    if(!empty($_SESSION['item'])){
        foreach($_SESSION['item'] as $user_item){
            if($food_name == $user_item['food_name']){
                $item_exist = true;
                break;
            }

        }
        if($item_exist){
            $msg = "Yemek sepetinizde ekli. Güncellemek için sepeti kullanın.";
            $_SESSION['error'] = $msg;
            $_SESSION['item'][] = $item;
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $item = array('food_name' => $food_name, 'number_of_food' => $number_of_food, 'food_cost' => $total_cost);
            $_SESSION['item'][] = $item;
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    } else {
        $item = array('food_name' => $food_name, 'number_of_food' => $number_of_food, 'food_cost' => $total_cost);
        $_SESSION['item'][] = $item;
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
