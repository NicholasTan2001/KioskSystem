<?php
session_start();

if (!isset($_SESSION['age'])) {
    header("location: Guest.php");
}

if (!isset($_SESSION['email'])) {
    header("location: Guest.php");
}

$age = $_SESSION['age'];
$email = $_SESSION['email'];

if (!isset($_SESSION["cart_item"]) || empty($_SESSION["cart_item"])) {
    header("location: GUserMenuOrder.php?error=Your Cart is Empty");
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
    <div id="confirm-order">
        <h1 class="title">
            <b>Confirm Order<b>
        <br><br>

        <table class="tbl-confirm" cellpadding="10" cellspacing="1" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align:left;">Name</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align:left;">Code</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align:right;" width="5%">Quantity</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align:right;" width="10%">Unit Price</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align:right;" width="10%">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_quantity = 0;
                $total_price = 0;
                foreach ($_SESSION["cart_item"] as $item) {
                    $item_price = $item["quantity"] * $item["price"];
                ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $item["name"]; ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $item["code"]; ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align:right;"><?php echo $item["quantity"]; ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align:right;"><?php echo "RM " . $item["price"]; ?></td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align:right;"><?php echo "RM " . number_format($item_price, 2); ?></td>
                    </tr>
                <?php
                    $total_quantity += $item["quantity"];
                    $total_price += ($item["price"] * $item["quantity"]);
                }
                ?>
                <tr>
                    <td colspan="2" style="border: 1px solid #ddd; padding: 8px; text-align:right">Total:</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align:right"><?php echo $total_quantity; ?></td>
                    <td colspan="2" style="border: 1px solid #ddd; padding: 8px; text-align:right"><strong><?php echo "RM " . number_format($total_price, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <form method="post" action="GUserCheckout.php">
            <br>
            <input type="submit" value="Proceed to Checkout" class="btnCheckout" />
        </form>
        <form method="post" action="GUserMenuOrder.php">
            <br>
            <input type="submit" value="Cancel Order" class="btnCancelOrder" />
        </form>
        
        </h1>
        </div>
    </div>
    </body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>