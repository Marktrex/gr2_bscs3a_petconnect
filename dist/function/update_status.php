<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require 'config.php';
session_start();

// Check if the appointment ID and status values are provided
if (isset($_POST['appointmentId']) && isset($_POST['status'])) {
    $appointmentId = $_POST['appointmentId'];
    $status = $_POST['status'];

    
   

    $sql = "SELECT * FROM appointment WHERE appointment_id = :appointmentId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $oldData = $stmt->fetch(PDO::FETCH_ASSOC);
    $newData = [
        'status' => $status
    ];
    

    if ($success) {
        // Return a success response
        $lastId = $conn->lastInsertId();
        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if(array_key_exists($key, $newData) && $value != $newData[$key]){
                $log->activity_log(
                    $_SESSION['auth_user']['id'],
                    "UPDATE",
                    "APPOINTMENT",
                    $key,
                    $appointmentId,
                    $value,
                    $newData[$key]
                );
            }
        }
        http_response_code(200);
        echo "Status updated successfully";
    } else {
        // Return an error response
        http_response_code(500);
        echo "Error updating status: " ;
    }

    // Close the database connection
    $conn = null;
} else {
    // Return an error response if the appointment ID and status values are not provided
    http_response_code(400);
    echo "Invalid request";
}
?>
