<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';

use MyApp\Controller\AppointmentModelController;


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
    header("Location: ../../user/appointment.php");
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
    $token = bin2hex(random_bytes(16));

    $appointment = new AppointmentModelController();
    $lastId = $appointment->makeAppointment($id,[
        "fname" => $fname,
        "lname" => $lname,
        "mobile_number" => $mobile,
        "home_address" => $address,
    ],[
        "user_id" => $id,
        "appointment_type" => $type,
        "appointment_date" => $date,
        "time_slot" => $time_slot,
        "status" => 'Disabled',
        "token" => $token,
    ]);
    

    //update session
    $_SESSION['auth_user']['fname'] = $fname;
    $_SESSION['auth_user']['lname'] = $lname;

    unset($_SESSION['appointment']);
    header("Location: ../../user/appointment_made.php");
}

?>