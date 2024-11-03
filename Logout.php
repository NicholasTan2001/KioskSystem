<!-- 
BCS2243 WEB ENGINEERING
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Logout 
-->


<!DOCTYPE html>
<html>
     <body>

     <?php 

        session_start(); 
        session_destroy(); 

        header("location: login.php");


        
    ?> 

</body>
</html>