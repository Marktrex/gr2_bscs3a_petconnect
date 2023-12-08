<?php

session_start();
use Dotenv\Dotenv;

require '../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
$dotenv->load();

//until here
$data = array(
    'uid' => $_SESSION['auth_user']['id'], 
    'channel' => $_SESSION['channel']
);
echo json_encode($data);
?>