<?php

use MyApp\Controller\AppointmentModelController;


require_once __DIR__ . '/../../../vendor/autoload.php';
session_start();

// Check if the appointment ID and status values are provided
if (isset($_POST['appointmentId']) && isset($_POST['status'])) {
    $appointmentId = $_POST['appointmentId'];
    $status = $_POST['status'];
    $appointment = new AppointmentModelController();
    $success = $appointment->update_appointment_admin($_SESSION['auth_user']['id'],$appointmentId, $status);
    
    if ($success) {
        http_response_code(200);
        echo "Status updated successfully";
    } else {
        // Return an error response
        http_response_code(500);
        echo "Error updating status: " ;
    }

    // Close the database connection
} else {
    // Return an error response if the appointment ID and status values are not provided
    http_response_code(400);
    echo "Invalid request";
}
?>
