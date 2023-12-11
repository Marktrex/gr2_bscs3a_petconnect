<?php 
session_start(); // Add this line to start the session
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
if (!isset($_SESSION['auth_user'])) { 
    header("Location: ../error/403-forbidden.html");
    exit();
}

if (!isset($_POST['fname'])){
    header("Location: ../user/appointment.php");
    exit();
}
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$type = $_POST['type'];
$date = $_POST['date'];
$time_slot = $_POST['time-slot'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo.png" type="image/png">
    <title>Appointment Confirmation</title>

</head>
<body>
    Appointment Confirmation
    <form action="../function/user/makeAppointment.php" method="post">
        <input type="text" name="fname" id="fname" required readonly value = "<?php echo $fname?>">
        <input type="text" name="lname" id="lname"  required readonly value = "<?php echo $lname?>">
        <input type="tel" name="mobile" id="mobile" required readonly value = "<?php echo $mobile?>">
        <input type="text" name="address" id="address" required readonly value = "<?php echo $address?>">
        <input type="text" name="type" id="type" required readonly value = "<?php echo $type?>">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date-input" required readonly value = "<?php echo $date?>">
        <input type="text" name = "time-slot" id="time-slot" required readonly value = "<?php echo $time_slot?>">
        Make sure that the above confirmation is correct. You are welcome to go back to the previous page.
        <button type="submit" name="go_back" id="submit">Go Back</button>
        <button type="submit" name="appoint" id="submit">Confirm</button>
    </form>
    <?php require_once "..\components\call_across_pages.php"?>
</body>
</html>