<?php 
session_start(); 
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../../vendor/autoload.php';
require '../function/config.php';




    if(isset($_POST["recover"])){
        $email = $_POST["email"];

        

        $stmt = $conn->prepare("SELECT * FROM user WHERE email= :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();


        $rowCount = $stmt->rowCount();
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rowCount <= 0) {
            ?>
            <script>
                alert("<?php echo "Sorry, no emails exist"; ?>");
            </script>
            <?php
        } elseif ($fetch["user_status"] == "Disabled") {
            ?>
        <script>
            alert("Sorry, your account must be verified first before you recover your password!");
            window.location.replace("loginpage.php");
        </script>
        <?php
        }else{
            // generate token by binaryhexa 
            $token = bin2hex(random_bytes(10));

            //session_start ();
            $_SESSION['auth'] = true;
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;

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

            $mail->addAddress($_POST['email']);

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
                        window.location.replace("loginviatoken.php");
                    </script>
                <?php
            }
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="..\css\newlyAdded\forget-password.css">
</head>
<body>
    <div class="container">
        <h1>Forgot password?</h1>
        <p>
            You can reset your password by entering the email linked to <br>your account, and we'll send you the code to change your password. 
        </p>
        <form action="#" method="POST" >
        <div class="code-container">
            <input id="enter-email" type="email" name="email" placeholder="Enter your Email" required>
        </div>

        <div>
        <button type="submit" class="" name="recover">Send code</button>
        </div>
        </form>
    </div>
</body>

</html>