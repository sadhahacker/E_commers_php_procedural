<?php
$id = $_GET['id'];
require '../includes/database.php';
require '../includes/redirect.php';
$connection = db();
$sql = "INSERT INTO orders (customer_id, product_id, product, price,quantity,order_date)
SELECT customer_id, product_id, product, price, quantity,NOW()
FROM cart WHERE cart.customer_id=".$id;
mysqli_query($connection, $sql);
$sqlamount = "UPDATE orders yt SET yt.total_amount = (yt.quantity * yt.price)";
mysqli_query($connection, $sqlamount);
$sqldelete = "DELETE FROM `cart` WHERE `cart`.`customer_id` =".$id;
mysqli_query($connection, $sqldelete);
header('Location: cart.php?message=buy');
?>