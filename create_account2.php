<?php include "header.php"; ?>

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

		if (strpos($url, 'error=unknown')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>I didn't anticipate this!</strong> Some unknown error occured!
							</div>
						</div>";
		}
	?>

	<!-- Form for creating account -->
	<div class="container-fluid" id="create-account">
		<label>Finish setting up your account:</label><br><br>
		<form action="includes/create_account2.inc.php" method="POST">
	  	<div class="form-group">
	  		<label for="text">First Name <mark>*required</mark></label>
	  		<input type="fName" class="form-control" id="fName" name="fName" placeholder="Enter your first name" required>
	  	</div>
	  	<div class="form-group">
	  		<label for="lName">Last Name <mark>*required</mark></label>
	  		<input type="text" class="form-control" id="lName" name="lName" placeholder="Enter your last name" required>
	  	</div>
  		<div class="form-group">
  			<label for="street">Street <mark>*required</mark></label>
  			<input type="text" class="form-control" id="street" name="street" placeholder="Enter your street" required>
  		</div>
  		<div class="form-group">
  			<label for="city">City <mark>*required</mark></label>
  			<input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required>
  		</div>
  		<div class="form-group">
  			<label for="state">State <mark>*required</mark></label>
  			<input type="text" class="form-control" id="state" name="state" placeholder="Enter your state. Ex.) MO" required>
  		</div>
  		<div class="form-group">
  			<label for="zip">Zip Code <mark>*required</mark></label>
  			<input type="number" class="form-control" id="zip" name="zip" max=99999 placeholder="Enter your zip code" required>
  		</div>
	  	<div class="form-group">
	  		<label for="phone">Phone Number</label>
	  		<input type="tel" class="form-control" pattern="[0-9]{10}" title="Without the dashes: 123-456-7890" id="phone" name="phone" placeholder="Enter your phone number">
	  	</div>
	  	<input type="submit" name='action' class="btn btn-default" value="Submit">
	  	<input type='submit' name='action' class='form-inline btn btn-default' value='Add Later' style='margin-left:25px;' formnovalidate>
		</form>
	</div>
	
</body>
</html>