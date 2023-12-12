<?php
session_start();
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../../vendor/autoload.php';
require '../function/config.php';
print_r($_SESSION);
if (!isset($_SESSION['token'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: ../user/home.php");
    exit();
} 

           
if(isset($_POST["resend"])){
        // generate token by binaryhexa 
        $token = bin2hex(random_bytes(10));
    
        //session_start ();
        $_SESSION['auth'] = true;
        $_SESSION['token'] = $token;
        $email = $_SESSION['email'];

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
        $mail->Subject="Recover your password";
        $mail->Body="<b>Dear User</b>
        <h3>We received a request to reset your password.</h3>
        <p>Here is your Recovery code to reset your password</p> 
        <b>$token</b>
        <br>
        <p>With regrads,</p>
        <b>PetConnect ^^</b>";

        if(!$mail->send()){
            ?>
                <script>
                    alert("<?php echo " Invalid Email "?>");
                </script>
            <?php
        }else{
            ?>
                <script>
                    alert("<?php echo " Email send out !  Kindly check your email inbox. "?>");
                    
                </script>
            <?php
        }
    }




if(isset($_POST["login"])){
    $token = $_SESSION['token'];
    $email = $_SESSION['email'];
    $user_email = $_POST['user_email'];
    $recover_code = $_POST['recover_code'];
    

    if($token != $recover_code){
        ?>
        <script>
            alert("Invalid Email or Recovery Code");
        </script>
        <?php
    }
    elseif ($email != $user_email) {
        ?>
        <script>
            alert("Invalid Email or Recovery Code");
        </script>
        <?php
    }
    else{

        ?>
            <script>
                alert("Recovery success! you can now reset your password");
                window.location.replace("change-password.php");
            </script>
            <?php
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="../css/newlyAdded/login-recovery.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
            
        <div class="code-container">
        <form action="#" method="POST" name="login">
            <input id="email" type="email" placeholder="Enter your Email Address" name="user_email" required><br>
            <input id="recovery-code" type="text" placeholder="Enter Recovery Code" name="recover_code"required> 
        </div>
        <div>
            <button type="submit" class="btn btn-verify" name="login">login</button>
        </div>
        </form>
        <form action="#" method="POST" name="resend">     
            <p>If you didn't recieve a code, <button type="submit" class="resend-btn" value="Resend Code" name="resend">Resend Code</button></strong></p>
        </form>
    </div>
</body>

</html>