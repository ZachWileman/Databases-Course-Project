<?php
	include "connect.php";
	include "header.php";
?>

<div class='container-fluid' id='create-table'>
<form action='includes/checkout.inc.php' method='POST'>
	<center><label>Which address would you like to use for shipping?</label></center><br>

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
	<div id="insert-address"></div><br>

	<?php
		# Uses aggregate SUM function to calculate Cart Total
		$sql = "SELECT SUM(TOT_PRICE) AS SUM FROM IN_CART WHERE USERID='$_SESSION[username]'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		echo "
		<div style='text-align: right;'>
			<div style='font-size: 20px;'>Total Price: <b style='color:red;'>$$row[SUM]</b></div><br>
		</div>
		";
	
		$sql = "SELECT USERID FROM PERSONAL_INFORMATION WHERE USERID='$_SESSION[username]'";
		$result = mysqli_query($conn, $sql);

		# Used for making sure the user has Personal information & an Address stored in his/her account
		if ($_SESSION['address_is_empty'] or (mysqli_num_rows($result) == 0)) {

			echo "
				<input type='submit' name='action' class='btn btn-default pull-right' value='Submit Order' data-toggle='tooltip' data-placement='bottom' title='Please add an address and/or personal information to your account!' disabled>
				";

		}	else {

			echo "
				<input type='submit' name='action' class='btn btn-default pull-right' value='Submit Order'>
				";
		}

	?>

	</form>
</div>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

</body>
</html>