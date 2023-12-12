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
        $mail->Body='
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password | Pet Connect</title>
        </head>
        <body style = "background-color: #fdc161; font-family: Arial, Helvetica, sans-serif;">
            <div style="padding: 5vw;
                color:#127475;
                ">
                <div style="border: none; border-bottom: 1px solid rgba(242, 84, 45, 0.7); padding: 1rem 0;">
                    <img src="https://i.ibb.co/b6GMMSM/logo.png" alt="Pet Connect Logo" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1;">
                </div>
                <h2>
                    Reset Password
                </h2>
                <br>
                <p>
                    Dear <span style="font-weight: bold;">Pet Person</span>,
                </p>
                <br>
                <p>
                    We receive a request to reset your password.
                </p>
                <br>
                <p>
                    Here is your recover code: <span style="font-weight: bold;">'.$token.'</span> 
                </p>
                <br>
                <p>
                    Do not share this to others.
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