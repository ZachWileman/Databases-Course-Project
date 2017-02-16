<?php
	include "connect.php";
	include "header.php";
?>

<div id='insert-message'></div>

<!-- Prints out the start of the table -->
<div class="container-fluid" id="create-table">
		<table class="table table-striped" id='add-to-cart'>
	    <thead>
	      <tr>
	        <th>Product</th>
	        <th>Price</th>
	        <th>Vendor</th>
	        <th>Quantity Available</th>
	        <th><span class='glyphicon glyphicon-shopping-cart' style='margin-left:35px;'></span></th>
	      </tr>
	    </thead>
	    <tbody>

<?php
	
	# Gets the search results and sorts them by which product had the most matches with the user's search
	$search_results = $_SESSION['search'];
	$search_results = array_filter($search_results);
	arsort($search_results);

	# Prints out each of the results
	foreach($search_results as $product_id=>$num_matches)
	{
	  # Grabs item info
	  $sql = "SELECT * FROM ITEMS WHERE PID='$product_id'";
	  $result = mysqli_query($conn, $sql);
	  $item_info = mysqli_fetch_assoc($result);

	  # Shows how many matches each result had
	  #echo "Product: ".$item_info['NAME']." has ".$num_matches." matches with your search. <br>";

	  # Used for getting the vendor name
		$sql = "SELECT VID FROM SUPPLY WHERE PID='$item_info[PID]'";
		$vendor = mysqli_query($conn, $sql);
		$vendor_row = mysqli_fetch_array($vendor, MYSQLI_ASSOC);
		$sql = "SELECT VNAME FROM VENDORS WHERE VID='$vendor_row[VID]'";
		$vendor = mysqli_query($conn, $sql);
		$vendor_row = mysqli_fetch_array($vendor, MYSQLI_ASSOC);

		# Outputs product name
	  echo "<tr><td>$item_info[NAME]</td>";

    # Outputs remaining info
    echo
    	"
      <td>$$item_info[PRICE]</td>
      <td>$vendor_row[VNAME]</td>
      <td>$item_info[QUANTITY]</td>
      ";
    
    # Disables the 'Add-to-cart' button if there isn't sufficient quantity available
    if ($item_info['QUANTITY'] > 0) {
    
    	echo "
     		<td><a type='submit' class='btn btn-default' onclick='addToCart($item_info[PID], $item_info[PRICE]);'>Add to Cart</a></td>
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
	
	//Used for adding a nice effect to the message when disabling the 'add-to-cart' button
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

</script>

</body>
</html>