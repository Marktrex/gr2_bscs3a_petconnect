<?php
require '../function/config.php';
session_start(); // Add this line to start the session
// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") {
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
?>

