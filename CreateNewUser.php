<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jers
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Create New User 
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
      <a href="Administrator.php"><img src="logo.png" width="90" height="70" class="d-inline-block align-top" alt=""></a>
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
        <a class="nav-link" href="AdminMenuList.php"><b>MAKE ORDER</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="adminManageMenu.php"><b>MANAGE MENU</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AdminMembership.php"><b>MEMBERSHIP</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact"><b>KIOSK STATUS</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AdminUserProfile.php"><b>USER PROFILE</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AdminReport.php"><b>REPORT</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php"><b>LOGOUT</b></a>
      </li>
    </ul>
  </div>
</nav>


  <div class="box"><br><br>

<h1 class="title"><b>Create New User</b>

<form class="userProfile-box" action="UpdateNewUser.php" method="post" >

        <center><b style="font-size: 30px;">User Registration Details</b><br><br>
        <br>
        
        <label class="loginDetails" style="font-size: 20px;">Username: </label>
        <input type="text" name="username" placeholder="Username"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Age: </label>
        <input type="number" name="age" placeholder="21"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Email: </label>
        <input type="email" name="email" placeholder="nicholastan_2001@hotmail.com"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Passsword: </label>
        <input type="password" name="password" placeholder="Password"><br><br>

        <select class="userRoles" name="userRoles">
            <option value="" selected disabled>User Role</option>
            <option value="registeredUser">Registered User</option>
            <option value="foodVendor">Food Vendor</option>
        </select><br><br>

        <button class="button-28" name="LRegistration" type="submit">SUBMIT</button>&emsp;
        <button class="button-28" type="reset">RESET</button>

        </center>
</form>
</h1>
<div>



<br>

</div>
</body>

<footer>
  

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>

