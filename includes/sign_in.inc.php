<?php
session_start();
include '../connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM USERS WHERE USERID='$username' AND PASSWD='$password'";
$result = mysqli_query($conn, $sql);

if (!$row = mysqli_fetch_assoc($result)) {
	header("Location: ../index.php?error=invalid");
} else {
	$_SESSION['username'] = $row['USERID'];
	header("Location: ../index.php?success=signin");
}

?>