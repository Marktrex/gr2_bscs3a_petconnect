<?php
use MyApp\Controller\AuditModelController;
require_once __DIR__ . '/../../vendor/autoload.php';
require 'config.php';

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

    // Create a PDO instance
    try {
        $conn = new PDO("mysql:host=$dsn;dbname=petconnect", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }

    // Prepare and execute the SQL statement with placeholders to update the status and message
    $query = "UPDATE appointment SET status = :status, message = :message WHERE appointment_id = :appointmentId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);

    // Execute the query
    $success = $stmt->execute();
    

    if ($success) {
        // Return a success response
        $log = new AuditModelController();
        $log->activity_log($_SESSION['auth_user']['id'],"appointment","admin $status appointment of $appointmentId");
        http_response_code(200);
        echo "Status updated successfully";
    } else {
        // Return an error response
        http_response_code(500);
        echo "Error updating status: " . $stmt->errorInfo()[2];
    }

    // Close the database connection
    $conn = null;
} else {
    // Return an error response if the appointment ID and status values are not provided
    http_response_code(400);
    echo "Invalid request";
}
?>
