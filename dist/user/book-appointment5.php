<?php
use MyApp\Controller\AuditModelController;

require_once __DIR__ . '/../../vendor/autoload.php';
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
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Prepare and execute the database query
    $query = "INSERT INTO appointment (appointment_type, appointment_date, time_slot, first_name, middle_name, last_name, mobile_number, home_address, email_address, status, user_id, message) 
    VALUES (:appointment_type, :appointment_date, :appointment_time_slot, :first_name, :middle_name, :last_name, :mobile_number, :home_address, :email_address, :status, :user_id, :message)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':appointment_type', $_SESSION['appointment_type']);
    $stmt->bindParam(':appointment_date', $_SESSION['appointment_date']);
    $stmt->bindParam(':appointment_time_slot', $_SESSION['appointment_time_slot']);
    $stmt->bindParam(':first_name', $_SESSION['first_name']);
    $stmt->bindParam(':middle_name', $_SESSION['middle_name']);
    $stmt->bindParam(':last_name', $_SESSION['last_name']);
    $stmt->bindParam(':mobile_number', $_SESSION['mobile_number']);
    $stmt->bindParam(':home_address', $_SESSION['home_address']);
    $stmt->bindParam(':email_address', $_SESSION['email_address']);
    $stmt->bindParam(':status', $_SESSION['status']);
    $stmt->bindParam(':user_id', $_SESSION['auth_user']['id']);
    $stmt->bindParam(':message', $_SESSION['message']);    
    $stmt->execute();
    $log = new AuditModelController();
    $name = $_SESSION['first_name'];
    $type = $_SESSION['appointment_type'];
    $log->activity_log($_SESSION['auth_user']['id'], "appointment", "User:$name booked an appointment type: $type");
    // Close the database connection
    $stmt = null;
    $conn = null;

    // Redirect to the next page or display a success message
    header("Location: book-appointment6.php");
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
    <link rel="stylesheet" href="../css/book-appointment5.css">
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
            <h1>Appointment Confirmation</h1>

            <div class="container">
                <form method="POST">
                    <div class="form-group">
                        <label>Please tick the checkboxes to confirm your availability and understanding of the
                            appointment details:</label>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="availability" name="availability"
                                required>
                            <label class="form-check-label" for="availability"> I confirm my availability for the
                                scheduled appointment on <?php echo date('F j, Y', strtotime($_SESSION['appointment_date'])); ?> at <?php echo $_SESSION['appointment_time_slot']; ?>.</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="location" name="location" required>
                            <label class="form-check-label" for="location">I am aware of the location/address where the
                                appointment will take place.</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="changes" name="changes" required>
                            <label class="form-check-label" for="changes"> I will notify you promptly if there are any
                                changes or if I need to reschedule the appointment.</label>
                        </div>
                    </div>

                    <div class="button-container">
                        <button type="submit" class="btnn">Submit</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</body>

</html>