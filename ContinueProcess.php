<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Continue Process
-->

<?php

session_start();


$age=$_POST["age"];
$email=$_POST["email"];

$link=mysqli_connect("localhost", "root") or die(mysqli_connect_error());

mysqli_select_db($link, "kiosk") or die(mysqli_connect_error());

$query="insert into general_user Value('','$age','$email')" or die(mysqli_connect_error());

$result = mysqli_query($link, $query);

mysqli_close($link);

$_SESSION['age'] = $age;
$_SESSION['email'] = $email;

header("Location: GeneralUser.php");

?>