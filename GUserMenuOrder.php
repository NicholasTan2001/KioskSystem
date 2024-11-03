<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD19067
Student Name: Ahmad Zakwan Jazmi Bin Jamsani
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 3: Registered User (Make Order)
-->

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

$conn = new mysqli("localhost", "root", "", "kiosk");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $menuID = $_GET["menuID"];
                $menuDetails = getMenuDetails($conn, $menuID);

                $requestedQuantity = $_POST["quantity"];
                if ($requestedQuantity > $menuDetails["remainingQuantity"]) {
                    header("Location: GUserMenuOrder.php?error=Quantity exceeds available stock");
                    exit();
                }

                $itemArray = array(
                    'menuID' => $menuDetails["menuID"],
                    'name' => $menuDetails["menuName"],
                    'code' => $menuDetails["menuID"],
                    'quantity' => $requestedQuantity,
                    'price' => $menuDetails["menuPrice"],
                    'location' => $menuDetails["location"]
                );

                if (!isset($_SESSION["cart_item"])) {
                    $_SESSION["cart_item"] = array();
                }

                if (isset($_SESSION["cart_item"][$menuDetails["menuID"]])) {
                    $totalQuantity = $_SESSION["cart_item"][$menuDetails["menuID"]]["quantity"] + $requestedQuantity;
                    if ($totalQuantity <= $menuDetails["remainingQuantity"]) {
                        $_SESSION["cart_item"][$menuDetails["menuID"]]["quantity"] = $totalQuantity;
                    } else {
                        header("Location: GUserMenuOrder.php?error=Quantity exceeds available stock");
                        exit();
                    }
                } else {
                    $_SESSION["cart_item"][$menuDetails["menuID"]] = $itemArray;
                }
            }
            break;

        case "update":
            $menuID = $_GET["menuID"];
            $newQuantity = $_POST["quantity"];

            if (isset($_SESSION["cart_item"][$menuID])) {
                // Update the quantity only if it's a valid positive value
                if ($newQuantity > 0) {
                    $_SESSION["cart_item"][$menuID]["quantity"] = $newQuantity;
                } else {
                    // Remove the item if the quantity is set to zero or a negative value
                    unset($_SESSION["cart_item"][$menuID]);
                    if (empty($_SESSION["cart_item"])) {
                        unset($_SESSION["cart_item"]);
                    }
                }
            }

            break;

        case "remove":
            $menuID = $_GET["menuID"];
            if (isset($_SESSION["cart_item"][$menuID])) {
                unset($_SESSION["cart_item"][$menuID]);
                if (empty($_SESSION["cart_item"])) {
                    unset($_SESSION["cart_item"]);
                }
            }
            break;

        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}

function getMenuDetails($conn, $menuID)
{
    $sql = "SELECT m.menuID, m.menuName, m.menuPrice, dm.availabilityStatus, dm.remainingQuantity, k.location
            FROM menu m
            JOIN daily_menu dm ON m.dailyMenuID = dm.dailyMenuID
            JOIN kiosk k ON dm.foodVendorID = k.foodVendorID
            WHERE m.menuID = $menuID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return array();
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
    <div id="shopping-cart">
        <h1 class="title">
            <b>Shopping Cart<b>
            <br><br>

        <?php
        if (!empty($_SESSION["cart_item"])) {
            $total_quantity = 0;
            $total_price = 0;
        ?>
            <table class="tbl-cart" cellpadding="10" cellspacing="1" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align:left;">Name</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align:left;">Code</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align:right;" width="5%">Quantity</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align:right;" width="10%">Unit Price</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align:right;" width="10%">Price</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align:center;" width="5%">Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION["cart_item"] as $item) {
                            $menuDetails = getMenuDetails($conn, $item["code"]);
                            $item_price = $item["quantity"] * $item["price"];
                        ?>
                            <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $item["name"]; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $item["code"]; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align:right;">
                                <form method="post" action="GUserMenuOrder.php?action=update&menuID=<?php echo $item["code"]; ?>">
                                    <input type="number" class="product-quantity" name="quantity" value="<?php echo $item["quantity"]; ?>" min="1" max="<?php echo $menuDetails['remainingQuantity']; ?>">
                                    <input type="submit" value="Update" class="btnUpdate">
                                </form>
                            </td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align:right;"><?php echo "RM " . $item["price"]; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align:right;"><?php echo "RM " . number_format($item_price, 2); ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align:center;">
                                <button onclick="location.href='GUserMenuOrder.php?action=remove&menuID=<?php echo $item["code"]; ?>'" class="btnRemove">Remove</button>
                            </td>
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
                            <td style="border: 1px solid #ddd; padding: 8px;"></td>
                        </tr>
                    </tbody>
            </table>
        <?php
        } else {
        ?>
            
            <label style="font-size:20px">Your Cart is Empty</label>

        <?php
        }
        ?>
        
        <br>
        <button id="btnEmpty" onclick="location.href='GUserMenuOrder.php?action=empty'">Empty Cart</button>

        <button onclick="location.href='GUserConfirmOrder.php'" class="btnConfirmOrder">Confirm Order</button>
        <br>

        </h1>
    </div>

    <div id="product-grid">
        <h1 class="title">
            <b>Products<b>
            <br><br>
        
        <?php
        $product_query = $conn->query("SELECT m.menuID, m.menuName, m.menuPrice, dm.availabilityStatus, dm.remainingQuantity, k.location
            FROM menu m
            JOIN daily_menu dm ON m.dailyMenuID = dm.dailyMenuID
            JOIN kiosk k ON dm.foodVendorID = k.foodVendorID");

        if ($product_query === false) {
            die("Error in SQL query: " . $conn->error);
        }

        $product_array = $product_query->fetch_all(MYSQLI_ASSOC);

        if (!empty($product_array)) {
        ?>
            <table class="tbl-product" cellpadding="10" cellspacing="1" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Availability Status</th>
                        <th>Remaining Quantity</th>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($product_array as $key => $value) {
                        $remainingQuantity = $product_array[$key]["remainingQuantity"];
                    ?>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $counter; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $product_array[$key]["menuName"]; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $product_array[$key]["menuPrice"]; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $product_array[$key]["availabilityStatus"]; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $remainingQuantity; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $product_array[$key]["location"]; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;">
                                <form method="post" action="GUserMenuOrder.php?action=add&menuID=<?php echo $product_array[$key]["menuID"]; ?>">
                                    <input type="number" class="product-quantity" name="quantity" value="1" min="1" max="<?php echo $remainingQuantity; ?>" size="2" />
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px;">
                                    <input type="submit" value="Add to Cart" class="btnAdd" />
                                </form>
                            </td>
                            <td style="border: 1px solid #ddd; padding: 8px;"></td>
                        </tr>
                    <?php
                        $counter++;
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
        ?>
            <div class="no-records">No products available</div>
        <?php
        }
        ?>

        </h1>
    </div>
    </div>
    </body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>