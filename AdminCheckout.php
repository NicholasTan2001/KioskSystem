<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

if (!isset($_SESSION["cart_item"]) || empty($_SESSION["cart_item"])) {
    header("location: AdminMenuOrder.php?error=Your Cart is Empty");
    exit();
}

// Assuming you have a connection to the database
$conn = new mysqli("localhost", "root", "", "kiosk");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve payment types from the database
$paymentTypesQuery = $conn->query("SELECT DISTINCT paymentType FROM payment");
if ($paymentTypesQuery === false) {
    die("Error in SQL query: " . $conn->error);
}

$paymentTypes = $paymentTypesQuery->fetch_all(MYSQLI_ASSOC);

// Calculate total amount based on shopping cart
$totalAmount = 0;

if (!empty($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $totalAmount += $item["quantity"] * $item["price"];
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
    <div id="checkout">
        <h1 class="title">
            <b>Checkout<b>
            <br><br>

        <div>
            <label style="font-size: 20px;">Total Amount to Pay: RM<?php echo number_format($totalAmount, 2); ?></label>
        </div>

        <form method="post" action="AdminOrderQR.php">
            <label for="paymentType" style="font-size: 20px;">Payment Type:</label>
            <select name="paymentType" id="paymentType" style="font-size: 20px;">
                <?php foreach ($paymentTypes as $type) : ?>
                    <option value="<?php echo $type['paymentType']; ?>"><?php echo $type['paymentType']; ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Checkout" class="btnCheckout" />
        </form>

        <form method="post" action="AdminConfirmOrder.php">
            <input type="submit" value="Back" class="btnBack" />
        </form>
        
        </h1>
        </div>
    </div>
    </body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>
