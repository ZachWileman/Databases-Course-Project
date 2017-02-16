<?php
session_start();
include '../connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

# Checks if username is taken
$sql = "SELECT USERID FROM USERS WHERE USERID='$username'";
$result = mysqli_query($conn, $sql);
$username_taken = mysqli_num_rows($result);
if ($username_taken > 0) {
	header("Location: ../create_account.php?error=username_taken");
	exit();
}

# Check that the username is of correct length
if (strlen($username) > 20) {
	header("Location: ../create_account.php?error=username_length");
	exit();
}

# Check that the password is of correct length
if (strlen($password) < 6 or strlen($password) > 15) {
	header("Location: ../create_account.php?error=password_length");
	exit();
}

$sql = "INSERT INTO USERS VALUES ('$username', '$password')";
$result = mysqli_query($conn, $sql);

if ($result) {
	$_SESSION['user_being_created'] = $username;
	header("Location: ../create_account2.php");
} else {
	header("Location: ../create_account.php?error=unknown");
}

?>