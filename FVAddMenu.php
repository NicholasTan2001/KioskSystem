<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CA20022
Student Name: Muhammad Aliff bin Ahmad Zainudin
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 2: Add New Menu (Administrator)
-->

<?php
session_start();
if (!isset($_SESSION['username'])) {
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

// Include your database connection here
$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

// Fetch data for dropdowns
$adminQuery = "SELECT adminID, userName FROM administrator";
$locationQuery = "SELECT kioskID, location FROM kiosk";
$userQuery = "SELECT foodVendorID, userName FROM food_vendor";

$adminResult = mysqli_query($link, $adminQuery);
$locationResult = mysqli_query($link, $locationQuery);
$userResult = mysqli_query($link, $userQuery);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form inputs
    $newMenuName = $_POST['newMenuName'];
    $newMenuPrice = $_POST['newMenuPrice'];
    $newRemainingQuantity = $_POST['newRemainingQuantity'];

    // Generate QR Code link
    $qrCodeLink = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($newMenuName);

    // Get selected values from dropdowns
    $selectedAdminID = $_POST['adminDropdown'];
    $selectedLocationID = $_POST['locationDropdown'];
    $selectedUserID = $_POST['userDropdown'];

    // Insert into daily_menu table (consider using prepared statements)
    $insertDailyMenuQuery = "INSERT INTO daily_menu (foodVendorID, remainingQuantity, availabilityStatus) VALUES (?, ?, ?)";
    $insertDailyMenuStmt = mysqli_prepare($link, $insertDailyMenuQuery);

    // Generate availabilityStatus based on remainingQuantity
    $availabilityStatus = ($newRemainingQuantity >= 50) ? "Available" : (($newRemainingQuantity > 0) ? "Limited" : "Not Available");

    mysqli_stmt_bind_param($insertDailyMenuStmt, "iis", $selectedUserID, $newRemainingQuantity, $availabilityStatus);

    // Execute the query
    if (mysqli_stmt_execute($insertDailyMenuStmt)) {
        // Get the dailyMenuID of the newly inserted daily_menu
        $newDailyMenuID = mysqli_insert_id($link);

        // Insert new menu into menu table (consider using prepared statements)
        $insertMenuQuery = "INSERT INTO menu (menuName, menuPrice, menuQR, dailyMenuID, adminID, kioskID) VALUES (?, ?, ?, ?, ?, ?)";
        $insertMenuStmt = mysqli_prepare($link, $insertMenuQuery);

        mysqli_stmt_bind_param($insertMenuStmt, "sdsiii", $newMenuName, $newMenuPrice, $qrCodeLink, $newDailyMenuID, $selectedAdminID, $selectedLocationID);

        // Execute the query
        if (mysqli_stmt_execute($insertMenuStmt)) {
            // Close prepared statements
            mysqli_stmt_close($insertMenuStmt);
            mysqli_stmt_close($insertDailyMenuStmt);

            // Redirect to adminManageMenu.php after adding the menu
            header("location: FVManageMenu.php");
            exit();
        } else {
            // Handle the case where the menu insertion fails
            echo "Error inserting menu: " . mysqli_error($link);
            exit();
        }
    } else {
        // Handle the case where the daily_menu insertion fails
        echo "Error inserting daily_menu: " . mysqli_error($link);
        exit();
    }
}

// Close the database connection
mysqli_close($link);
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
    <a href="FoodVendor.php"><img src="logo.png" width="90" height="70" class="d-inline-block align-top" alt=""></a>
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
        <a class="nav-link" href="#home"><b>MANAGE IN-STORE SALES</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="FVManageMenu.php"><b>MANAGE MENU</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact"><b>MANAGE KIOSK</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#orde"><b>MANAGE ORDER</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="FVUserProfile.php"><b>USER PROFILE</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#report"><b>REPORT</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Logout.php"><b>LOGOUT</b></a>
      </li>
    </ul>
  </div>
</nav>

<div class="box"><br><br>

    <h1 class="title"><b>Add Menu</b>

        <div id="menuAdd">
            <center><b></b><br><br>
                <form method="post">
                    <div class="form-group">
                        <label for="newMenuName">New Menu Name:</label>
                        <input type="text" class="form-control" id="newMenuName" name="newMenuName" required>
                    </div>
                    <div class="form-group">
                        <label for="newMenuPrice">New Menu Price (RM):</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="newMenuPrice" name="newMenuPrice" required>
                    </div>
                    <div class="form-group">
                        <label for="newRemainingQuantity">New Remaining Quantity:</label>
                        <input type="number" min="0" class="form-control" id="newRemainingQuantity" name="newRemainingQuantity" required>
                    </div>
                    <!-- Dropdown for Admin -->
                    <div class="form-group">
                        <label for="adminDropdown">Admin:</label>
                        <select class="form-control" id="adminDropdown" name="adminDropdown">
                            <?php
                            while ($adminRow = mysqli_fetch_assoc($adminResult)) {
                                echo "<option value=\"{$adminRow['adminID']}\">{$adminRow['userName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Dropdown for Location -->
                    <div class="form-group">
                        <label for="locationDropdown">Location:</label>
                        <select class="form-control" id="locationDropdown" name="locationDropdown">
                            <?php
                            while ($locationRow = mysqli_fetch_assoc($locationResult)) {
                                echo "<option value=\"{$locationRow['kioskID']}\">{$locationRow['location']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Dropdown for User -->
                    <div class="form-group">
                        <label for="userDropdown">User:</label>
                        <select class="form-control" id="userDropdown" name="userDropdown">
                            <?php
                            while ($userRow = mysqli_fetch_assoc($userResult)) {
                                echo "<option value=\"{$userRow['foodVendorID']}\">{$userRow['userName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Add Menu</button>
                </form>
            </center>
        </div>

    </h1>
    <br>

</div>

</body>

<footer>
    <p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>
</footer>

</html>
