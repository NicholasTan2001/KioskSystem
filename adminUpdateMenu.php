<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CA20022
Student Name: Muhammad Aliff bin Ahmad Zainudin
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 2: Update Menu (Administrator)
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

if (isset($_GET['dailyMenuID'])) {
    $dailyMenuID = $_GET['dailyMenuID'];

    // Connect to the database
    $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

    // Fetch menu details from menu and daily_menu tables
    $query = "SELECT m.menuID, m.menuName, m.menuPrice, m.menuQR, dm.remainingQuantity
              FROM menu m
              INNER JOIN daily_menu dm ON m.dailyMenuID = dm.dailyMenuID
              WHERE m.dailyMenuID = $dailyMenuID";

    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the updated values
        $newMenuPrice = $_POST['newMenuPrice'];
        $newRemainingQuantity = $_POST['newRemainingQuantity'];

        // Generate availabilityStatus based on remainingQuantity
        $availabilityStatus = "";
        if ($newRemainingQuantity >= 50) {
            $availabilityStatus = "Available";
        } elseif ($newRemainingQuantity <= 49 && $newRemainingQuantity > 0) {
            $availabilityStatus = "Limited";
        } else{
            $availabilityStatus = "Not Available";
        }

        // Update the menuPrice in the menu table
        $updateMenuQuery = "UPDATE menu SET menuPrice = $newMenuPrice WHERE menuID = {$row['menuID']}";
        mysqli_query($link, $updateMenuQuery);

        // Update the remainingQuantity and availabilityStatus in the daily_menu table
        $updateDailyMenuQuery = "UPDATE daily_menu SET remainingQuantity = $newRemainingQuantity, availabilityStatus = '$availabilityStatus' WHERE dailyMenuID = $dailyMenuID";
        mysqli_query($link, $updateDailyMenuQuery);

        // Redirect to adminManageMenu.php after the update
        header("location: adminManageMenu.php");
        exit();
    }
} else {
    // Redirect to adminManageMenu.php if dailyMenuID is not provided
    header("location: adminManageMenu.php");
    exit();
}
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

<div class="box"><br><br>

    <h1 class="title">

        <div id="menuUpdate" method="post">
            <center><b>Update Menu</b><br><br>
                <form method="post">
                    <div class="form-group">
                        <label for="newMenuPrice">New Menu Price (RM):</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="newMenuPrice" name="newMenuPrice" value="<?php echo $row['menuPrice']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="newRemainingQuantity">New Remaining Quantity:</label>
                        <input type="number" min="0" class="form-control" id="newRemainingQuantity" name="newRemainingQuantity" value="<?php echo $row['remainingQuantity']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Menu</button>
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
