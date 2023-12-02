<?php 
session_start(); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'dist/function/config.php';
print_r($_SESSION);



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
            window.location.replace("../../signuppage.php");
        </script>
        <?php
        }else{
            // generate token by binaryhexa 
            $token = bin2hex(random_bytes(10));

            //session_start ();
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;

            $mail = new PHPMailer(true);

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'marcdavid0902@gmail.com'; // your Gmail
            $mail->Password = 'dwhe atbh euzo cnaf'; // your Gmail App Password

            $mail->SMTPSecure = 'tls';

            $mail->Port = 587;

            $mail->setFrom('marcdavid0902@gmail.com'); // your Gmail

            $mail->addAddress($_POST['email']);

            $mail->isHTML(true);
            $mail->Subject="Recover your password";
            $mail->Body="<b>Dear User</b>
            <h3>We received a request to reset your password.</h3>
            <p>Kindly click the below link to reset your password</p> 
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
                        window.location.replace("dist/user/loginviatoken.php");
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

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>PetConnect | Forgot Password</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">User Password Recover</a>
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
                <div class="card-header">Enter Your Email</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="recover_psw">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                    <input type="submit" value="Recover" name="recover">
                                </div>
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


