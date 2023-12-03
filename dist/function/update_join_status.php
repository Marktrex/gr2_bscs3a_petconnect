<?php
    require_once 'config.php';

    $user_id = $_POST['user_id'];
    $has_joined = $_POST['has_joined'];
    $channel = $_POST['channel'];
    $is_sender = $_POST['is_sender'];

    if ($is_sender == "true") {
        $modify = "from_has_join";
    } else {
        $modify = "receiver_has_join";
    }


    $sql = "UPDATE call_table SET $modify = :has_joined WHERE channel = :channel";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':has_joined', $has_joined);
    $statement->bindParam(':channel', $channel);
    $statement->execute();
?>