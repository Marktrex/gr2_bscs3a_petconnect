<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'dist/function/config.php';
print_r($_SESSION);
if (!isset($_SESSION['token'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: home.php");
    exit();
} 

           
        if(isset($_POST["resend"])){
             // generate token by binaryhexa 
             $token = bin2hex(random_bytes(10));
            
             //session_start ();
             $_SESSION['auth'] = true;
             $_SESSION['token'] = $token;
             $email = $_SESSION['email'];
 
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
                     alert("Recovery succes! you can now reset your password");
                       window.location.replace("dist/user/change-password.php");
                 </script>
                 <?php
            }
    
        }

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
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
        <a class="navbar-brand" href="#">Login Form</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="font-weight:bold; color:black; text-decoration:underline">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="login">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="user_email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Recovery Code</label>
                                <div class="col-md-6">
                                    <input type="text" id="recover_code" class="form-control" name="recover_code" required>
                                    
                                </div>
                            </div>

                           

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Login" name="login">
                            </div>
                    </div>
                    </form>
                    <form action="#" method="POST" name="resend">
                    <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Resend Code" name="resend">
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
<!-- <script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script> -->
