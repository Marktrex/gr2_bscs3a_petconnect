<?php
session_start();

if (isset($_POST['go_back'])) {
    $_SESSION['appointment'] = [
        "fname" =>  $_POST['fname'],
        "lname" =>  $_POST['lname'],
        "mobile" =>  $_POST['mobile'],
        "address" =>  $_POST['address'],
        "type" =>  $_POST['type'],
        "date" =>  $_POST['date'],
        "time-slot" =>  $_POST['time-slot'],
    ];
    header("Location: ../user/appointment.php");
} 


if (isset($_POST['appoint'])) {
    //variables for user profile
    $id = $_SESSION['auth_user']['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    //variable for appointment
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time_slot = $_POST['time-slot'];

    unset($_SESSION['appointment']);
    echo '<script language="javascript">';
    echo 'alert("Appointment has been made");';
    echo '</script>';
    header("Location: ../user/home.php");
}

?>