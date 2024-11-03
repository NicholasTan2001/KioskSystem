<!-- 
BCS2243 WEB ENGINEERING
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Login 1
-->

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="CSS.css">

<script src="../Kiosk/Java.js"></script>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<p class="bannerText"><a href="LoginPage.php"><img src="logo.png" width="90" height="70"  style="float: left; margin-left: 10px;" ></a>Food Kisok Management System</p>

</head>

<body>

<?php

if($_POST["username"] == null || $_POST["password"] == null || $_POST["userRoles"] == null){

    echo '<script>alert("Information need to fill in clearly !!")</script>';

    header("location: UserRegistration.php");

}

$username = $_POST["username"];
$age = $_POST["age"];
$email = $_POST["email"];
$password = $_POST["password"];
$userRoles = $_POST["userRoles"];

$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

$query3 = "SELECT * FROM user" or die(mysqli_connect_error());

$result3 = mysqli_query($link, $query3);


   if (mysqli_num_rows($result3) > 0){

    while($row = mysqli_fetch_assoc($result3)){

        $USERNAME = $row["userName"];

        if($USERNAME==$username){

            echo '<script>alert("Username used, try another :(")</script>';

            header("location: UserRegistration.php");
        
        }

    }
   }

if ($userRoles != "foodVendor"){
    $query = "INSERT INTO membership VALUE ('', '', '')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
}

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

if ($result1 && $result2) {
    echo '<script>alert("Completed Inserted !!")</script>';
} else {
    die("Insert failed");
}

mysqli_close($link);
?>

<div class="box"><br><br><br><br>

<h1><b>Login Form</b></h1><br>

<form class="loginForm" action="LoginProcess.php" method="post" >

        <center><b>Login Details</b><br><br>

        <label class="loginDetails" style="font-size: 20px;" >Username: </label>
        <input type="text" name="username" placeholder="Username"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Passsword: </label>
        <input type="password" name="password" placeholder="Password"><br><br>

        <button class="button-28" type="submit">SUBMIT</button> &emsp;
        <button class="button-28" type="reset">RESET</button>

        </center>
</form>


</div>

</body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>