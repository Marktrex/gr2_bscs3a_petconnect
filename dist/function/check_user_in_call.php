<?php
    // Include your database connection script here
    require_once 'config.php';

    $userId = $_POST['userId'];
    $channel = $_POST['channel'];

    // Prepare a SQL statement to select the from_user_id and to_user_id from the chat_message table
    $stmt = $conn->prepare("SELECT from_user_id, to_user_id FROM chat_message WHERE channel = :channel");

    // Bind the channel parameter to the SQL statement
    $stmt->bindParam(":channel", $channel);

    // Execute the SQL statement
    $stmt->execute();


    // Initialize a variable to indicate whether the user belongs to the call
    $belongsToCall = false;

    // Loop through each row in the result
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // If the userId matches either the from_user_id or to_user_id, set belongsToCall to true
        if ($userId == $row['from_user_id'] || $userId == $row['to_user_id']) {
            $belongsToCall = true;
            break;
        }
    }

    // Return a JSON response indicating whether the user belongs to the call
    header('Content-Type: application/json');
    echo json_encode(['belongsToCall' => $belongsToCall]);
?>