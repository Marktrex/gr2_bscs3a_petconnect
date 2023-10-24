<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['selectedDate'])) {
    $_SESSION['selectedDate'] = $_POST['selectedDate'];
    echo 'success';
  } else {
    echo 'error';
  }
}
?>
