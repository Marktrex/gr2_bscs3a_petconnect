<?php

use MyApp\Controller\AuditModelController;
require_once __DIR__ . '/../../vendor/autoload.php';
session_start();

if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "1" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}

$audit = new AuditModelController();
$auditLogs = $audit->getAuditLog();

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
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Responsible ID</th>
                <th>Type</th>
                <th>Short Description</th>
                <th>Date Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($auditLogs as $log): ?>
                <tr>
                    <td><?= $log->id ?></td>
                    <td><?= $log->responsible_id ?></td>
                    <td><?= $log->type ?></td>
                    <td><?= $log->short_description ?></td>
                    <td><?= $log->date_time ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>