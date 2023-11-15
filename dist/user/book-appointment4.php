<?php
session_start(); // Add this line to start the session
require '../function/config.php';
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store form data in session variables
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['middle_name'] = $_POST['middle_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['mobile_number'] = $_POST['mobile_number'];
    $_SESSION['home_address'] = $_POST['home_address'];
    $_SESSION['email_address'] = $_POST['email_address'];
    $_SESSION['status'] = 'Pending';
    $_SESSION['message'] = '"Your appointment is currently pending approval."';
    // Redirect to the next page or perform other actions
    header('Location: book-appointment5.php');
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
    <link rel="stylesheet" href="../css/book-appointment4.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="main">
        <div class="navbar1" id="myNavbar">
            <a href="../index.php" class="logo"><img src="../image/logo (1).png" class="img-logo"></a>
            <h1>Make an Appointment</h1>
        </div>
        <div class="progress1">
            <img src="../image/book-appointment/progressbar4.png" alt="" class="progressbar">
        </div>

        <div class="content">
            <h1>Personal Information</h1>
            <form method="POST">
                <div>
                    <label for="first-name">First Name:<span> *</span></label>
                    <input type="text" id="first-name" name="first_name" required>
                </div>

                <div>
                    <label for="middle-name">Middle Name:</label>
                    <input type="text" id="middle-name" name="middle_name">
                </div>

                <div>
                    <label for="last-name">Last Name:<span> *</span></label>
                    <input type="text" id="last-name" name="last_name" required>
                </div>

                <div>
                    <label for="mobile-number">Mobile Number:<span> *</span></label>
                    <input type="tel" id="mobile-number" name="mobile_number" required>
                </div>

                <div>
                    <label for="home-address">Home Address:<span> *</span></label>
                    <input type="text" id="home-address" name="home_address" required>
                </div>

                <div>
                    <label for="email-address">Email Address:<span> *</span></label>
                    <input type="email" id="email-address" name="email_address" required>
                </div>

                <div class="row">
                    <div class="col">
                        <a href="../book-appointment3.php" class="btnn back" style="text-decoration:none; color: black;">Back</a>
                    </div>
                    <div class="col">
                    <button type="submit" class="btnn next" style="text-decoration:none; color: black;">Next</button>
                    </div>
                </div>
            </form>

            <div class="info">
                <p>We value your privacy. Your information will not be used for purposes other than this appointment
                    application.</p>
            </div>
        </div>
    </div>
</body>

</html>
