<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Administrator Report
-->

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

// Retrieve user ID
$username = $_SESSION['username'];
$userQuery = mysqli_query($link, "SELECT rUserID FROM registered_user WHERE userName = '$username'");
$userData = mysqli_fetch_assoc($userQuery);
$userID = $userData['rUserID'];

// Retrieve order history data for the user
$orderHistoryQuery = mysqli_query($link, "
    SELECT 
        o.orderDate,
        m.menuName,
        oi.totalPrice
    FROM 
        `order` o
    JOIN 
        `order_item` oi ON o.orderID = oi.orderID
    JOIN 
        `menu` m ON oi.menuID = m.menuID
    WHERE 
        o.rUserID = $userID
");

// Fetch all rows and store them in an array
$orderHistoryData = [];
while ($row = mysqli_fetch_assoc($orderHistoryQuery)) {
    $orderHistoryData[] = $row;
}

// Calculate the total number of orders based on menu names
$menuCounts = [];
foreach ($orderHistoryData as $row) {
    $menuName = $row['menuName'];

    if (!isset($menuCounts[$menuName])) {
        $menuCounts[$menuName] = 0;
    }

    $menuCounts[$menuName]++;
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
    <style>
        /* Add your custom styles here */
        #barchart text {
            font-size: 15px !important; /* Adjust the font size as needed */
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
      <b>Order History Report</b>
      <br><br>

<div class="container" style="margin-top: 2px">
    <center>
        <div class="col-lg-8">
            <div class="card bg-primary mb-4">
                <div class="card-body text-white">
                    <p class="h3 text-white">Total Number Of Orders</p>
                    <div class="h2">
                        <span id="total_orders" class="fw-light"><?php echo mysqli_num_rows($orderHistoryQuery); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </center>

    <div class="row mb-5 justify-content-center">
        <?php
        // Display total orders based on menu name
        foreach ($menuCounts as $menuName => $totalOrders) {
            echo '<div class="col-lg-3">
                    <div class="card bg-info mb-2">
                        <div class="card-body text-white">
                            <p class="h3 text-white" style="font-size:20px;">' . $menuName . '</p>
                            <p class="h2" style="font-size:20px;">Total Orders: ' . $totalOrders . '</p>
                        </div>
                    </div>
                </div>';
        }
        ?>
    </div>
</div>


<center>
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div id="barchart" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['bar'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Date');

            <?php
            // Create columns for each menu
            $menus = [];
            foreach ($orderHistoryData as $row) {
                $menuName = $row['menuName'];
                if (!in_array($menuName, $menus)) {
                    $menus[] = $menuName;
                    echo "data.addColumn('number', '$menuName');\n";
                }
            }

            // Build rows
            $dateData = [];
            foreach ($orderHistoryData as $row) {
                $date = date('Y-m-d', strtotime($row['orderDate']));
                $menuName = $row['menuName'];
                $totalPrice = (float)$row['totalPrice'];

                if (!isset($dateData[$date])) {
                    $dateData[$date] = array_fill_keys($menus, 0);
                }

                $dateData[$date][$menuName] += $totalPrice;
            }

            // Add data to the DataTable
            echo "data.addRows([\n";
            foreach ($dateData as $date => $menuValues) {
                $row = "['$date', ";
                foreach ($menuValues as $value) {
                    $row .= "$value, ";
                }
                $row = rtrim($row, ", ");
                $row .= "],";
                echo $row;
            }
            echo "]);\n";
            ?>

            var options = {
                chart: {
                    title: 'Order History',
                },
                hAxis: {
                    title: 'Date',
                    slantedText: true,
                    slantedTextAngle: 90
                },
                vAxis: {
                    title: 'Total Amount (RM)',
                    minValue: 0
                }
            };
            var chart = new google.charts.Bar(document.getElementById('barchart'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>

</center>


    </h1>
    </div>
    </body>

<footer>

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>
