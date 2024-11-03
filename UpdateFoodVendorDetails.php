<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Update Food Vendor Details
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
    
    
    $name=$_POST['name'];
    $id=$_POST['id'];
    $age=$_POST['age'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    
$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

$query = "SELECT * FROM food_vendor" or die(mysqli_connect_error());

$result = mysqli_query($link, $query);


if (mysqli_num_rows($result) > 0){

     while($row = mysqli_fetch_assoc($result)){
        $foodVendorID = $row["foodVendorID"];
        $foodVendorAge = $row["foodVendorAge"];
        $foodVandorEmail= $row["foodVandorEmail"];
        
    }
  if($id==$foodVendorID){

    $query1 = "UPDATE food_vendor SET foodVendorAge = '$age', foodVendorEmail = '$email'  WHERE foodVendorID= '$id' ";

    $result1 = mysqli_query($link, $query1);

    $query2 = "UPDATE user SET userPassword = '$password'  WHERE userName = '$name' ";

    $result2 = mysqli_query($link, $query2);


  }
}
    
    
if($result && $result1 && $result2){

    echo '<script>alert("Updated !!")</script>';


    echo "<script type = 'text/javascript')> window.history.back(); </script>";
}
    
    
    
    
?>
    
</body>
</html>