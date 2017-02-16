<?php
session_start();
include "../connect.php";

$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];

# Check that street is of correct length
if (strlen($street) > 20) {
	header("Location: ../add_address.php?error=street");
	exit();
}

# Check that city is of correct length
if (strlen($city) > 20) {
	header("Location: ../add_address.php?error=city");
	exit();
}

# Check that state is of correct length
if (strlen($state) != 2) {
	header("Location: ../add_address.php?error=state");
	exit();
}

# Check that zip is of correct length
if (strlen($zip) != 5) {
	header("Location: ../add_address.php?error=zip");
	exit();
}

# Checks for duplpicate address attemting to be added.
$sql = "SELECT * FROM ADDRESS WHERE USERID='$_SESSION[username]'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

	if (($row['STREET'] == $street) and ($row['CITY'] == $city) and ($row['STATE'] == $state) and ($row['ZIP'] == $zip)) {
		header("Location: ../add_address.php?error=duplicate");
		exit();
	}
}

# Check what to set the address number to
$sql = "SELECT * FROM ADDRESS WHERE USERID='$_SESSION[username]'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
$address_no = $num_rows + 1;

# Inserts information to ADDRESS
$sql = "INSERT INTO ADDRESS VALUES ('$_SESSION[username]', '$address_no', '$street', '$city', '$state', '$zip')";
$result = mysqli_query($conn, $sql);

if (!$result) {
	header("Location: ../add_address.php?error=unknown");
	exit();
}

header("Location: ../edit_account.php");

?>