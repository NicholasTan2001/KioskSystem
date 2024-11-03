<!-- 
BCS2243 WEB ENGINEERING
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Login Process
-->


<!DOCTYPE html>
<html>
     <body>

     <?php

     session_start();

        $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

        $query = "SELECT * FROM user" or die(mysqli_connect_error());

        $result = mysqli_query($link, $query);
     
        if (mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){
            $username = $row["userName"];
            $userrole = $row["userRole"];
            $password = $row["userPassword"];
            
        

        if($_POST["username"]==$username){
            if ($_POST["password"]==$password){

                if($userrole=="admin"){

                    $link= mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

                    $query1 = "SELECT * FROM administrator WHERE userName = '$username'" or die(mysqli_connect_error());

                    $result1 = mysqli_query($link, $query1);

                    
                    if (mysqli_num_rows($result1) > 0){

                            $_SESSION['username'] = $username;
                            $_SESSION['password'] = $password;
                            header("Location: Administrator.php");
                    }
                    else{

                        echo '<script>alert("Account Deleted !! "); window.history.back();</script>';


                    }
                        
                }

                                      
            
                else if ($userrole=="registeredUser"){

                   $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

                   $query1 = "SELECT * FROM registered_user WHERE userName = '$username'" or die(mysqli_connect_error());

                   $result1 = mysqli_query($link, $query1);

                   if (mysqli_num_rows($result1) > 0){

                   $_SESSION['username'] = $username;
                   $_SESSION['password'] = $password;
                    header("Location: RegisteredUser.php");

                    }

                    else{

                        echo '<script>alert("Account Deleted !! "); window.history.back();</script>';


                    }
                }


                else if ($userrole=="foodVendor"){

                    $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

                    $query1 = "SELECT * FROM food_vendor WHERE userName = '$username'" or die(mysqli_connect_error());
 
                    $result1 = mysqli_query($link, $query1);

                    if (mysqli_num_rows($result1) > 0){

                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        header("Location: FoodVendor.php");
                    }

                    else{

                        echo '<script>alert("Account Deleted !! "); window.history.back();</script>';


                    }
                 }
                }
  
            }
        }
    }


            if($_POST["username"]!=$username || $_POST["password"]!=$password){          
 
                echo '<script>alert("Invalid Username or Password !! "); window.history.back();</script>';

            }
        
    
        ?>  

        </form>

    </body>
    </html>