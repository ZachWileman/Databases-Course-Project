<?php
session_start();
include '../connect.php';

$username = $_SESSION['username'];
$product_id = $_GET['product_id'];
$quantity = $_GET['amount'];

$sql = "SELECT * FROM IN_CART WHERE USERID='$username' AND PID='$product_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$sql = "SELECT PRICE FROM ITEMS WHERE PID='$product_id'";
$result = mysqli_query($conn, $sql);
$product_price = mysqli_fetch_array($result, MYSQLI_ASSOC);
$product_price = $product_price['PRICE'];

$count = $quantity - 1;
$tot_price = $product_price * $count;

if ($count == 0) {

	$sql = "
	DELETE FROM IN_CART
	WHERE USERID='$username' AND PID='$product_id'
	";

} else {

	$sql = "
	UPDATE IN_CART
	SET COUNT='$count', TOT_PRICE='$tot_price'
	WHERE USERID='$username' AND PID='$product_id'
	";
}

$result = mysqli_query($conn, $sql);

?>