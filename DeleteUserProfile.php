<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Delete User Profile
-->

<?php
session_start();
if(!isset($_SESSION['username'])){


  header("location: login.php");

}
?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>

    <?php

        $username=$_POST["username"];

        $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

        $query1 = "SELECT * FROM user" or die(mysqli_connect_error());

        $result1 = mysqli_query($link, $query1);

        if (mysqli_num_rows($result1) > 0){

            while($row = mysqli_fetch_assoc($result1)){
            $userName = $row["userName"];
            $userRole = $row["userRole"];
            $userPassword= $row["userPassword"];

            if($userName==$username){
        
            if($userRole=="registeredUser"){

                $query2 = "UPDATE registered_user SET rUserImage = NULL  WHERE userName = '$username' ";

                $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
            }
            else if ($userRole=="admin"){

                $query2 = "UPDATE administrator SET adminImage = NULL  WHERE userName = '$username' ";

                $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
            }
            
            else if ($userRole=="foodVendor"){
            
                $query2 = "UPDATE food_vendor SET foodVendorImage = NULL  WHERE userName = '$username' ";

                $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));
            
            }
           }
         }
        }

        if($result1 && $result2){

            echo '<script>alert("Deleted !!")</script>';

            echo "<script type= 'text/javascript'> window.history.back() </script>";
        }


     ?>
    
    
    
</body>
</html>