<?php

session_start();
use Dotenv\Dotenv;

require '../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
$dotenv->load();

$data = array(
    'token' => $_SESSION['token'],
    'channelName' => $_SESSION['channel'],
    'appId' => $_ENV['APP_ID']
);
echo json_encode($data);
?>