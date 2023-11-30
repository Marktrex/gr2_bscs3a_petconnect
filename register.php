<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$error = '';

$success_message = '';

if(isset($_POST["register"]))
{
    session_start();

    if(isset($_SESSION['user_data']))
    {
        header('location:dist/user/home.php');
    }

    require_once('database/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserName($_POST['fname']);

    $user_object->setUserLastName($_POST['lname']);

    $user_object->setUserEmail($_POST['email']);

    $user_object->setUserPassword($_POST['password']);

    // $user_object->setUserProfile($user_object->make_avatar(strtoupper($_POST['user_name'][0])));

    $user_object->setUserStatus('Disabled');

    $user_object->setUserCreatedOn(date('Y-m-d H:i:s'));

    $user_object->setUserVerificationCode(md5(uniqid()));

    $user_data = $user_object->get_user_data_by_email();

    if(is_array($user_data) && count($user_data) > 0)
    {
        $error = 'This Email Already Register';
    }
    else
    {
        if($user_object->save_data())
        {

            $mail = new PHPMailer(true);

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'marcdavid0902@gmail.com'; // your Gmail
            $mail->Password = 'dwhe atbh euzo cnaf'; // your Gmail App Password

            $mail->SMTPSecure = 'tls';

            $mail->Port = 587;

            $mail->setFrom('marcdavid0902@gmail.com'); // your Gmail

            $mail->addAddress($user_object->getUserEmail());

            $mail->isHTML(true);

            $mail->Subject = 'Welcome to PetConnect!';

            $mail->Body = '
                
                <p>Congratulations, you account has been succesfully created.</p>
                <p>This is a verification email, please click the link to verify your email address.</p>
                <p><a href="http://localhost/petconnect/verify.php?code='.$user_object->getUserVerificationCode().'">Click to Verify</a></p>
                <p>Thank you for signing up.</p>
            ';

            $mail->send();


            $success_message = 'Verification Email sent to ' . $user_object->getUserEmail() . ', so before login first verify your email';
        }
        else
        {
            $error = 'Something went wrong try again';
        }
    }

}


?>

<?php 
// session_start();
//check if user is already logged redirect to user/home.php if yes
// if(isset($_SESSION['auth_user'])){
//     header("Location: user/home.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Connect</title>


    <link rel="stylesheet" href="dist/css/tailwind-compiling-css/output.css">


    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="h-screen w-screen
            custom-background-color">

    <div class = "flex justify-start items-center ps-8 custom-navbar-color py-6">
        <a href="#">
            <img src="dist/image/logo.png" alt="icon" class="w-[100px]" id = "logIcon">
        </a>
    </div>
    <div class = "flex items-center justify-center mt-10 mb-10">
        <div class="flex gap-12
            min-h-fit w-full
            md:max-w-[65%]
            py-16 px-20
            custom-frame
            rounded-none md:rounded-[48px]">
            
            <div class="hidden lg:flex items-center justify-center flex-1">
                <!-- photo for the right(change here) -->
                <img src="dist/image/LoginSignup/photo-deco-2.png" alt="design photo" 
                class= "">
            </div>


            <form id = "registerForm" class="flex flex-col justify-center flex-1 gap-[3vh]"
            name="signup"  method="post" autocomplete="off">
                <div class="custom-text">
                <h2 class="text-5xl font-bold" data-translate="Register">Register</h2>
                <p class="my-3" data-translate="Let's Get Started! Create an account to login.">Let's Get Started! Create an account to login.</p>
                </div>

                <div class="relative">
                    <i class="fa-regular fa-user icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input" type="text" placeholder="First Name" name="fname" id="fname" required>
                </div>
                <div class="mt-3 relative">
                    <i class="fa-regular fa-user icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input" type="text" placeholder="Last Name" name="lname" id="lname" required>
                </div>
                <div class="mt-3 relative">
                    <i class="fa-solid fa-envelope icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input" type="email" placeholder="Email" name="email" id="email" required>
                </div>
                <div class="mt-3 relative">
                    <i class="fa-solid fa-lock icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input" type="password" placeholder="Password" name="password" id="password" required>
                </div>
                <!-- <div class="mt-3 relative">
                    <i class="fa-solid fa-lock icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input" type="password" placeholder="Confirm Password" name="cpassword" id="confirmPassword" required>
                </div> -->

                <input type="submit" name="register" value="Sign Up" class="custom-button">
                <section class="custom-text">
                    <div class="sign-up-container">
                        <p data-translate="Already have an Account?">Already have an Account? </p>
                            <a href="loginpage.php" span class="custom-important-text hover:underline underline-offset-2" data-translate="login">Log in </span></a>
                    </div>
                </section>
            </form>

        </div>
    </div>

    <?php require_once "dist/components/light-switch.php"?>
    <script src="dist/script/change-color-schema.js"></script>
    <script src="dist/script/translate.js"></script>
    <script src="dist/script/password-confirm.js"></script>
</body>
</html>