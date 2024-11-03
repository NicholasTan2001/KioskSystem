<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Edit Registered User Details
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
        <a class="nav-link" href="AdminMenuOrder.php"><b>MAKE ORDER</b></a>
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

<?php

$ID = $_GET['id'];


$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

$query = "SELECT * FROM registered_user" or die(mysqli_connect_error());

$result = mysqli_query($link, $query);


if (mysqli_num_rows($result) > 0){

  while($row = mysqli_fetch_assoc($result)){
  $rUserID = $row["rUserID"];
  $rUserAge = $row["rUserAge"];
  $rUserEmail= $row["rUserEmail"];
  

  if($ID==$rUserID){

    $id=$rUserID;
    $age=$rUserAge;
    $email=$rUserEmail;

  }
  }


  }

  $query1 = "SELECT * FROM user INNER JOIN registered_user ON user.userName = registered_user.userName " or die(mysqli_connect_error());
  $result1 = mysqli_query($link, $query1);

  while($row = mysqli_fetch_assoc($result1)){
    $Name= $row["userName"];
    $Password= $row["userPassword"];
    $rUserIDS= $row["rUserID"];
    
  
    if($id==$rUserIDS){
  
      $userName=$Name;
      $userPassword=$Password;
  
    }
    }


?>


<div class="box"><br><br>

<h1 class="title"><b>Edit User Details</b><br> 


    
<form class="userProfile-box" id="EditUserDetails" method="post" action="UpdateRUserDetails.php">

<center><b style="font-size:30px;">User Details</b><br><br>

<label class="loginDetails" style="font-size: 20px;">Username: </label>
<input type="text" name="name" placeholder="NicholasTan" value="<?php echo $userName?>"readonly><br><br>

<label class="loginDetails" style="font-size: 20px;">ID: </label>
<input type="text" name="id" placeholder="123" value="<?php echo $id?>"readonly><br><br>

<label class="loginDetails" style="font-size: 20px;">Age: </label>
<input type="text" name="age" placeholder="21" value="<?php echo $age?>"><br><br>

<label class="loginDetails" style="font-size: 20px;">Email: </label>
<input type="text" name="email" placeholder="nicholastan_2001@hotmail.com" value="<?php echo $email?>"><br><br>

<label class="loginDetails" style="font-size: 20px;">Password: </label>
<input type="text" name="password" placeholder="12345" value="<?php echo $userPassword?>"><br><br>

<button class="button-28" type="submit">UPDATE</button>

<br>

</center>
</form>


</h1>




<br>


</div>
</body>

<footer>
  

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>

