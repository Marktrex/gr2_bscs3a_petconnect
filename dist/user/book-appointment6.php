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
    <link rel="stylesheet" href="../css/book-appointment6.css">
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
            <img src="../image/book-appointment/progressbar5.png" alt="" class="progressbar">
        </div>

        <div class="content">
            <h1>Booking Successful!</h1>

            <div class="container">
                <div class="form-group">
                    <pre>
                        <h5>
                        Congratulations! Your appointment has been successfully booked. We are excited to assist you
                        with your needs and look forward to meeting you at the scheduled time. Please find the
                        details of your appointment below:

                        Appointment Details:

                        - Appointment Date:  <?php echo date('F j, Y', strtotime($_SESSION['appointment_date'])); ?><br>
                        - Appointment Time: <?php echo $_SESSION['appointment_time_slot']; ?><br>
                        - Service: <?php echo $_SESSION['appointment_type']; ?><br>
                        - Location: #135 Purok 3 Balsik, Hermosa, Bataan 2111

                        <strong>Important Information:</strong>

                        1. Arrival Time: Please arrive at the location at least 10 minutes prior to your scheduled
                        appointment time.
                        2. Cancellation or Rescheduling: If you need to cancel or reschedule your appointment,
                        kindly contact our customer support team at repawcity@gmail.com at least 24 hours
                        in advance.
                        3. Payment: Payment for the service will be collected at the time of the appointment. We
                        accept various forms of payment, including cash, credit cards, and online transfers.

                        To check the status of your appointment or make any modifications, you can log in to your 
                        profile on our website or mobile app. Your appointment details and status will be available 
                        under your profile for easy access and management.

                        Should you have any questions or require further assistance, please feel free to reach out
                        to our customer support team. We are here to ensure your experience is seamless and
                        satisfactory.

                        Thank you for choosing our services. We appreciate your trust and look forward to serving
                        you soon!

                        Best regards,
                        RePaw City
                        </h5>
                    </pre>
                </div>

                <div class="button-container">
                    <button type="submit" class="btnn" onclick="closePage()">Exit</button>
                </div>

                <script>
                    function closePage() {
                        window.close();
                    }
                </script>
            </div>


        </div>
    </div>
</body>

</html>