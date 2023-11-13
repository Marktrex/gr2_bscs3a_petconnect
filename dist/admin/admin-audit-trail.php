<?php

use MyApp\Controller\AuditModelController;
require_once __DIR__ . '/../../vendor/autoload.php';
session_start();

if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "admin" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}

$audit = new AuditModelController();
$audit = $audit->getAuditLog();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Audit Trail</title>
    <link rel="icon" href="../image/icon.png" type="image/png">
</head>
<body>
    <table>
        
    </table>
</body>
</html>