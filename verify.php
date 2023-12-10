<?php 
// session_start();
use MyApp\Controller\AuditModelController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'dist/function/config.php'; //PDO connection to the database

print_r($_SESSION);

if (isset($_POST["resend"])){
   
    $otp = rand(100000,999999);
    $email =  $_SESSION['email'];  
    $_SESSION['otp'] = $otp;
        
                // require "vendor/phpmailer/PHPMailerAutoload.php";
                $mail = new PHPMailer(true);
            
                $mail->isSMTP();
            
                $mail->Host = 'smtp.gmail.com';
            
                $mail->SMTPAuth = true;
            
                $mail->Username = 'marcdavid0902@gmail.com'; // your Gmail
                $mail->Password = 'dwhe atbh euzo cnaf'; // your Gmail App Password
            
                $mail->SMTPSecure = 'tls';
            
                $mail->Port = 587;
            
                $mail->setFrom('marcdavid0902@gmail.com'); // your Gmail
            
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
    <link rel="stylesheet" href="dist/css/newlyAdded/otp-page.css">
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
        
        </form>
        <form action="#" method="POST">
        <small>
            If you didn't recieve a code, 
            <input type="submit" value="Send Code" name="resend">
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
