<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use MyApp\Controller\AppointmentModelController;
if(!(isset($_GET['token']) && isset($_GET['id']))){
    header("Location: ../error/403-forbidden.html");
    exit();
}

$appointmentControl = new AppointmentModelController();
$appointment = $appointmentControl->get_appointment_data_by_id($_GET['id']);
//update the appointment, make it pending
$status = $appointmentControl->make_appointment_pending($_GET['id'], $_GET['token']);


//guard for empty and invalid token
if ($status == "Appointment not found" || $status == "Appointment has been process already" || $status == "Invalid Token") {
    echo "<script type='text/javascript'>
            alert('$status');
            window.location.href = '../error/403-forbidden.html';
          </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo.png" type="image/png">
    
    <title>Appointment Successful</title>
    <link rel="stylesheet" href="../css/newlyAdded/confirmation.css" />
</head>
<body>
    <?php require_once "../components/user/userNavbar.php"?>
    <main>
      <div class="container">
        <div class="content-box">
          <div class="text">
            <h2>Booking Successful</h2>
          </div>

          <div class="text2">
            <h4>
              We have successfully recorded your appointment in our database. We
              will be happy to be of service. PetConnect is eager to meet with
              you at the appointed time. Please review the appointment details
              listed below:
            </h4>
          </div>

          <div class="stacks">
            <span class="details"><h3>Details:</h3></span>
            <span class="apptype"><h3>Appointed Type: <?php echo $appointment->appointment_type?></h3></span>
            <span class="appdate"><h3>Appointed Date:  <?php echo $appointment->appointment_date?></h3></span>
            <span class="sesstime"><h3>Session Time:  <?php echo $appointment->time_slot?></h3></span>
            <span class="address"><h3>Address: Dhvsu Main</h3></span>
          </div>

          <div class="conditions">
            <h3>Conditions:</h3>
          </div>

          <div class="text3">
            <h3>
              Kindly arrive at the designated location no later that ten minutes
              before your scheduled the time of the appointment.
            </h3>
          </div>

          <div class="text4">
            <h3>
              Please send our admin a private message or email our customer
              support team at mail to petconnect@gmail.com at least
              <b>24 hours in advance</b> if you need to cancel or reschedule
              your appointment.
            </h3>
          </div>

          <a class = "exit-box" href="index.php">Home</a>
        </div>
      </div>
    </main>
    <?php require_once "../components/user/footer.html"?>
</body>
</html>