<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Delete Registered User Details
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
    
    
$id=$_GET['id'];

$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

$query = "SELECT * FROM registered_User WHERE rUserID = '$id' ";

$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){

        $userName = $row["userName"];
    }
}

$query1 = "DELETE FROM registered_User WHERE rUserID = '$id' ";

$result1 = mysqli_query($link, $query1);

$query2 = "DELETE FROM user WHERE userName = '$userName' ";

$result2 = mysqli_query($link, $query2);

    
    
if($result && $result1 && $result2){

    echo '<script>alert("Deleted!!")</script>';


    echo "<script type = 'text/javascript')> window.history.back(); </script>";
}
    
    
    
    
?>
    
</body>
</html>