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
if(!isset($_SESSION['username'])){


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
?>

<!DOCTYPE html>
<html>

<link rel="stylesheet" type="text/css" href="CSS.css">

<script src="../Kiosk/Java.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<head>

<?php 

    $numRUser="0";
    $numAdmin="0";
    $numGUser="0";
    $numFVendor="0";
    $totalUser="0";
    $Yes="0";
    $No="0";
    $totalFV="0";


    $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());

    $query = "SELECT * FROM user INNER JOIN registered_user ON user.userName = registered_user.userName" or die(mysqli_connect_error());

    $result = mysqli_query($link, $query);

    
    if (mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_assoc($result)){

              $numRUser=$numRUser+1;
          
        }
      }

      $query1 = "SELECT * FROM user INNER JOIN food_vendor ON user.userName = food_vendor.userName" or die(mysqli_connect_error());

      $result1 = mysqli_query($link, $query1);
  
      
      if (mysqli_num_rows($result1) > 0){
  
        while($row = mysqli_fetch_assoc($result1)){
  
                $numFVendor=$numFVendor+1;
            
          }
        }

      $query2 = "SELECT * FROM user INNER JOIN administrator ON user.userName = administrator.userName" or die(mysqli_connect_error());
      $result2 = mysqli_query($link, $query2);
  
      
      if (mysqli_num_rows($result2) > 0){
  
        while($row = mysqli_fetch_assoc($result2)){
  
                $numAdmin=$numAdmin+1;
            
          }
        }

       $query3 = "SELECT * FROM general_user" or die(mysqli_connect_error());

       $result3 = mysqli_query($link, $query3);

       if (mysqli_num_rows($result3) > 0){

        while($row = mysqli_fetch_assoc($result3)){    
            
            $numGUser=$numGUser+1;

            }
           
         }

        $totalUser=$numFVendor+$numAdmin+$numGUser+$numRUser;

?>

<?php

 $query4 = "SELECT adminApprove FROM user INNER JOIN food_vendor ON user.userName = food_vendor.userName" or die(mysqli_connect_error());

       $result4 = mysqli_query($link, $query4);

       if (mysqli_num_rows($result4) > 0){

        while($row = mysqli_fetch_assoc($result4)){    
            
            $adminApprove=$row["adminApprove"];

            if($adminApprove=="Yes"){


              $Yes=$Yes+1;
            }
            else if($adminApprove== Null){


              $No=$No+1;
            }

            }
           
         }

         $totalFV=$Yes+$No;


?>



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

<h1 class="title"><b>Report (Food Vendor Status)</b><br><br> 
<div id="chart1"></div>


<h1 class="title"><b>Report (User List)</b><br><br> 


<div class="container" style="margin-top: 2px">
<center>
  
<div class="col-lg-8">
            <div class="card bg-secondary mb-4">
                <div class="card-body text-white">
                    <p class="h3 text-white">Total Number Of Users</p>
                    <div class="h2">
                        <span id="ship_incomp" class="fw-light"><?php echo $totalUser?></span>
                    </div>
                </div>
            </div>
        </div>
</center>
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="card bg-primary mb-2">
                <div class="card-body text-white">
                    <p class="h3 text-white" style="font-size:20px;">Administrator</p>
                    <p class="h2" style="font-size:20px;"><?php echo $numAdmin?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-success mb-2">
                <div class="card-body text-white">
                    <p class="h3 text-white" style="font-size:20px;">Registered User</p>
                    <p class="h2" style="font-size:20px;"><?php echo $numRUser?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-danger mb-2">
                <div class="card-body text-white">
                    <div class="h2">
                    <p class="h3 text-white" style="font-size:20px;">Food Vendor</p>
                    <p class="h2" style="font-size:20px;"><?php echo $numFVendor?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-warning mb-2">
                <div class="card-body text-white">
                <p class="h3 text-white" style="font-size:20px;">General User</p>
                    <p class="h2" style="font-size:20px;"><?php echo $numGUser?></p>
                </div>
            </div>
        </div>
    </div>

<center>

<div id="chart"></div>


<br>

<form class = "input-box"action="userFilter.php" method="post" >

<select class="userRoles" name="Sort">
            <option value="" selected disabled>Filter By</option>
            <option value="admin">Administrator</option>
            <option value="registeredUser">Registered User</option>
            <option value="foodVendor">Food Vendor</option>
            <option value="generalUser">General User</option>

</select><br><br>

<button class="button-28" name="userFilter" type="submit">SUBMIT</button>&emsp;
</center>
</form>

</h1>
<br><br>
<script>
     var options = {
          series: [<?php echo $numAdmin?>, <?php echo $numRUser?>, <?php echo $numGUser?>, <?php echo $numFVendor?>],
          chart: {
          width: 550,
          type: 'pie',
          background: {
             color: '#f5f5f5', // Set background color for the chart area
            foreColor: '#e3fefe', // Set text color on the chart area
           },

        },
        labels: ['Administrator', 'Registered User', 'General User', 'Food Vendor'],
        title: {
            text: 'Total Number of User : <?php echo $totalUser?> ', // Set the title of the chart
            align: 'center', // Align the title to center
            margin: 50, // Set the margin of the title
            style: {
            fontSize: '22px' // Set the font size of the title
          }
          },
          legend: {
              position: 'bottom'
          },
          responsive: [{
              breakpoint: 500,
              options: {
              chart: {
              width: 500
            },

            legend: {
              position: 'bottom'
            }
            
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      

  </script>

      <script>
              var options = {
          series: ['<?php echo $No?>', '<?php echo $Yes?>'],
          chart: {
          height: 350,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: 'Total Food Vendor',
                colors: '#D3D3D3',
                formatter: function (w) {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return <?php echo $totalFV?>
                }
              }
            }
          }
        },
        labels: ['Not Approve', 'Approve'],
        colors: ['#FF0000', '#02D8E9'],
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options);
        chart.render();  
        
      </script>

</div>
</body>

<footer>
  

<p class="footer"><b>Copyright &copy FK Food Kiosk Management System</b></p>

</footer>
</html>

