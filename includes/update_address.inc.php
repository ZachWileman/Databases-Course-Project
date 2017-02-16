<?php
session_start();
include '../connect.php';

$address_no = $_GET['address_no'];
$sql = "SELECT * FROM ADDRESS WHERE ADDRESS_NO='$address_no' AND USERID='$_SESSION[username]'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

echo "
	<div class='form-group row'>
	  <label for='street' class='col-xs-2 col-form-label'>Street</label>
	  <div class='col-xs-10'>
	    <input class='form-control' type='text' value='".$row['STREET']."' id='street' name='street' placeholder='Street goes here' required>
	  </div>
	</div>
	<div class='form-group row'>
	  <label for='city' class='col-xs-2 col-form-label'>City</label>
	  <div class='col-xs-10'>
	    <input class='form-control' type='text' value='".$row['CITY']."' id='city' name='city' placeholder='City goes here' required>
	  </div>
	</div>
	<div class='form-group row'>
	  <label for='state' class='col-xs-2 col-form-label'>State</label>
	  <div class='col-xs-10'>
	    <input class='form-control' type='text' value='".$row['STATE']."' id='state' name='state' placeholder='State goes here' required>
	  </div>
	</div>
	<div class='form-group row'>
	  <label for='zip' class='col-xs-2 col-form-label'>Zip Code</label>
	  <div class='col-xs-10'>
	    <input class='form-control' type='number' value='".$row['ZIP']."' id='zip' name='zip' max=99999 placeholder='Zip code goes here' required>
	  </div>
	</div>
	";
mysqli_close($conn);

?>