<?php
session_start();

if (!isset($_SESSION['age'])) {
    header("location: Guest.php");
    exit();
}

if (!isset($_SESSION['email'])) {
    header("location: Guest.php");
    exit();
}

// Assuming you have a connection to the database
$conn = new mysqli("localhost", "root", "", "kiosk");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID based on email (Assuming email is unique)
$email = $_SESSION['email'];
$userIDQuery = $conn->query("SELECT gUserID FROM general_user WHERE gUserEmail = '$email'");
$userIDData = $userIDQuery->fetch_assoc();
$gUserID = $userIDData['gUserID'];

// Calculate total amount based on shopping cart
$totalAmount = 0;
if (!empty($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $totalAmount += $item["quantity"] * $item["price"];
    }
}

// Insert order data into the 'order' table
$orderDate = date('Y-m-d H:i:s');
$orderStatus = 'Ordered';  // Adjust the status as needed
$orderQR = generateQRCodeURL($gUserID);
$insertOrderQuery = $conn->prepare("INSERT INTO `order` (orderDate, orderStatus, totalAmount, orderQR, gUserID) VALUES (?, ?, ?, ?, ?)");
$insertOrderQuery->bind_param("ssdsi", $orderDate, $orderStatus, $totalAmount, $orderQR, $gUserID);
$insertOrderQuery->execute();
$orderID = $insertOrderQuery->insert_id;

// Insert order items into the 'order_item' table
foreach ($_SESSION["cart_item"] as $item) {
    $quantityOrder = $item["quantity"];
    $totalPrice = $item["quantity"] * $item["price"];
    $menuID = $item["code"];

    $insertOrderItemQuery = $conn->prepare("INSERT INTO order_item (quantityOrder, totalPrice, menuID, orderID) VALUES (?, ?, ?, ?)");
    $insertOrderItemQuery->bind_param("ddii", $quantityOrder, $totalPrice, $menuID, $orderID);
    $insertOrderItemQuery->execute();
}

// Function to generate a QR code URL
function generateQRCodeURL($gUserID) {
    global $orderID;  // Use the global $orderID variable

    // You can use your preferred method to generate a QR code URL
    // For simplicity, I'll use a placeholder URL
    return 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_' . $orderID . '_UserID_' . $gUserID;
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

<title>Order QR</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="qrcode.js"></script>
<style>
        #text {
            width: 80%;
            /* Add any styles for the input field you may need */
        }

        #qrcode {
            display: inline-block;
            margin-top: 20px; /* Adjust the top margin to center vertically */
        }
</style>
</head>

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
        <b>Order QR</b>
        <br><br>

        <input id="text" type="text" value="<?php echo generateQRCodeURL($gUserID); ?>" style="width:80%">
        <br>
        <div id="qrcode"></div>
        <br>
        <a href="GUserOrderStatus.php?orderID=<?php echo $orderID; ?>" class="btnViewReceipt">View Order</a>
    </h1>

    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 200,
            height: 200
        });

        function makeCode() {
            var elText = document.getElementById("text");

            if (!elText.value) {
                alert("Input a text");
                elText.focus();
                return;
            }

            qrcode.makeCode(elText.value);
        }

        makeCode();

        $("#text").
        on("blur", function () {
            makeCode();
        }).
        on("keydown", function (e) {
            if (e.keyCode == 13) {
                makeCode();
            }
        });
    </script>
</div>

<footer>
    <p class="footer"><b>Copyright &copy; FK Food Kiosk Management System</b></p>
</footer>

</body>
</html>