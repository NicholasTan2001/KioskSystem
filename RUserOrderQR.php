<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

if (!isset($_SESSION["cart_item"]) || empty($_SESSION["cart_item"])) {
    header("location: RUserMenuOrder.php?error=Your Cart is Empty");
    exit();
}

// Assuming you have a connection to the database
$conn = new mysqli("localhost", "root", "", "kiosk");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID or food vendor ID based on the role
$gUserID = null;
$rUserID = null;
$foodVendorID = null;

$username = $_SESSION['username'];
$userRoleQuery = $conn->query("SELECT userRole FROM user WHERE userName = '$username'");
$userRoleData = $userRoleQuery->fetch_assoc();
$userRole = $userRoleData['userRole'];

switch ($userRole) {
    case 'admin':
        // Admin
        $adminQuery = $conn->query("SELECT adminID FROM administrator WHERE userName = '$username'");
        $adminData = $adminQuery->fetch_assoc();
        $gUserID = $adminData['adminID'];
        break;

    case 'registeredUser':
        // Registered User
        $rUserQuery = $conn->query("SELECT rUserID FROM registered_user WHERE userName = '$username'");
        $rUserData = $rUserQuery->fetch_assoc();
        $rUserID = $rUserData['rUserID'];
        break;

    case 'foodVendor':
        // Food Vendor
        $foodVendorQuery = $conn->query("SELECT foodVendorID FROM food_vendor WHERE userName = '$username'");
        $foodVendorData = $foodVendorQuery->fetch_assoc();
        $foodVendorID = $foodVendorData['foodVendorID'];
        break;
    
}

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
$orderQR = generateQRCodeURL($gUserID, $rUserID, $foodVendorID);
$insertOrderQuery = $conn->prepare("INSERT INTO `order` (orderDate, orderStatus, totalAmount, orderQR, gUserID, rUserID, foodVendorID) VALUES (?, ?, ?, ?, ?, ?, ?)");
$insertOrderQuery->bind_param("ssdsiii", $orderDate, $orderStatus, $totalAmount, $orderQR, $gUserID, $rUserID, $foodVendorID);
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
function generateQRCodeURL($gUserID, $rUserID, $foodVendorID) {
    global $orderID;  // Use the global $orderID variable

    // You can use your preferred method to generate a QR code URL
    // For simplicity, I'll use a placeholder URL
    return 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_' . $orderID;
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

<body>


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
    <h1 class="title">
        <b>Order QR<b>
        <br><br>

        <input id="text" type="text" value="<?php echo generateQRCodeURL($gUserID, $rUserID, $foodVendorID); ?>" style="width:80%"></input>
        <br>
        <div id="qrcode"></div>
        <br>
        <a href="RUserOrderStatus.php?orderID=<?php echo $orderID; ?>" class="btnViewReceipt">View Order</a>

    </h1>

<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 200,
	height : 200
});

function makeCode () {		
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
    </body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>