<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Registered User (User Profile)
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

<link rel="stylesheet" type="text/css" href="CSS.css">

<script src="../Kiosk/Java.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<head>

</head>

<body>


<?php

   $username = $_SESSION['username'];  
   $password = $_SESSION['password'];

   $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

   $query = "SELECT * FROM registered_user" or die(mysqli_connect_error());

   $result = mysqli_query($link, $query);

   if (mysqli_num_rows($result) > 0){

       while($row = mysqli_fetch_assoc($result)){
       $rUserID = $row["rUserID"];
       $rUserAge = $row["rUserAge"];
       $rUserEmail= $row["rUserEmail"];
       $userName= $row["userName"];
       $membershipID= $row["membershipID"];
       $rUserImage= $row["rUserImage"];
   

        if($userName==$username){

          $age = $rUserAge;
          $email = $rUserEmail;
          $image = $rUserImage;

        }
      }
    }

   ?>  


<nav class="navbar navbar-expand-lg navbar-light">
<div class="row align-items-center">
    <div class="col-auto pr-0">
    <a href="RegisteredUser.php"><img src="logo.png" width="90" height="70" class="d-inline-block align-top" alt=""></a>
    </div>
    <div class="col-auto pl-2">
      <h3 class="mb-0"> &emsp; &emsp; &emsp; &emsp; &ensp;Food Kiosk Management System</h3>
    </div>
  </div>
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="RUserMenuOrder.php"><b>MAKE ORDER</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="RUserMembership.php"><b>MEMBERSHIP</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact"><b>KIOSK STATUS</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="RUserUserProfile.php"><b>USER PROFILE</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="RUserReport.php"><b>REPORT</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php"><b>LOGOUT</b></a>
      </li>
    </ul>
  </div>
</nav>

<div class="box"><br><br>

<h1 class="title"><b>User Profile</b>

<form class="userProfile-box" id="userImage" method="post" enctype="multipart/form-data">

        <center><b style="font-size:30px;">User Details</b><br><br>

        <?php
              if($image == null){
               ?>
                <div class="no-image">
                
                <p1> [No Image Available] </p1>

                <br>
                <br>

             <?php
              }
              else{
            ?>
            
            <img src="/Kiosk/<?php echo "$image"?>" width="100" height="100">
            <br>
            
            <?php
              }
            ?>

            <br>

            <div class="file-input-container">
            <input type="file" name="image" id="fileInput" class="file-input">
            <span id="fileNameDisplay"></span><br><br>
            <label for="fileInput" class="file-label">UPLOAD</label>
            </div>

            <?php $_SESSION['username'] = $username?>

            <br><br>
            <button class="button-28" type="button" onclick="updateImage()">SAVE</button>
            <button class="button-28" type="button" onclick="deleteProfile()">DELETE</button>
          <br><br>
  </form>

  <form id="userDetails" method="post" >

        <label class="loginDetails" style="font-size: 20px;">Username: </label>
        <input type="text" name="username" placeholder="Username"value="<?php echo "$username";?>" readonly><br><br>

        <label class="loginDetails" style="font-size: 20px;">Age: </label>
        <input type="text" name="age" placeholder="21" value="<?php echo "$age";?>"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Email: </label>
        <input type="text" name="email" placeholder="nicholastan_2001@hotmail.com" value="<?php echo "$email";?>"><br><br>

        <label class="loginDetails" style="font-size: 20px;">Passsword: </label>
        <input type="password" name="password" placeholder="Password" value="<?php echo "$password";?>"><br><br>

     
        <button class="button-28" type="button" onclick="updateProfile()">UPDATE</button>

        <br><br>

        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $username . " is " . $age . " years old. " . " Email address is " . $email . ". Nice to meet you! " ?><br>" width="100" height="100">

        </center>
</form>


<script>
function updateProfile() {
    document.getElementById('userDetails').action = 'UpdateUserProfile.php';
    document.getElementById('userDetails').submit();
}

function updateImage() {
      document.getElementById('userImage').action = 'UpdateRUserImage.php';
      document.getElementById('userImage').submit();
  }

function deleteProfile() {
    document.getElementById('userDetails').action = 'DeleteUserProfile.php';
    document.getElementById('userDetails').submit();
}

// Get the file input element
const fileInput = document.getElementById('fileInput');
  // Get the span element to display the file name
  const fileNameDisplay = document.getElementById('fileNameDisplay');

  // Add an event listener to the file input
  fileInput.addEventListener('change', function() {
    // Update the span element with the selected file name
    fileNameDisplay.textContent = this.files[0].name;
  });

</script>

</h1>
<br>


</div>

</body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>