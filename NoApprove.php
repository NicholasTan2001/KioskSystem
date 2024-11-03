<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: No Approve Food vendor
-->

<?php
session_start();
if(!isset($_SESSION['username'])){


  header("location: login.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<?php

$ID = $_GET['id'];

$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

$query = "DELETE FROM food_vendor WHERE foodVendorID= '$ID' ";

$result = mysqli_query($link, $query);



if($result){

    echo '<script>alert("Deleted !!")</script>';


    echo "<script type = 'text/javascript')> window.history.back(); </script>";
}
    
?>
    
</body>
</html>