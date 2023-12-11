<?php
session_start();
// change to $_SESSION['auth'] if user table
if(isset($_SESSION['auth'])) {
    $response = true;
} else {
    $response= false;
}
header('Content-Type: application/json');
echo json_encode(['loggedIn' => $response]);
?>