<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Update User Profile
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

        $username=$_POST["username"];
        $age=$_POST["age"];
        $email=$_POST["email"];
        $password=$_POST["password"];

        $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

        $query = "UPDATE user SET userPassword = '$password' WHERE userName = '$username' ";

        $result = mysqli_query($link, $query);

        $query1 = "SELECT * FROM user" or die(mysqli_connect_error());

        $result1 = mysqli_query($link, $query1);

        if (mysqli_num_rows($result1) > 0){

            while($row = mysqli_fetch_assoc($result1)){
            $userName = $row["userName"];
            $userRole = $row["userRole"];
            $userPassword= $row["userPassword"];

            if($userName==$username){
        
            if($userRole=="registeredUser"){

                $query2 = "UPDATE registered_user SET rUserAge = '$age', rUserEmail = '$email' WHERE userName = '$username' ";

                $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
            }
            else if ($userRole=="admin"){
            
                $query2 = "UPDATE administrator SET adminAge = '$age', adminEmail = '$email' WHERE userName = '$username' ";

                $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
            }
            
            else if ($userRole=="foodVendor"){
            
                $query2 = "UPDATE food_vendor SET foodVendorAge = '$age', foodVendorEmail = '$email'  WHERE userName = '$username' ";
                
                $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
            
            }
           }
         }
        }

        $_SESSION['password']=$password;
        
        if($result && $result1 && $result2){

                    echo '<script>alert("Updated !!")</script>';


                    echo "<script type = 'text/javascript')> window.history.back(); </script>";
        }
    ?>
    
    
    
    
</body>
</html>