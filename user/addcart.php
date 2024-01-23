<?php
require '../includes/database.php';
require '../includes/redirect.php';
session_start();
$connection = db();
$sql = "SELECT * FROM products where id = ".$_GET['id'];
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
$cartadd = "INSERT INTO cart (product, product_id, customer_id, price) VALUES (?,?,?,?);";
$stmt = mysqli_prepare($connection, $cartadd);
mysqli_stmt_bind_param($stmt, 'siii', $row['productname'],$row['id'],$_SESSION['id'],$row['price'] );
mysqli_stmt_execute($stmt);
header("Location: user.php?message=addedcart");
?>  