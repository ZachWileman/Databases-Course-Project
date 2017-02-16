<?php
session_start();
include '../connect.php';

$fName = $_POST['fName'];
$lName = $_POST['lName'];
$phone = $_POST['phone'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];


if ($_POST['action'] == "Submit") {
	# Check that fName is of correct length
	if (strlen($fName) > 20) {
		header("Location: ../create_account2.php?error=fName");
		exit();
	}

	# Check that lName is of correct length
	if (strlen($lName) > 20) {
		header("Location: ../create_account2.php?error=lName");
		exit();
	}

	# Check that street is of correct length
	if (strlen($street) > 20) {
		header("Location: ../create_account2.php?error=street");
		exit();
	}

	# Check that city is of correct length
	if (strlen($city) > 20) {
		header("Location: ../create_account2.php?error=city");
		exit();
	}

	# Check that state is of correct length
	if (strlen($state) != 2) {
		header("Location: ../create_account2.php?error=state");
		exit();
	}

	# Check that zip is of correct length
	if (strlen($zip) != 5) {
		header("Location: ../create_account2.php?error=zip");
		exit();
	}

	# Inserts information to PERSONAL_INFORMATION
	$sql = "INSERT INTO PERSONAL_INFORMATION VALUES ('$_SESSION[user_being_created]', '$fName', '$lName', '$phone')";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		header("Location: ../create_account2.php?error=unknown");
		exit();
	}

	# Inserts information to BELONGS_TO
	$sql = "INSERT INTO BELONGS_TO VALUES ('$_SESSION[user_being_created]', '$fName', '$lName')";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		header("Location: ../create_account2.php?error=unknown");
		exit();
	}

	# Check what to set the address number to
	$sql = "SELECT * FROM ADDRESS WHERE USERID='$_SESSION[user_being_created]'";
	$result = mysqli_query($conn, $sql);
	$num_rows = mysqli_num_rows($result);
	$address_no = $num_rows + 1;

	# Inserts information to ADDRESS
	$sql = "INSERT INTO ADDRESS VALUES ('$_SESSION[user_being_created]', '$address_no', '$street', '$city', '$state', '$zip')";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		header("Location: ../create_account2.php?error=unknown");
		exit();
	}

	header("Location: ../index.php?success=create_account");

} else {

	header("Location: ../index.php?success=create_account");
}

?>