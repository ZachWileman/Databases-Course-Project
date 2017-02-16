<?php
session_start();
include '../connect.php';

$updated_amount = [];

$sql = "SELECT * FROM IN_CART WHERE USERID='$_SESSION[username]'";
$result = mysqli_query($conn, $sql);

# Checks if the database has sufficient supply to carry out order
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

	$sql = "SELECT QUANTITY FROM ITEMS WHERE PID='$row[PID]'";
	$quantity = mysqli_query($conn, $sql);
	$amount_avail = mysqli_fetch_array($quantity, MYSQLI_ASSOC);
	$amount_avail = $amount_avail['QUANTITY'];

	if ($row['COUNT'] > $amount_avail) {
		header("Location: ../shopping_cart.php?unavail=".$row['PID']);
		exit();

	} else {
		$updated_amount[$row['PID']] = $amount_avail - $row['COUNT'];
	}
}

$sql = "SELECT * FROM IN_CART WHERE USERID='$_SESSION[username]'";
$result = mysqli_query($conn, $sql);

# Updates the quantity of the items in the database.
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

	$sql = "
	UPDATE ITEMS
	SET QUANTITY=".$updated_amount[$row['PID']]."
	WHERE PID='$row[PID]'
	";
	$update = mysqli_query($conn, $sql);
}

# Empties cart
$sql = "DELETE FROM IN_CART";
$result = mysqli_query($conn, $sql);

header("Location: ../index.php?success=checkout");

?>