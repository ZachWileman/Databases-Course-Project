<?php
session_start();
include '../connect.php';

$username =$_SESSION['username'];
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$phone = $_POST['phone'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$address_no = $_POST['address-select'];


if ($_POST['action'] == "Update Account Info") {

	# Check that fName is of correct length
	if (strlen($fName) > 20) {
		header("Location: ../edit_account.php?error=fName");
		exit();
	}

	# Check that lName is of correct length
	if (strlen($lName) > 20) {
		header("Location: ../edit_account.php?error=lName");
		exit();
	}

	# Checks the address fields if there is an address available to check
	if (!$_SESSION['address_is_empty']) {
		# Check that street is of correct length
		if (strlen($street) > 20) {
			header("Location: ../edit_account.php?error=street");
			exit();
		}

		# Check that city is of correct length
		if (strlen($city) > 20) {
			header("Location: ../edit_account.php?error=city");
			exit();
		}

		# Check that state is of correct length
		if (strlen($state) != 2) {
			header("Location: ../edit_account.php?error=state");
			exit();
		}

		# Check that zip is of correct length
		if (strlen($zip) != 5) {
			header("Location: ../edit_account.php?error=zip");
			exit();
		}
	}

	if ($_SESSION['insert_personal_info']) {

		# Inserts information to PERSONAL_INFORMATION
		$sql = "INSERT INTO PERSONAL_INFORMATION VALUES ('$username', '$fName', '$lName', '$phone')";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			header("Location: ../edit_account.php?error=unknown");
			exit();
		}

		# Inserts information to BELONGS_TO
		$sql = "INSERT INTO BELONGS_TO VALUES ('$username', '$fName', '$lName')";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			header("Location: ../edit_account.php?error=unknown");
			exit();
		}

	} else {

		# Updates PERSONAL INFORMATION
		$sql = "
			UPDATE PERSONAL_INFORMATION 
			SET FNAME='$fName', LNAME='$lName', PHONE='$phone'
			WHERE USERID='$username';
		";

		$result = mysqli_query($conn, $sql);
		if (!$result) {
			header("Location: ../edit_account.php?error=unknown");
			exit();
		}
	}

	# Updates ADDRESS
	$sql = "
		UPDATE ADDRESS 
		SET STREET='$street', CITY='$city', STATE='$state', ZIP='$zip'
		WHERE USERID='$username' AND ADDRESS_NO='$address_no';
	";

	$result = mysqli_query($conn, $sql);
	if (!$result) {
		header("Location: ../edit_account.php?error=duplicate");
		exit();
	}

	header("Location: ../edit_account.php?success");


# Removes the selected address
} else {

	$address_no = $_POST['address-select'];

	$sql = "
	DELETE FROM ADDRESS
	WHERE USERID='$username' AND ADDRESS_NO='$address_no'
	";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		header("Location: ../edit_account.php?error=unknown");
		exit();
	}

	$sql = "SELECT * FROM ADDRESS WHERE USERID='$username'";
	$result = mysqli_query($conn, $sql);

	$count = 1;
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
		$sql = "
		UPDATE ADDRESS
		SET ADDRESS_NO='$count'
		WHERE USERID='$row[USERID]' AND STREET='$row[STREET]' AND CITY='$row[CITY]' AND STATE='$row[STATE]' AND ZIP='$row[ZIP]';
		";
		$update_address = mysqli_query($conn, $sql);
		
		if (!$update_address) {
			header("Location: ../edit_account.php?error=unknown");
			exit();
		}

		$count++;
	}

	header("Location: ../edit_account.php?success");
}

?>