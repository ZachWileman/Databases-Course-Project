<?php
	include "connect.php";
	include "header.php";
?>

<?php

	if (isset($_GET['unavail'])) {
	
		$product_id = $_GET['unavail'];

		$sql = "SELECT NAME,QUANTITY FROM ITEMS WHERE PID='$product_id'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		echo "<div class='container-fluid' id='alert'>
						<div class='alert alert-danger alert-dismissible fade in' role='alert'>
  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  						<strong>Sorry!</strong> We currently only have $row[QUANTITY] in stock of the item: '$row[NAME]'. Please remove some of the item: '$row[NAME]' from your cart before checking out.
						</div>
					</div>";
	}

	unset($_GET['unavail']);

?>

<div id='insert-message'></div>

<div class="container-fluid" id="cart">
	<table class="table table-striped" id='add-to-cart'>
    <thead>
      <tr>
        <th>Product</th>
        <th>Category</th>
        <th>Total Price</th>
        <th>Quantity</th>
        <th><span class='glyphicon glyphicon-shopping-cart' style='margin-left:75px;'></span></th>
      </tr>
    </thead>
    <tbody>
    	<?php
		    
		  	$sql = "SELECT * FROM IN_CART WHERE USERID='$_SESSION[username]'";
		  	$result = mysqli_query($conn, $sql);

		  	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					# Gets product details
					$sql = "SELECT * FROM ITEMS WHERE PID='$row[PID]'";
					$product_details = mysqli_query($conn, $sql);
					$product_row = mysqli_fetch_array($product_details, MYSQLI_ASSOC);

					# Determines category of product to print out
					if ($product_row['FLAG'] == 'm') {
						$category = 'Movie';
					} elseif ($product_row['FLAG'] == 'e') {
						$category = 'Electronic';
					} else {
						$category = 'Furniture';
					}

					echo "
			    <tr>
		        <td>$product_row[NAME]</td>
		        <td>$category</td>
		        <td>$$row[TOT_PRICE]</td>
		        <td>$row[COUNT]</td>
		        <td><a type='submit' class='btn btn-default' onclick='removeFromCart($row[PID], $row[COUNT]);'>Remove (1) From Cart</a></td>
		      </tr>";
				}
	  	?>
    </tbody>
	</table>
	<?php
		if (mysqli_num_rows($result) > 0) {

			# Uses aggregate SUM function to calculate Cart Total
			$sql = "SELECT SUM(TOT_PRICE) AS SUM FROM IN_CART WHERE USERID='$_SESSION[username]'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
			echo "
			<div style='text-align:right;'>
				<div style='font-size: 20px;'>Total Price: <b style='color:red;'>$$row[SUM]</b></div><br>
				<a type='btn btn-default' class='btn btn-default' href='checkout.php'>Checkout</a>
			</div>
			";
		}
	?>

</div>

<script type="text/javascript">
	function removeFromCart(product_id, amount) {
		if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp = new XMLHttpRequest();
	  } else {
	    // code for IE6, IE5
	    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
		    document.getElementById("insert-message").innerHTML = this.responseText;
		    location.replace('shopping_cart.php');
		  }
		};

		xmlhttp.open("GET", "includes/remove_from_cart.inc.php?product_id="+product_id+"&amount="+amount, true);
		xmlhttp.send();
	}
</script>

</body>
</html>