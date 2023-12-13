<?php 
// session_start();
// print_r($_SESSION);
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use MyApp\Controller\AuditModelController;

require '../../vendor/autoload.php';
require '../function/config.php'; //PDO connection to the database
// if (!isset($_SESSION['auth_user'])) {
//     // Redirect to login page if the user is not authenticated
//     header("Location: ../authentication/loginpage.php");
//     exit();
//   }
  
if (isset($_SESSION['auth_user'])) {
    // Check if the role is equal to 1 and email is set
    if ($_SESSION['auth_user']['role'] === "1" && isset($_SESSION['email'])) {
        // Redirect to admin dashboard if the user has admin role and email is set
        header("Location: ../admin/admin-dashboard.php");
        exit();
    }
    // Redirect to a different page if the role is not equal to 1 or email is not set (optional)
    else {
        header("Location: ../some-other-page.php");
        exit();
    }
}


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
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verify Email | Pet Connect</title>
    </head>
    <body style = "background-color: #fdc161;font-family: Arial, Helvetica, sans-serif;">
        <div style="padding: 5vw;
            color:#127475;
            ">
            <div style="border: none; border-bottom: 1px solid rgba(242, 84, 45, 0.7); padding: 1rem 0;">
                <img src="https://i.ibb.co/b6GMMSM/logo.png" alt="Pet Connect Logo" style="border-radius: 50%;
                height: 10vw; width: 12vw; aspect-ratio: 1/1;">
            </div>
            <h2>
                Email Verification
            </h2>
            <br>
            <p>
                Dear <span style="font-weight: bold;">Pet Person </span>,
            </p>
            <br>
            <p>
                Thank you for signing up with PetConnect. Please use the provided One Time Password (OTP) to access your account.

            </p>
            <br>
            <p>
                Your OTP Code is: <span style="font-weight: bold;">' . $otp .'</span> 
            </p>
            <br>
            <p>
                Do not share your OTP to others. 
            </p>
            <br>
            <p>
                If you think this is a mistake, send us an email to <span style="text-decoration: underline;
                font-weight: bold; font-style: italic;">PetConnect@gmail.com</span>
            </p>
            <br>
            <p>
                Sincerely,
            </p>
            <p style="font-weight: bold;">
                PetConnect
            </p>
        </div>
    </body>
    </html>
    ';

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


// Assuming $conn and $email are defined elsewhere in your code

if (isset($_POST["verify"])) {
    $email = $_SESSION['email']; // Add this line to set $email

    $otp_code = '';
    // Concatenate the values from each input field to form the complete OTP
    $otp_code .= isset($_POST['otp_1']) ? $_POST['otp_1'] : '';
    $otp_code .= isset($_POST['otp_2']) ? $_POST['otp_2'] : '';
    $otp_code .= isset($_POST['otp_3']) ? $_POST['otp_3'] : '';
    $otp_code .= isset($_POST['otp_4']) ? $_POST['otp_4'] : '';
    $otp_code .= isset($_POST['otp_5']) ? $_POST['otp_5'] : '';
    $otp_code .= isset($_POST['otp_6']) ? $_POST['otp_6'] : '';

    $otp = $_SESSION["otp"];

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
            $updateStatement->bindParam(':email', $email); // Assuming $email is defined somewhere
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
            // Log the error for further analysis
            error_log("Error updating record: " . $e->getMessage(), 0);
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otp  |   Petconnect</title>
    <link rel="stylesheet" href="../css/newlyAdded/otp-page.css">
</head>
<body>
    <div class="container">
        <h1>Verify Your Account</h1><br>
        <p>
            We emailed you the six digit code to your email account <br>
            Enter the code below to confirm your email address
        </p>
        <form action="#" method="POST">
            <div class="code-container">
                <input type="number" class="code" name="otp_1" placeholder="0" min="0" max="9" required>
                <input type="number" class="code" name="otp_2" placeholder="0" min="0" max="9" required>
                <input type="number" class="code" name="otp_3" placeholder="0" min="0" max="9" required>
                <input type="number" class="code" name="otp_4" placeholder="0" min="0" max="9" required>
                <input type="number" class="code" name="otp_5" placeholder="0" min="0" max="9" required>
                <input type="number" class="code" name="otp_6" placeholder="0" min="0" max="9" required>
            </div>
            <div>
                <button type="submit" class="btn btn-verify" name="verify">Verify</button>
            </div>
        </form>
        
        
        <form action="#" method="POST">
        <small>
            If you didn't recieve a code, 
            <button type="submit" class="resend-btn" value="Send Code" name="resend">Resend Code</button>
        </small>
        </form>
    </div>
</body>

<script>
    const codes = document.querySelectorAll(".code")
     
     codes[0].focus()

     codes.forEach((code, idx) => {
        code.addEventListener('keydown', (e) => {
            if(e.key >= 0 && e.key <=9) {
                codes[idx].value = ''
                setTimeout(() => codes[idx + 1].focus(), 10)
            } else if(e.key === 'Backspace') {
                setTimeout(() => codes[idx - 1].focus(), 10)
            }
        })
     });
</script>
</html>
