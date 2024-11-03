<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Resgister user Membership
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

<?php

   $username = $_SESSION['username'];

   $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

   $query = "SELECT * FROM registered_user" or die(mysqli_connect_error());

   $result = mysqli_query($link, $query);


   if (mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){
    $rUserID = $row["rUserID"];
    $rUserAge = $row["rUserAge"];
    $rUserEmail= $row["rUserEmail"];
    $userName= $row["userName"];
    $membershipID= $row["membershipID"];


     if($userName==$username){

       $query1 = "SELECT * FROM membership" or die(mysqli_connect_error());

       $result1 = mysqli_query($link, $query1);

       if (mysqli_num_rows($result1) > 0){

        while($row = mysqli_fetch_assoc($result1)){
        $memberShipID = $row["membershipID"];
        $membershipPoint = $row["membershipPoint"];
        $membershipQR = $row["membershipQR"];

        if($memberShipID == $membershipID){

            if($membershipQR==NUll){

              $query3 = "UPDATE membership SET membershipPoint = '10' WHERE membershipID = '$memberShipID' ";

              $result3 = mysqli_query($link, $query3);

              $MPoint = $membershipPoint;

              $query2 = "UPDATE membership SET membershipQR = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=10' WHERE membershipID = '$memberShipID' ";

              $result2 = mysqli_query($link, $query2);

              $MQR=$membershipQR;

            }
            else{

              $MQR=$membershipQR;
              $MPoint=$membershipPoint;

            }
          }
        }
      }
     }
   }
 }

 $_SESSION['username']=$username ;
?>

<nav class="navbar navbar-expand-lg navbar-light">
<div class="row align-items-center">
    <div class="col-auto pr-0">
    <a href="RegisteredUser.php"><img src="logo.png" width="90" height="70" class="d-inline-block align-top" alt=""></a>
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
        <a class="nav-link" href="RUserMenuOrder.php"><b>MAKE ORDER</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="RUserMembership.php"><b>MEMBERSHIP</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact"><b>KIOSK STATUS</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="RUserUserProfile.php"><b>USER PROFILE</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="RUserReport.php"><b>REPORT</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php"><b>LOGOUT</b></a>
      </li>
    </ul>
  </div>
</nav>



<div class="box"><br><br>

<h1 class="title"><b>Membership Points</b><br><br> <img src="<?php echo"$MQR"?>" width="250" height="250"><br>



<form class="input-box" method="post" action="UpdateRUserMembershipPoint.php">

<br>

  <label style="font-size:20px" >Current Points :</label>
  <input type="text" name="Cmembership" placeholder="5" value="<?php echo"$MPoint"?>" readonly><br><br>

  <input type="number" name="Tmembership" placeholder="5" value="0";?><br><br>

  <button class="button-28" type="submit">TOP UP</button>

<form>

</h1>

<br>


</div>
</body>

<footer>
  

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>