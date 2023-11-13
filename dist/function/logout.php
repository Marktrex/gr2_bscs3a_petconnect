<?php

use MyApp\Controller\Audit;
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_SESSION['auth'])) {
    $log = new Audit($_SESSION['auth_user']['id'],"Logout","User has logged out");
    $log->activity_log();


    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    unset($_SESSION['user_data']);
}

header('Location: ../user/home.php');
?>