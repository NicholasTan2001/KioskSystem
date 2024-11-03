<!-- 
BCS2243 WEB ENGINEERING
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: User Resgistration
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

<div class="box"><br><br><br><br>

<h1><b>User Registration Form</b></h1>

<form class="loginForm" action="Login1.php" method="post" >

        <center><b>User Registration Details</b><br><br>

        <label class="loginDetails" style="font-size: 20px;">Username: </label>
        <input type="text" name="username" placeholder="Username"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Age: </label>
        <input type="number" name="age" placeholder="21"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Email: </label>
        <input type="email" name="email" placeholder="nicholastan_2001@hotmail.com"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Passsword: </label>
        <input type="password" name="password" placeholder="Password"><br><br>

        <select class="userRoles" name="userRoles">
            <option value="" selected disabled>User Role</option>
            <option value="registeredUser">Registered User</option>
            <option value="foodVendor">Food Vendor</option>
        </select><br><br>

        <button class="button-28" name="LRegistration" type="submit">SUBMIT</button>&emsp;
        <button class="button-28" type="reset">RESET</button>

        </center>
</form>
</div>

</body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>