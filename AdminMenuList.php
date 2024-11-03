<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CA20022
Student Name: Muhammad Aliff bin Ahmad Zainudin
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 2: Manage List (Administrator)
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

// Check if the deleteMenu parameter is set
if (isset($_POST['deleteMenu']) && isset($_POST['dailyMenuID'])) {
    $dailyMenuID = $_POST['dailyMenuID'];

    // Check if there are dependent records in the order_item table
    $checkOrderItemQuery = "SELECT COUNT(*) as orderItemCount FROM order_item WHERE menuID IN (SELECT menuID FROM menu WHERE dailyMenuID = $dailyMenuID)";
    $checkOrderItemResult = mysqli_query($link, $checkOrderItemQuery);
    $orderItemCount = mysqli_fetch_assoc($checkOrderItemResult)['orderItemCount'];

    if ($orderItemCount > 0) {
        // Delete dependent records from the order_item table
        $deleteOrderItemQuery = "DELETE FROM order_item WHERE menuID IN (SELECT menuID FROM menu WHERE dailyMenuID = $dailyMenuID)";
        $deleteOrderItemResult = mysqli_query($link, $deleteOrderItemQuery);

        if (!$deleteOrderItemResult) {
            echo "error";
            exit;
        }
    }

    // Check if there are dependent records in the menu table
    $checkMenuQuery = "SELECT COUNT(*) as menuCount FROM menu WHERE dailyMenuID = $dailyMenuID";
    $checkMenuResult = mysqli_query($link, $checkMenuQuery);
    $menuCount = mysqli_fetch_assoc($checkMenuResult)['menuCount'];

    if ($menuCount > 0) {
        // Delete dependent records from the menu table
        $deleteMenuQuery = "DELETE FROM menu WHERE dailyMenuID = $dailyMenuID";
        $deleteMenuResult = mysqli_query($link, $deleteMenuQuery);

        if (!$deleteMenuResult) {
            echo "error";
            exit;
        }
    }

    // Perform the deletion query on the daily_menu table
    $deleteQuery = "DELETE FROM daily_menu WHERE dailyMenuID = $dailyMenuID";
    $deleteResult = mysqli_query($link, $deleteQuery);

    // Check if the deletion was successful
    if ($deleteResult) {
        echo "success";
        exit;
    } else {
        echo "error";
        exit;
    }
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

        <div id="menuList" method="post">
            <center><b>Menu List</b><br><br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">QR Code</th>
                            <th scope="col">Menu Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $query = "SELECT * FROM menu" or die(mysqli_connect_error());
                        $result = mysqli_query($link, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $menuID = $row["menuID"];
                            $menuName = $row["menuName"];
                            $menuPrice = $row["menuPrice"];
                            $menuQR = $row["menuQR"];
                            $dailyMenuID = $row["dailyMenuID"];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td><img src="<?php echo $menuQR; ?>" alt="QR Code" width="100" height="100"></td>
                                <td>
                                    <h3>Name: <?php echo $menuName; ?></h3>
                                    <h4>Price: RM<?php echo number_format($menuPrice, 2); ?></h4>
                                    <?php
                                    // Fetch additional information from daily_menu table
                                    $dailyMenuQuery = "SELECT availabilityStatus, remainingQuantity FROM daily_menu WHERE dailyMenuID = $dailyMenuID";
                                    $dailyMenuResult = mysqli_query($link, $dailyMenuQuery);
                                    $dailyMenuData = mysqli_fetch_assoc($dailyMenuResult);
                                    ?>
                                    <p>Status: <?php echo $dailyMenuData['availabilityStatus']; ?></p>
                                    <p>Quantity: <?php echo $dailyMenuData['remainingQuantity']; ?></p>
                                </td>
                            </tr>
                        <?php
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
                <!-- ADD ORDER form -->
                <br>
                <form method="post" id="addOrderForm">
                    <label for="menuDropdown">Menu:</label>
                    <select name="menuDropdown" id="menuDropdown">
                        <?php
                        // Populate the dropdown with menu names
                        $menuQuery = "SELECT menuName FROM menu";
                        $menuResult = mysqli_query($link, $menuQuery);

                        while ($menuRow = mysqli_fetch_assoc($menuResult)) {
                            $menuOption = $menuRow['menuName'];
                            echo "<option value='$menuOption'>$menuOption</option>";
                        }
                        ?>
                    </select>
                    <br><label for="quantityInput">Quantity:</label>
                    <input type="number" name="quantityInput" id="quantityInput" min="1">
                    <br><button type="button" class="btn btn-success" onclick="addOrder()">ADD ORDER</button>
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

<!-- Add jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Add your JavaScript code -->
<script>
    // Add any JavaScript code you may need

    function addOrder() {
        var menuName = $("#menuDropdown").val();
        var quantity = $("#quantityInput").val();

        // Perform AJAX request to update remainingQuantity
        $.ajax({
            type: "POST",
            url: "updateQuantity.php", // Create a new PHP file to handle quantity updates
            data: {
                menuName: menuName,
                quantity: quantity
            },
            success: function (response) {
                // Handle success if necessary
                console.log(response);
            },
            error: function (error) {
                // Handle error if necessary
                console.error("Error updating quantity:", error.responseText);
                alert("An error occurred while updating quantity. Please try again.");
            }
        });
    }
</script>

</html>
