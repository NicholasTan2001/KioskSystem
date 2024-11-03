<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Update Administrator Membership
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
<head>

</head>
<body>

    <?php

$Cmembership=$_POST["Cmembership"];
$Tmembership=$_POST["Tmembership"];
$totalPoint=$Cmembership+$Tmembership;

$username = $_SESSION['username'];

$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

$query = "SELECT * FROM administrator" or die(mysqli_connect_error());

$result = mysqli_query($link, $query);


if (mysqli_num_rows($result) > 0){

 while($row = mysqli_fetch_assoc($result)){
 $adminID = $row["adminID"];
 $adminAge = $row["adminAge"];
 $adminEmail= $row["adminEmail"];
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

        $query2 = "UPDATE membership SET membershipPoint = '$totalPoint' WHERE membershipID = '$memberShipID' ";

        $result2 = mysqli_query($link, $query2);

        $QR = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$totalPoint";

        $query3 = "UPDATE membership SET membershipQR = '$QR' WHERE membershipID = '$memberShipID' ";

        $result3 = mysqli_query($link, $query3);


     }

    }
   }
  }
}
}

        
        if($result && $result1 && $result2 && $result3){

                    echo '<script>alert("Updated !!")</script>';


                    echo "<script type = 'text/javascript')> window.history.back(); </script>";
        }
    ?>
    
    
    
    
</body>
</html>