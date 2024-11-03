<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
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
    <style>
        /* Add your custom styles here */
        label {
            font-size: 15px; /* Adjust the font size as needed */
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            text-align: center;
        }
    </style>
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
        <b>Order Status<b>
    <br><br>

    <div>
    <label>Order ID: <?php echo $orderDetails['orderID']; ?></label><br>
    <label>Order Date: <?php echo $orderDetails['orderDate']; ?></label><br>
    <label>Total Amount: RM<?php echo number_format($orderDetails['totalAmount'], 2); ?></label><br>
    <label>Order Status: <?php echo $orderDetails['orderStatus']; ?></label><br>

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
        <a href="AdminReceipt.php?orderID=<?php echo $orderID; ?>" class="btnViewReceipt">Confirm</a>
    </div>
    </h1>
    </div>
    </body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>
