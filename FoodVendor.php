<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Food Vendor
-->

<?php
session_start();
if(!isset($_SESSION['username'])){


  header("location: login.php");

}

// Set the session timeout (in seconds)
$inactive_timeout = 300; // 30 minutes

// Check if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_timeout)) {
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session
    header("location: login.php");
    exit(); // Make sure to stop the script execution after redirecting
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="CSS.css">

<script src="../Kiosk/Java.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<head>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light">
<div class="row align-items-center">
    <div class="col-auto pr-0">
    <a href="FoodVendor.php"><img src="logo.png" width="90" height="70" class="d-inline-block align-top" alt=""></a>
    </div>
    <div class="col-auto pl-2">
      <h3 class="mb-0"> &emsp; &emsp; &emsp; &emsp; &ensp;Food Kiosk Management System</h3>
    </div>
  </div>
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#home"><b>MANAGE IN-STORE SALES</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="FVManageMenu.php"><b>MANAGE MENU</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact"><b>MANAGE KIOSK</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#orde"><b>MANAGE ORDER</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="FVUserProfile.php"><b>USER PROFILE</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#report"><b>REPORT</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php"><b>LOGOUT</b></a>
      </li>
    </ul>
  </div>
</nav>


<?php

  $username = $_SESSION['username'];
  $_SESSION['username']=$username;
  $password = $_SESSION['password'];
  $_SESSION['password']=$password;

  $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

  $query = "SELECT * FROM food_vendor WHERE userName = '$username'" or die(mysqli_connect_error());

  $result = mysqli_query($link, $query);

  if (mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

      $adminApprove=$row["adminApprove"];

      if($adminApprove == NULL){

        echo '<script>alert("Account not approve yet !! "); window.history.back();</script>';


      }

    }
  
  }
  

?>

<div class="box"><br><br>

<h1 class="title"><b>Food Vendor Page</b><br><br> <img src="MainMenu.png" width="750" height="650"></h1>

<br>


</div>

</body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>