<?php
require '../includes/database.php';
require '../includes/redirect.php';
session_start();
if($_GET['quan']>=0){
    $connection = db();
    $sql = "UPDATE `cart` SET `quantity` = ?,`total_price` = price * quantity WHERE `cart`.`id` =?";
    $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $_GET['quan'],$_GET['id']);
        mysqli_stmt_execute($stmt);
        redirect("cart");
}
else{
    redirect("cart");
}
?>