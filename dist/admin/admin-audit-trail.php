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
if(isset($_POST['search']))
{
    $auditLogs = $audit->search([
        $_POST['user'],
        $_POST['action']
    ],[
        ['responsible_id','fname', 'lname'],
        ['type', 'table_affected']
    ]);
}
else
{
    $auditLogs = $audit->getAuditLog();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Trail</title>
    <!-- content position -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/audit-trail.css">

    <!-- for layout color -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/admin-layout-colors.css" />

    <!-- layout position -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/layout-light.css"> 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <!--Navbar-->
        <header>
            <nav class="navbar">
                <a href="#" class="logo"><img src="../icons/logo.png" alt="Logo"></a>

                <ul class="items">
                    <li><a id="messages" href="#"><i class="fa fa-envelope"></i></a></li>
                    <li><a id="notifications" href="#"><i class="fa fa-bell"></i></a></li>
                    <li><a href="#"><img src="../icons/icons-user.png" alt="Profile"></a></li>
                </ul>
            </nav>
        </header>
        <main class="content">
            <div class="wrapper">
                <h1>Activity Log</h1>

                <div class="search">
                    <form action="#" method="POST">
                        <div>
                            <label for="user"><span>Search User</span></label>
                            <input type="text" id="user" class="user" name = "user" placeholder="Search User Responsible"/>
                        </div>
                        <div>
                            <label for="action"><span>Search Action</span></label>
                            <input type="text" id="action" class="action" name = "action" placeholder="Search Action"/>
                        </div>
                        <button type = "submit" name="search" class = "searchButton">Search</button>
                    </form>
                </div>
                <section class="list-body">
                    <table id="pets-list">
                        <thead>
                            <tr id="header">
                                <th>ID</th>
                                <th>Responsible ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Affected Table</th>
                                <th>Affected Column</th>
                                <th>Affected ID</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($auditLogs as $log): ?>
                                <tr>
                                    <td><?= $log->id ?></td>
                                    <td><?= $log->responsible_id ?></td>
                                    <td>
                                        <?php
                                        if (!$log->fname)
                                        {
                                            echo "Deleted User";
                                        }
                                        else
                                        {
                                            echo $log->fname . " " . $log->lname;
                                        }
                                         ?>
                                    </td>
                                    <td><?= $log->type ?></td>
                                    <td><?= $log->table_affected?></td>
                                    <td>
                                    <?= $log->column_affected ?>
                                    </td>
                                    <td>
                                    <?= $log->id_affected ?>
                                    </td>
                                    
                                    <td>
                                    <?= $log->old_value ?>
                                    </td>
                                    <td>
                                    <?= $log->new_value ?>
                                    </td>
                                    <td>
                                        <?= $log->date_time ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
        
        <?php require_once "../components/admin/adminSidebar.php"?>        
    </div>
    <script src="../script/admin-general.js"></script>
</body>
</html>

