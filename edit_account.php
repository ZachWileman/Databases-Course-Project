<?php
	include "connect.php";
	include "header.php";

	# Set so that if no Personal Information was entered, personal info data will be inserted to the database instead of updated
	$_SESSION['insert_personal_info'] = false;
?>

	<!-- Used for displaying success and error messages -->
	<?php
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if (strpos($url, 'error=fName')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The first name should be between 1 and 20 characters!
							</div>
						</div>";
		}

		if (strpos($url, 'error=lName')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The last name should be between 1 and 20 characters!
							</div>
						</div>";
		}

		if (strpos($url, 'error=street')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The street name should be between 1 and 20 characters!
							</div>
						</div>";
		}

		if (strpos($url, 'error=city')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The city name should be between 1 and 20 characters!
							</div>
						</div>";
		}

		if (strpos($url, 'error=state')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The state name should be 2 characters!
							</div>
						</div>";
		}

		if (strpos($url, 'error=zip')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The zip code should be 5 characters!
							</div>
						</div>";
		}

		if (strpos($url, 'error=duplicate')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> That address already exists in your account!
							</div>
						</div>";
		}

		if (strpos($url, 'error=unknown')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>I didn't anticipate this!</strong> Some unknown error occured!
							</div>
						</div>";
		}

		if (strpos($url, 'success')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-success alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Success!</strong> The database was successfully updated!
							</div>
						</div>";
		}
	?>

	<?php
		$sql = "SELECT * FROM PERSONAL_INFORMATION WHERE USERID='$_SESSION[username]'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		# Set so that if no Personal Information was entered, personal info data will be inserted to the database instead of updated
		$num_rows = mysqli_num_rows($result);
		if ($num_rows == 0) {
			$_SESSION['insert_personal_info'] = true;
			$row['FNAME'] = "";
			$row['LNAME'] = "";
			$row['PHONE'] = "";
		}
		
		# Displays nothing for the phone number if nothing has been entered for it yet. By default, the phone number gets set to 0
		# since the attribute 'PHONE' is supposed to be of type BIGINT(10).
		if ($row["PHONE"] == 0) {
			$row["PHONE"] = "";
		}

		echo "
		<div class='container-fluid' id='create-table'>
		<form action='includes/update_info.inc.php' method='POST'>
			<div class='form-group row'>
			  <label for='fName' class='col-xs-2 col-form-label'>First Name</label>
			  <div class='col-xs-10'>
			    <input class='form-control' type='text' value='".$row["FNAME"]."' id='fName' name='fName' required>
			  </div>
			</div>
			<div class='form-group row'>
			  <label for='lName' class='col-xs-2 col-form-label'>Last Name</label>
			  <div class='col-xs-10'>
			    <input class='form-control' type='text' value='".$row["LNAME"]."' id='lName' name='lName' required>
			  </div>
			</div>
			<div class='form-group row'>
			  <label for='phone' class='col-xs-2 col-form-label'>Phone Number <mark>*not required</mark></label>
			  <div class='col-xs-10'>
			    <input class='form-control' type='tel' value='".$row["PHONE"]."' id='phone' name='phone' pattern='[0-9]{10}' title='Without the dashes: 123-456-7890'>
			  </div>
			</div><br>
			"
	?>

		<?php
			$sql = "SELECT * FROM ADDRESS WHERE USERID='$_SESSION[username]'";
			$result = mysqli_query($conn, $sql);
			$num_add = mysqli_num_rows($result);
		?>

		<div class="form-group form-inline">
	    <center><label for="address">Select Address:</label>
	    <select class="form-control" id="address-select" name="address-select" onchange="updateAddress(this.value)">
	      <?php
	      	$address_empty = true;
	      	for ($i=1; $i < ($num_add + 1); $i++) {
	      		echo "<option>$i</option>";
	      		$address_empty = false;
	      		$_SESSION['address_is_empty'] = false;
	      	}
	      	
	      	if ($address_empty) {
	      		$i = 0;
	      		echo "<option>$i</option>";
	      		$_SESSION['address_is_empty'] = true;
	      	}
	      ?>
	    </select>
	    <a type='btn btn-default' style='margin-left:25px;' class='form-inline btn btn-default' href='add_address.php'>Add Address</a>
	  	<?php
	  		if (!$_SESSION['address_is_empty']){
	  			echo "<input type='submit' name='action' class='form-inline btn btn-default' value='Remove Current Address' style='margin-left:25px;'>";
	  		}
	  	?>
	  	</center>
	  	<br>
	  </div>
    <script type="text/javascript">
    	function updateAddress(address_no) {
				if (window.XMLHttpRequest) {
			    // code for IE7+, Firefox, Chrome, Opera, Safari
			    xmlhttp = new XMLHttpRequest();
			  } else {
			    // code for IE6, IE5
			    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			  }
				xmlhttp.onreadystatechange = function() {
				  if (this.readyState == 4 && this.status == 200) {
				    document.getElementById("insert-address").innerHTML = this.responseText;
				  }
				};

				xmlhttp.open("GET", "includes/update_address.inc.php?address_no="+address_no, true);
				xmlhttp.send();
			}

    	function simulateOnChange(address_no) {
				if (address_no > 0) {
					var ev = new Event("change");
					var x = document.getElementById("address-select");
					x.dispatchEvent(ev);
				}
			}
			simulateOnChange(document.getElementById("address-select").value);
    </script>
	  <div id="insert-address"></div>
	  <br><br>
	  <center><input type='submit' name='action' class='btn btn-default' value='Update Account Info'></center>
	</form>
</div>

</body>
</html>