<?php
require '../includes/database.php';
require '../includes/redirect.php';
$connection = db();
$id = $_GET['id'];
$sql = "DELETE FROM products WHERE `products`.`id` = ?;";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'i',$id);
mysqli_stmt_execute($stmt);
header('Location: listproduct.php?message=success');
?>