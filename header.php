<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>RainForest</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="css/stylesheet.css">
</head>
<body>

  <!-- Creating Navigation Bar -->
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Brand Logo & Name -->
        <a class="navbar-brand" id="brand" href="index.php"><img src="images/logo.png"></span></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          
          <!-- Categories Drop-Down Menu -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" role="button" aria-haspopup="true" aria-expanded="false"><b>Categories</b><span class="caret"></span></a>
            <ul class="dropdown-menu" id="menu-dd">
              <li><a href="display_movies.php">Movies</a></li>
              <li><a href="display_furniture.php">Furniture</a></li>
              <li><a href="display_electronics.php">Electronics</a></li>
            </ul>
          </li>
        </ul>

        <!-- Search Bar & Button -->
        <form class="navbar-form navbar-left" method='POST' action="includes/search.inc.php">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name='search'>
            <button class="btn btn-info btn-md" type='submit'>
          	  <span class="glyphicon glyphicon-search"></span>
      	    </button>
          </div>
        </form>

        <ul class="nav navbar-nav navbar-right">
          <?php

            # If a user is signed in:
            if (isset($_SESSION['username'])) {
              
              # Shopping Cart
              echo "<li><a href='shopping_cart.php'><b>Shopping Cart</b>
                      <span class='glyphicon glyphicon-shopping-cart'></span>
                    </a></li>";

              # Edit Account
              echo "<li class='dropdown'>
                      <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><b>My Account</b><span class='caret'></span></a>
                      <ul class='dropdown-menu' id='menu-dd'>
                        <li><a href='edit_account.php'>Edit Account</a></li>
                        <li><a href='includes/sign_out.inc.php'>Sign Out</a></li>
                      </ul>
                    </li>
                    <p class='navbar-text'><b>Signed in as: <mark>$_SESSION[username]</mark></b></p>";
            
            # If there's no user signed in:
            } else {

              # Sign In Button
              echo "<li class='dropdown'>
                      <a href='#' class='dropdown-toggle' data-toggle='dropdown'><b>Sign In</b> <span class='caret'></span></a>
                      <ul id='login-dp' class='dropdown-menu'>
                        <li>
                          <div class='row'>
                            <div class='col-md-12'>
                              <form class='form' method='POST' action='includes/sign_in.inc.php'>
                                <div class='form-group'>
                                  <input type='text' class='form-control' name='username' placeholder='Username' required>
                                </div>
                                <div class='form-group'>
                                  <input type='password' class='form-control' name='password' placeholder='Password' required><br>
                                  <div class='form-group'>
                                    <button type='submit' class='btn btn-primary btn-block'>Sign in</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div class='bottom text-center'>
                              New here? <a href='create_account.php'><b>Create Account</b></a>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li> <!-- End of Sign Up -->";
            }
          ?>

        	</ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav> <!-- End of Navigation Bar -->

  <br><br>