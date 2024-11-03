<!-- 
BCS2243 WEB ENGINEERING
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Login
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
