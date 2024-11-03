<?php
session_start();

if (!isset($_SESSION['age'])) {
    header("location: Guest.php");
    exit();
}

// Assuming you have a connection to the database
$conn = new mysqli("localhost", "root", "", "kiosk");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve order details from the database
$orderID = $_GET['orderID']; // Assuming you pass the orderID as a parameter

// Get order details with menu information
$orderDetailsQuery = $conn->query("
    SELECT 
        o.*,
        oi.quantityOrder,
        oi.totalPrice,
        m.menuName,
        m.menuPrice
    FROM 
        `order` o
    JOIN 
        `order_item` oi ON o.orderID = oi.orderID
    JOIN 
        `menu` m ON oi.menuID = m.menuID
    WHERE 
        o.orderID = $orderID
");

if ($orderDetailsQuery === false) {
    die("Error in SQL query: " . $conn->error);
}

$orderDetails = $orderDetailsQuery->fetch_assoc();

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
    <a href="GeneralUser.php"><img src="logo.png" width="90" height="70" class="d-inline-block align-top" alt=""></a>
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
        <a class="nav-link" href="GUserMenuOrder.php"><b>MAKE ORDER</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact"><b>KIOSK STATUS</b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Exit.php"><b>EXIT</b></a>
      </li>
    </ul>
  </div>
</nav>

<div class="box"><br><br>
    <h1 class="title">
        <b>Receipt<b>
        <br><br>

        <div>
            <!-- Display menu details -->
            <table class="tbl-cart" cellpadding="10" cellspacing="1" style="border-collapse: collapse; width: 100%;">
                <thead>
                <tr>
                    <th>Menu Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $orderDetails['menuName']; ?></td>
                    <td>RM<?php echo number_format($orderDetails['menuPrice'], 2); ?></td>
                    <td><?php echo $orderDetails['quantityOrder']; ?></td>
                    <td>RM<?php echo number_format($orderDetails['totalPrice'], 2); ?></td>
                </tr>
                <!-- You can loop through more rows if needed -->
                </tbody>
            </table>

            <!-- Add other order details as needed -->
            <br>
            <a href="GUserMenuOrder.php" class="btnViewReceipt">Confirm</a>
        </div>
    </h1>
</div>
</body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>
