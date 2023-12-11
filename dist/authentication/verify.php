<?php 
session_start();
use MyApp\Controller\AuditModelController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require '../function/config.php'; //PDO connection to the database


if (isset($_POST["resend"])){
   
    $otp = rand(100000,999999);
    $email =  $_SESSION['email'];  
    $_SESSION['otp'] = $otp;
        
    // require "vendor/phpmailer/PHPMailerAutoload.php";
    $dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
    $dotenv->load();

    $senderEmail = $_ENV['EMAIL'];
    $senderPassword = $_ENV['EMAIL_PASSWORD'];

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username = $senderEmail; // your Gmail
    $mail->Password = $senderPassword; // your Gmail App Password

    $mail->SMTPSecure = 'tls';

    $mail->Port = 587;

    $mail->setFrom($senderEmail, 'Pet Connect'); // your Gmail

    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Welcome to PetConnect!';

    $mail->Body = '
    <p>Congratulations, your account has been successfully created.</p>
    <p>This is your OTP Code:</p> 
    <h3>' . $otp . '</h3>
    <p>Thank you for signing up.</p>';

    if(!$mail->send()){
        throw new Exception("Mail failed to send");
    } else {
        ?>
        <script>
            alert("<?php echo "Resend Sucesfully, OTP sent to " . $email ?>");
            window.location.replace('verify.php');
        </script>
        <?php
    }  
}


if (isset($_POST["verify"])) {
   
    if (empty($otp_code)) {
        ?>
        <script>
            alert("Please enter the OTP code.");
        </script>
        <?php
    } elseif ($otp != $otp_code) {
        ?>
        <script>
            alert("Invalid OTP code");
        </script>
        <?php
    } else {
        try {
            // Start a transaction
            $conn->beginTransaction();

            // Update user status in the database
            $updateQuery = "UPDATE user SET user_status = 'Enabled' WHERE email = :email";
            $updateStatement = $conn->prepare($updateQuery);
            $updateStatement->bindParam(':email', $email);
            $updateStatement->execute();

            // Commit the transaction
            $conn->commit();
            ?>
            <script>
                alert("Verify account done, you may sign in now");
                window.location.replace("loginpage.php");
            </script>
            <?php
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $conn->rollBack();
            ?>
            <script>
                alert("Error updating record: <?php echo $e->getMessage(); ?>");
            </script>
            <?php
        }
    }
}
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Verification</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Verification Account</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verification Account</div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">OTP Code</label>
                                <div class="col-md-6">
                                    <input type="text" id="otp" class="form-control" name="otp_code" >
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Verify" name="verify">
                            </div>
                            <form action="#" method="POST">
                            
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Resend Code" name="resend">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>
