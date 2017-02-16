<?php include "header.php"; ?>

	<?php
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if (strpos($url, 'error=username_taken')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> That username is already taken!
							</div>
						</div>";
		}

		if (strpos($url, 'error=username_length')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The username should be between 1 and 20 characters!
							</div>
						</div>";
		}

		if (strpos($url, 'error=password_length')) {
			echo "<div class='container-fluid' id='alert'>
							<div class='alert alert-danger alert-dismissible fade in' role='alert'>
	  						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	  						<strong>Error!</strong> The password should be between 6 and 15 characters!
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
		<form action="includes/create_account.inc.php" method="POST">
	  	<div class="form-group">
	    	<label for="username">Username <mark>*required</mark></label>
	    	<input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
	  	</div>
	  	<div class="form-group">
	  		<label for="password">Password <mark>*required</mark></label>
	  		<input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
	  	</div>
	  	<button type="submit" class="btn btn-default">Create Account</button>
		</form>
	</div>
	
</body>
</html>