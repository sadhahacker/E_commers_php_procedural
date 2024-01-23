<?php
require '../includes/database.php';
require '../includes/redirect.php';
session_start();
$connection = db();
$sql = "DELETE FROM cart WHERE cart.id = ".$_GET['id'];
mysqli_query($connection, $sql);
header('Location: cart.php?message=success');
?>