<?php
session_start();
require_once '../../vendor/autoload.php';
use Dotenv\Dotenv;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use MyApp\Controller\AppointmentModelController;

$dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
$dotenv->load();


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

    //
    $email = $_ENV['EMAIL'];
    $password = $_ENV['EMAIL_PASSWORD'];
    $recipient = $_SESSION['auth_user']['email'];
    $fullname = $fname . ' ' . $lname;
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $email;                     //SMTP username
        $mail->Password   = $password;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom($email, 'Pet Connect');
        $mail->addAddress($recipient, $fullname);     //Add a recipient
    
        //Attachments
        $mail->addAttachment('../papers/Adoption-Paper.pdf', 'adoption_papers.pdf');    //Optional name
        $mail->addAttachment('../papers/Adoption-Paper-2.pdf', 'adoption_papers2.pdf');    //Optional name
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Appointment Confirmation';
        $mail->Body = '
            <h1>Appointment Confirmation</h1>
            <p>Dear ' . $fullname . ',</p>
            <p>Thank you for making an appointment with Pet Connect. To confirm your email address and enable your account, please click the link below:</p>
            <p><a href="http://localhost/repos/gr2_bscs3a_petconnect/dist/user/appointment_success.php?token=' . $token . '&id=' . $lastId . '">Confirm Email</a></p>
            <p>If you did not make this appointment, please ignore this email.</p>
            <p>Best regards,</p>
            <p>Pet Connect Team</p>
        ';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    //update session
    $_SESSION['auth_user']['fname'] = $fname;
    $_SESSION['auth_user']['lname'] = $lname;

    unset($_SESSION['appointment']);
    echo '<script language="javascript">';
    echo 'alert("Appointment has been made");';
    echo '</script>';
    header("Location: ../user/home.php");
}

?>