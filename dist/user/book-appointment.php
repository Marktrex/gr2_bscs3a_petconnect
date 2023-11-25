<?php
session_start(); // Add this line to start the session
require '../function/config.php';
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
if (isset($_SESSION['auth_user'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: ../user/home.php");
    exit();
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="../css/book-appointment.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="navbar1" id="myNavbar">
        <a href="../index.php" class="logo"><img src="../image/logo (1).png" class="img-logo"></a>
        <h1>Make an Appointment</h1>
    </div>
    <div class="progress1">
        <img src="../image/book-appointment/progressbar1.png" alt="" class="progressbar">
    </div>
    <div class="content">
        <h2>SET UP AN APPOINTMENT ONLINE</h2>
        <img src="../image/book-appointment/imnotarobot.png" alt="">
        <a href="book-appointment2.php" class="get-started btnn" style="text-decoration:none; color: black;">Get Started</a>

    </div>
</body>

</html>