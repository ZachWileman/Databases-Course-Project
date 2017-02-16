<?php include "header.php"; ?>

	<?php
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if (strpos($url, 'error=invalid')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The username or password you entered is incorrect!
							</div>
						</div>";
		}

		if (strpos($url, 'success=create_account')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-success alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Success!</strong> Your account was successfully created!
							</div>
						</div>";
		}

		if (strpos($url, 'success=signin')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-success alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Success!</strong> Your now signed in as $_SESSION[username].
							</div>
						</div>";
		}

		if (strpos($url, 'success=checkout')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-success alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Success!</strong> Your order has been placed!
							</div>
						</div>";
		}

		if (strpos($url, 'no_results')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Sorry!</strong> No results found!
							</div>
						</div>";
		}
	?>

	<!-- Create a JumboTron -->
	<div class="container">
	  <center>
	  <div class="jumbotron">
	    <h2><img src="images/logo.png"></h2>
	    <p>This website is essential to people looking for an easier alternative to either going to their local store or driving a far distance just to get an item that can be purchased at the click of a button and delivered straight to their door. This system allows for ease-of-use to customers and is also an easier option for the site owner to reach as many customers as possible.</p>
	  </div>
	</center>
	</div>

</body>
</html>