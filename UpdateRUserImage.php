<!-- 
BCS2243 WEB ENGINEERING 
Student ID: CD21062
Student Name: Nicholas Tan Kae Jer
Section: 02A
Lecturer name: Dr. Nur Shamsiah Abdul Rahman / Dr. Noorlin Mohd Alidule
Module 1: Update Image (Registered User)
-->

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$inactive_timeout = 300; // 30 minutes

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_timeout)) {
    session_unset();
    session_destroy();
    header("location: login.php");
    exit();
}

$_SESSION['last_activity'] = time();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];

    // Folder to store uploads
    $uploadFolder = "uploads/";

    // Check if the "uploads" folder exists, create it if not
    if (!file_exists($uploadFolder)) {
        mkdir($uploadFolder, 0755, true);
    }

    // Get the file information
    $fileName = $_FILES["image"]["name"];
    $tempName = $_FILES["image"]["tmp_name"];
    $error = $_FILES["image"]["error"];

    // Check if a file was uploaded without errors
    if ($error === UPLOAD_ERR_OK) {
        // Move the uploaded file to the "uploads" folder
        $targetPath = $uploadFolder . $fileName;
        move_uploaded_file($tempName, $targetPath);

        // Update the database with the file path
        $link = mysqli_connect("localhost", "root", "", "kiosk") or die(mysqli_connect_error());
        $query = "UPDATE registered_user SET rUserImage = '$targetPath' WHERE userName = '$username'";
        $result = mysqli_query($link, $query);

        if ($result) {
            echo '<script>alert("Image uploaded and updated successfully!")</script>';
            echo '<script type="text/javascript">window.history.back();</script>';
        } else {
            echo '<script>alert("Error updating image in the database.")</script>';
            echo '<script type="text/javascript">window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Error uploading image. Please try again.")</script>';
        echo '<script type="text/javascript">window.history.back();</script>';
    }
}
?>