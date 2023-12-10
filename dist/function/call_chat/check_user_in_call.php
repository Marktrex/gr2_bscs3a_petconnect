<?php
    // Include your database connection script here
    require_once 'config.php';

    $userId = $_POST['userId'];
    $channel = $_POST['channel'];

    // Prepare a SQL statement to select the from_user_id and to_user_id from the chat_message table
    $stmt = $conn->prepare("
        SELECT cm.from_user_id, cm.to_user_id, ct.channel, ct.from_has_join, ct.receiver_has_join 
        FROM chat_message AS cm 
        JOIN call_table AS ct ON cm.call_id = ct.call_id 
        WHERE ct.channel = :channel
    ");

    // Bind the channel parameter to the SQL statement
    $stmt->bindParam(":channel", $channel);

    // Execute the SQL statement
    $stmt->execute();


    // Initialize a variable to indicate whether the user belongs to the call
    $belongsToCall = "You do not have access to this call";

    // Loop through each row in the result
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // If the userId matches either the from_user_id or to_user_id, set belongsToCall to true
        if ($userId == $row['from_user_id']) {
            $belongsToCall =  "Sender has joined";
            if($row['from_has_join'] == "1")
            {
                $belongsToCall = "Sender has already joined";
            }
            break;
        }
        if ($userId == $row['to_user_id']) {
            $belongsToCall = "Receiver has joined";
            if($row['receiver_has_join'] == "1")
            {
                $belongsToCall = "Receiver has already joined";
            }
            break;
        }
    }


    // Return a JSON response indicating whether the user belongs to the call
    header('Content-Type: application/json');
    echo json_encode(['belongsToCall' => $belongsToCall]);
?>