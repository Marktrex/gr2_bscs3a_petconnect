<?php
require './function/config.php';

// Check if the appointment ID and status values are provided
if (isset($_POST['appointmentId']) && isset($_POST['status'])) {
    $appointmentId = $_POST['appointmentId'];
    $status = $_POST['status'];

    // TODO: Perform necessary validations and sanitization for the input values

    $message = '';
    if ($status == 'Accepted') {
        $message = "Good Day, Ma'am/Sir,\n\nYour appointment is confirmed. Kindly message us within 24 hours if you would like to reschedule or cancel your appointment. Thank you!\n\nVery truly yours,\nRePaw City";
    } elseif ($status == 'Cancelled') {
        $message = "Good Day, Ma'am/Sir,\n\nWe're sincerely sorry to cancel your appointment because of the sudden circumstances in our shelter. We hope for your consideration. Thank you.\n\nVery truly yours,\nRePaw City";
    }

    // Escape the message to prevent SQL injection
    $escapedMessage = mysqli_real_escape_string($conn, $message);

    // Update the status and message in the database
    $query = "UPDATE appointment SET status = '$status', message = '$escapedMessage' WHERE appointment_id = '$appointmentId'";
    $result = mysqli_query($conn, $query);

    // Check if the update was successful
    if ($result) {
        
        // Return a success response
        http_response_code(200);
        echo "Status updated successfully";
    } else {
        // Return an error response
        http_response_code(500);
        echo "Error updating status: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Return an error response if the appointment ID and status values are not provided
    http_response_code(400);
    echo "Invalid request";
}
?>
