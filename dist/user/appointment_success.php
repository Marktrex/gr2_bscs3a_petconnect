<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use MyApp\Controller\AppointmentModelController;
if(!(isset($_GET['token']) && isset($_GET['id']))){
    header("Location: ../user/403-forbidden.html");
}

//update the appointment, make it pending
$appointment = new AppointmentModelController();
$status = $appointment->make_appointment_pending($_GET['id'], $_GET['token']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo.png" type="image/png">
    <title>Appointment Successful</title>

</head>
<body>
    Appointment is successful
    <?php echo $status?>
</body>
</html>