<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Update New User
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

$username = $_POST["username"];
$age = $_POST["age"];
$email = $_POST["email"];
$password = $_POST["password"];
$userRoles = $_POST["userRoles"];

$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());


$query = "INSERT INTO membership VALUE ('', '', '')";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

$query1 = "INSERT INTO user VALUE ('$username', '$userRoles', '$password')";
$result1 = mysqli_query($link, $query1) or die(mysqli_error($link));

if($userRoles=="registeredUser"){

    $query2 = "INSERT INTO registered_user VALUE ('', '$age', '$email', '$username', LAST_INSERT_ID(),'')";
    $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
}
else if ($userRoles=="admin"){

    $query2 = "INSERT INTO administrator VALUE ('', '$age', '$email', '$username', LAST_INSERT_ID(),'')";
    $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
}

else if ($userRoles=="foodVendor"){

    $query2 = "INSERT INTO food_vendor VALUE ('', '$age', '$email', '$username','','')";
    $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));

}

if ($result && $result1 && $result2) {
    echo '<script>alert("Completed Inserted !!")</script>';
} else {
    die("Insert failed");
}

mysqli_close($link);

echo "<script type= 'text/javascript'> window.history.back() </script>";
?>