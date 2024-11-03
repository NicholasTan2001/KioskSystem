<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Guest
-->

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="CSS.css">

<script src="../Kiosk/Java.js"></script>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<p class="bannerText"><a href="LoginPage.php"><img src="logo.png" width="90" height="70"  style="float: left; margin-left: 10px;" ></a>Food Kisok Management System</p>

<script>
function validateForm() {
  var x = document.forms["loginForm"]["age"].value;
  if (x == "" || x == null) {
    alert("Age must be fill in");
    return false;
  }

  var y = document.forms["loginForm"]["email"].value;
  if (y == "" || y == null) {
    alert("Email must be fill in");
    return false;
  }

}
</script>

</head>

<body>

<div class="box"><br><br><br><br>

<h1><b>Guest Form</b></h1><br><br><br>

<form name="loginForm" class="loginForm" action="ContinueProcess.php" onsubmit="return validateForm()" method="post" required>

        <center><b>Guest Details</b><br><br>

        <label class="loginDetails" style="font-size: 20px;">Age: </label>
        <input type="number" name="age" placeholder="21"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Email: </label>
        <input type="email" name="email" placeholder="nicholastan_2001@hotmail.com"><br><br>

        <button class="button-28" type="submit">CONTINUE</button>

        </center>
</form>

</div>

</body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>

