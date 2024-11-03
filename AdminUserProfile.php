  <!-- 
  BCS2243 WEB ENGINEERING 
  Student ID: CD21062
  Student Name: Nicholas Tan Kae Jer
  Section: 02A
  Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
  Module 1: Administrator (User Profile)
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

  <nav class="navbar navbar-expand-lg navbar-light">
<div class="row align-items-center">
    <div class="col-auto pr-0">
      <a href="Administrator.php"><img src="logo.png" width="90" height="70" class="d-inline-block align-top" alt=""></a>
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
        <a class="nav-link" href="AdminMenuOrder.php"><b>MAKE ORDER</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="adminManageMenu.php"><b>MANAGE MENU</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AdminMembership.php"><b>MEMBERSHIP</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact"><b>KIOSK STATUS</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AdminUserProfile.php"><b>USER PROFILE</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AdminReport.php"><b>REPORT</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php"><b>LOGOUT</b></a>
      </li>
    </ul>
  </div>
</nav>

  <?php


    $username = $_SESSION['username'];  
    $password = $_SESSION['password'];

    $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

    $query = "SELECT * FROM administrator" or die(mysqli_connect_error());

    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
        $adminID = $row["adminID"];
        $adminAge = $row["adminAge"];
        $adminEmail= $row["adminEmail"];
        $userName= $row["userName"];
        $membershipID= $row["membershipID"];
        $adminImage= $row["adminImage"];
    

          if($userName==$username){

            $age = $adminAge; 
            $email = $adminEmail;
            $image = $adminImage;
            $_SESSION['username'] = $username;
            
          }
        }
      }
    ?> 


      <div class="box"><br><br>

      <h1 class="title"><b>User Profile</b>

      <form class="userProfile-box">
      <center>
      <Label class="sub-title"><b>Request Received</b></Label>
      <br><br>
      <table border=2>

      <tr>

          <th>Food Vendor ID</th>
          <th>Food Vendor Age</th>
          <th>Food Vendor Email</th>
          <th>Approve</th>

      </tr>


  <?php

      $query4 = "SELECT * FROM food_vendor WHERE adminApprove = '' " or die(mysqli_connect_error());

      $result4 = mysqli_query($link, $query4);

      if (mysqli_num_rows($result4) > 0){

          while($row = mysqli_fetch_assoc($result4)){
            $FVID = $row["foodVendorID"];
            $FVAge = $row["foodVendorAge"];
            $FVEmail= $row["foodVendorEmail"];

            ?>
            
          <tr>
            <td><?php echo "$FVID" ?></td>
            <td><?php echo "$FVAge" ?></td>
            <td><?php echo "$FVEmail" ?></td>
            <td><a href="YesApprove.php?id=<?php echo $FVID ?>">YES</a> / <a href="NoApprove.php?id=<?php echo $FVID ;?>">NO</a></td>
          </tr>
  <?php
          }
          }




  ?>
  </table>
  </form>
  </center>


        <?php

        $query2 = "SELECT * FROM registered_user" or die(mysqli_connect_error());

        $result2 = mysqli_query($link, $query2);

        ?>



        <form class="userProfile-box">
        <table border=2>
        <center>
        <Label class="sub-title"><b>Registered User</b></Label>
        <br><br>

        <tr>

        <th>Registered User ID</th>
        <th>Registered User Age</th>
        <th>Registered User Email</th>
        <th>Modify</th>

        </tr>

        <?php if (mysqli_num_rows($result2) > 0){

          while($row = mysqli_fetch_assoc($result2)){
          $rUserID = $row["rUserID"];
          $rUserAge = $row["rUserAge"];
          $rUserEmail= $row["rUserEmail"];
        ?>
        <tr>
          <td><?php echo "$rUserID" ?></td>
          <td><?php echo "$rUserAge" ?></td>
          <td><?php echo "$rUserEmail" ?></td>
          <td><a href="EditRUserDetails.php?id=<?php echo $rUserID ?>">Edit</a> / <a href="DeleteRUserDetails.php?id=<?php echo $rUserID ?>">Delete</a></td>
        </tr>

        <?php
          }
        }
        ?>
        </table>



        </form>
        </center>



        <?php

        $query3 = "SELECT * FROM food_vendor" or die(mysqli_connect_error());

        $result3 = mysqli_query($link, $query3);

        ?>



        <form class="userProfile-box">
        <table border=2>
        <center>
        <Label class="sub-title"><b>Food Vendor</b></Label>
        <br><br>

        <tr>

        <th>Food Vendor ID</th>
        <th>Food Vendor Age</th>
        <th>Food Vendor Email</th>
        <th>Modify</th>

        </tr>

        <?php if (mysqli_num_rows($result3) > 0){

          while($row = mysqli_fetch_assoc($result3)){
          $foodVendorID = $row["foodVendorID"];
          $foodVendorAge = $row["foodVendorAge"];
          $foodVendorEmail= $row["foodVendorEmail"];
        ?>
        <tr>
          <td><?php echo "$foodVendorID" ?></td>
          <td><?php echo "$foodVendorAge" ?></td>
          <td><?php echo "$foodVendorEmail" ?></td>
          <td><a href="EditFoodVendorDetails.php?id=<?php echo $foodVendorID ;?>">Edit</a> / <a href="DeleteFoodVendorDetails.php?id=<?php echo $foodVendorID ;?>">Delete</a></td>
        </tr>

        <?php
          }
        }
        ?>
        </table>



        </form>
        </center>


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
            <input type= "file" name="image" id="fileInput" class="file-input">
            <span id="fileNameDisplay"></span><br><br>
            <label for="fileInput" class="file-label">UPLOAD</label>
            </div>

            <?php $_SESSION['username'] = $username?>

            <br><br>
            <button class="button-28" type="button" onclick="updateImage()">SAVE</button>
            <button class="button-28" type="button" onclick="deleteProfile()">DELETE</button>
            </form>  

<form id="userDetails" method="post" >

          <br><br>
          <label class="loginDetails" style="font-size: 20px;">Username: </label>
          <input type="text" name="username" placeholder="Username" value="<?php echo "$username";?>" readonly><br><br>

          <label class="loginDetails" style="font-size: 20px;">Age: </label>
          <input type="text" name="age" placeholder="21" value="<?php echo "$age";?>"><br><br>

          <label class="loginDetails" style="font-size: 20px;">Email: </label>
          <input type="text" name="email" placeholder="nicholastan_2001@hotmail.com" value="<?php echo "$email";?>"><br><br>

          <label class="loginDetails" style="font-size: 20px;">Passsword: </label>
          <input type="password" name="password" placeholder="Password" value="<?php echo "$password";?>"><br><br>

          <button class="button-28" type="button" onclick="updateProfile()">UPDATE</button>

          <button class="button-28" type="button" onclick="window.location.href='CreateNewUser.php';">CREATE</button>

          <br><br>

          <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $username . " is " . $age . " years old. " . " Email address is " . $email . ". Nice to meet you! " ?><br>" width="100" height="100">

          <br>
          
        </center>
  </form>

  <script>
  function updateProfile() {
      document.getElementById('userDetails').action = 'UpdateUserProfile.php';
      document.getElementById('userDetails').submit();
  }
  function updateImage() {
      document.getElementById('userImage').action = 'UpdateImage.php';
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