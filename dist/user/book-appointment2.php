<?php
session_start(); // Add this line to start the session
require '../function/config.php';
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 
if (!isset($_SESSION['auth_user'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: ../user/home.php");
    exit();
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and process the form data
    $type = $_POST['type'];

    // Store the collected data in session variables
    $_SESSION['appointment_type'] = $type;
    
    header("Location: book-appointment3.php");
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
    <link rel="stylesheet" href="../css/book-appointment2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="navbar1" id="myNavbar">
        <a href="../index.php" class="logo"><img src="image/logo (1).png" class="img-logo"></a>
        <h1>Make an Appointment</h1>
    </div>
    <div class="progress1">
        <img src="../image/book-appointment/progressbar2.png" alt="" class="progressbar">
    </div>
    <div class="content">
        <h2>APPOINTMENT TYPE</h2>
        <!-- Form for Appointment Type -->
        <form method="POST">
            <select name="type" id="type" style="width: 20rem; height: 3rem;" class="type" required>
                <option value="">Select</option>
                <option value="Adopt">Adopt</option>
                <option value="Donate">Donate</option>
                <option value="Visit">Visit</option>
                <option value="Volunteer">Volunteer</option>
            </select>
            <div class="row">
                <div class="col">
                    <a href="book-appointment.php" class="btnn back" style="text-decoration:none; color: black;">Back</a>
                </div>
                <div class="col">
                    <button type="submit" class="btnn next" >Next</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
