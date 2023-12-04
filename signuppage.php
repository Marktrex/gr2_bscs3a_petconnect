<?php 
use MyApp\Controller\AuditModelController;
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'dist/function/config.php'; //PDO connection to the database



$log = new AuditModelController();//email verification
if (isset($_POST["register"])) { //code ni marc
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script language="javascript">';
        echo 'alert("Invalid email format");';
        echo 'window.location = "signuppage.php";';
        echo '</script>';
    }
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["cpassword"];

     

    //php using PDO
    $sql_check = "SELECT * FROM user WHERE email = :email";
    $stmt = $conn->prepare($sql_check);
    // Bind the parameter
    $stmt->bindParam(':email', $email);
    // Execute the query
    $stmt->execute();
    // Count the number of rows returned
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        echo '<script language="javascript">';
        echo 'alert("Email already exist");';
        echo 'window.location = "signuppage.php";';
        echo '</script>';
        $conn = null;
    } 
    else {
        if ($password == $passwordRepeat) {
            // Passwords match, proceed with insertion
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user_type = '2'; // Assuming user_type '2' is a regular user
            $user_status = 'Disabled'; // Set user_status to 'Disabled'
        
            // Insert into user table with user_status set to 'Disabled'
            $query2 = "
                INSERT INTO user (fname, lname, email, password, user_type, user_status) 
                VALUES (:fname, :lname, :email, :password, :user_type, :user_status)
            ";

            $statement2 = $conn->prepare($query2);
            $statement2->bindParam(':fname', $fname);
            $statement2->bindParam(':lname', $lname);
            $statement2->bindParam(':email', $email);
            $statement2->bindParam(':password', $password);
            $statement2->bindParam(':user_type', $user_type);
            $statement2->bindParam(':user_status', $user_status);
        
            // Execute both queries
            $conn->beginTransaction();
        
            try {
                $statement2->execute();
                $lastId = $conn->lastInsertId();
                $log = new AuditModelController();
                $log->activity_log(
                    $lastId,//responsible
                    "INSERT",//type
                    "USER",//table
                    "All",//column
                    $lastId,//id
                    "None",//old
                    "None",//new val
                );
                echo '<script language="javascript">';
                echo 'alert("Sign up successfully");';
                echo '</script>';
                            // If both queries are successful, commit the transaction
                $conn->commit();
                $otp = rand(100000,999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;
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
            
                $mail->addAddress($_POST['email']);
            
                $mail->isHTML(true);
                $mail->Subject = 'Welcome to PetConnect!';

                $mail->Body = '
                <p>Congratulations, your account has been successfully created.</p>
                <p>This is your OTP Code:</p> 
                <h3>' . $otp . '</h3>
                <p>Please click the link to verify your email address:</p>
                <p><a href="http://localhost/petconnect/dist/user/verify.php">Click to Verify</a></p>
                <p>Thank you for signing up.</p>';
          
                if(!$mail->send()){
                    throw new Exception("Mail failed to send");
                } else {
                    ?>
                    <script>
                        alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                        window.location.replace('loginpage.php');
                    </script>
                    <?php
                }  
               
              
                // echo 'window.location = "../../loginpage.php";'; 
                // echo '</script>';
            } catch (PDOException $e) {
                // If any query fails, roll back the transaction
                $conn->rollBack();
        
                ?>
                    <script>
                        alert("<?php echo "Register Failed, " . $e->getMessage() ?>");
                    </script>
                <?php
            }
        }
        else
        {
            echo '<script language="javascript">';
            echo 'alert("Password and confirm password must be the same");';
            echo 'window.location = "signupage.php";';
            echo '</script>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect</title>


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

            <!-- action="dist/function/authcode.php" -->
            <form id = "registerForm" class="flex flex-col justify-center flex-1 gap-[3vh]"
            name="signup"   method="post" autocomplete="off"> 
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
                <div class="mt-3 relative">
                    <i class="fa-solid fa-lock icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input" type="password" placeholder="Confirm Password" name="cpassword" id="confirmPassword" required>
                </div>

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