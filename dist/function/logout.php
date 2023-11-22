<?php

use MyApp\Controller\AuditModelController;
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_SESSION['auth'])) {
    $log = new AuditModelController();
    $log->activity_log($_SESSION['auth_user']['id'],"Logout","User has logged out");


    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    unset($_SESSION['user_data']);
}

header('Location: ../user/index.php');
?>