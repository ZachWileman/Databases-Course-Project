<?php
session_start();
include '../connect.php';

$product_id = $_GET['product_id'];
$product_price = $_GET['product_price'];
$count = 1;

if (!isset($_SESSION['username'])) {
	echo "<div class='container-fluid' id='alert'>
				<div class='alert alert-danger alert-dismissible fade in' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<strong>Error! </strong> You must be signed in to add items to your cart!
				</div>
			</div>";
	exit();
}

# Checks if there are any of the same product already in the cart
$sql = "SELECT COUNT FROM IN_CART WHERE PID='$product_id' AND USERID='$_SESSION[username]'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$count = $row['COUNT'] + 1;
	$tot_price = $product_price * $count;

	# Updates COUNT value in cart for specified for product
	$sql = "
	UPDATE IN_CART
	SET COUNT='$count', TOT_PRICE='$tot_price'
	WHERE PID='$product_id' AND USERID='$_SESSION[username]'
	";
	$result = mysqli_query($conn, $sql);
	
	if (!$result) {
		echo "<div class='container-fluid' id='alert'>
						<div class='alert alert-danger alert-dismissible fade in' role='alert'>
  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  						<strong>I didn't anticipate this!</strong> Some unknown error occured!
						</div>
					</div>";
		exit();
	}

} else {

	# Adds the item to the cart
	$sql = "INSERT INTO IN_CART VALUES ('$_SESSION[username]', '$product_id', '$count', '$product_price')";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		echo "<div class='container-fluid' id='alert'>
						<div class='alert alert-danger alert-dismissible fade in' role='alert'>
  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  						<strong>I didn't anticipate this!</strong> Some unknown error occured!
						</div>
					</div>";
		exit();
	}
}

$sql = "SELECT NAME FROM ITEMS WHERE PID='$product_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo "<div class='container-fluid' id='alert'>
				<div class='alert alert-success alert-dismissible fade in' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<strong>Success!</strong> '$row[NAME]' was successfully added to your cart!
				</div>
			</div>";

mysqli_close($conn);

?>