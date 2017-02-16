<?php
	include "connect.php";
	include "header.php";
?>
	<div id='insert-message'></div>

	<div class="container-fluid" id="create-table">
		<table class="table table-striped" id='add-to-cart'>
	    <thead>
	      <tr>
	        <th>Electronic</th>
	        <th>Power Consumption</th>
	        <th>Price</th>
	        <th>Vendor</th>
	        <th>Quantity Available</th>
	        <th><span class='glyphicon glyphicon-shopping-cart' style='margin-left:35px;'></span></th>
	      </tr>
	    </thead>
	    <tbody>

		  <?php
		    
		  	$sql = "SELECT * FROM ITEMS WHERE FLAG='e'";
		  	$result = mysqli_query($conn, $sql);

		  	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					# Used for getting the vendor name
					$sql = "SELECT VID FROM SUPPLY WHERE PID='$row[PID]'";
					$vendor = mysqli_query($conn, $sql);
					$vendor_row = mysqli_fetch_array($vendor, MYSQLI_ASSOC);
					$sql = "SELECT VNAME FROM VENDORS WHERE VID='$vendor_row[VID]'";
					$vendor = mysqli_query($conn, $sql);
					$vendor_row = mysqli_fetch_array($vendor, MYSQLI_ASSOC);

					echo "
			    		<tr>
				        <td>$row[NAME]</td>
				        <td>$row[POWER_CONSUMP]W</td>
				        <td>$$row[PRICE]</td>
				        <td>$vendor_row[VNAME]</td>
				        <td>$row[QUANTITY]</td>
				        ";
				    
				    if ($row['QUANTITY'] > 0) {
				    
				    	echo "
				     		<td><a type='submit' class='btn btn-default' onclick='addToCart($row[PID], $row[PRICE]);'>Add to Cart</a></td>
				      	</tr>
				      	";
				    } else {

				    	echo "
				    		<td><a type='submit' class='btn btn-default' data-toggle='tooltip' data-placement='right' title='Currently Out of Stock!' disabled>Add to Cart</a></td>
				      	</tr>
				    		";
				    }
				}
	  	?>

	  	</tbody>
	  </table>
	</div>

<script>

	function addToCart(product_id, product_price) {
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
		  }
		};

		xmlhttp.open("GET", "includes/add_to_cart.inc.php?product_id="+product_id+"&product_price="+product_price, true);
		xmlhttp.send();
	}

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

</script>
</body>
</html>