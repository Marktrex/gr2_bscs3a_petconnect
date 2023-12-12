<?php 
  use MyApp\Controller\AppointmentModelController;
  require_once __DIR__ . '/../../vendor/autoload.php';
  session_start(); // Add this line to start the session
  if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
      header("Location: ../admin/admin-dashboard.php");
      exit();
  }
  if (!isset($_SESSION['auth_user'])) { 
      header("Location: ../error/403-forbidden.html");
      exit();
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirmation Page</title>
    <link rel="stylesheet" href="../css/newlyAdded/confirmation.css" />
  </head>
  <body>
    We have sent you an email to confirm your appointment. Please check your email.
  </body>
</html>
