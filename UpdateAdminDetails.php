<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Update Administrator Details
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

    <?php
    
    
    $id=$_POST['id'];
    $age=$_POST['age'];
    $email=$_POST['email'];
    
$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

$query = "SELECT * FROM administrator" or die(mysqli_connect_error());

$result = mysqli_query($link, $query);


if (mysqli_num_rows($result) > 0){

  while($row = mysqli_fetch_assoc($result)){
  $adminID = $row["adminID"];
  $adminAge = $row["adminAge"];
  $adminEmail= $row["adminEmail"];
  
  if($id==$adminID){

    $query1 = "UPDATE administrator SET adminAge = '$age', adminEmail = '$email' WHERE adminID= '$id' ";

    $result1 = mysqli_query($link, $query1);


  }
  }
}
    
    
if($result && $result1){

    echo '<script>alert("Updated !!")</script>';


    echo "<script type = 'text/javascript')> window.history.back(); </script>";
}
    
    
    
    
?>
    
</body>
</html>