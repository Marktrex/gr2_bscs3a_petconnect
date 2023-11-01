<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Connect</title>


    <link rel="stylesheet" href="css/tailwind-compiling-css/output.css">


    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="flex items-center justify-center
            h-screen w-screen
            custom-background-color">

    <div class="flex gap-12
        min-h-fit w-full
        md:w-3/4
        py-16 px-20
        custom-frame
        rounded-none md:rounded-[48px]">
        
        <div class="hidden lg:flex items-center justify-center flex-1">
            <!-- photo for the right(change here) -->
            <img src="./image/LoginSignup/photo-deco-2.png" alt="design photo" 
            class= "">
        </div>


        <form class="flex flex-col justify-center flex-1 gap-7"
         name="signup"  action="./function/authcode.php" method="post" autocomplete="off">
            <div class="custom-text">
                <h2 class = "text-5xl font-bold">Register</h2>
                <p class= "my-3">Let's Get Started!
                                Create an account to login.</p>
            </div>

            <div class="relative">
                <i class="fa-regular fa-user icon custom-important-text
                        absolute top-[3px] left-1"></i>
                <input class="custom-input" type="text" placeholder="First Name" name="fname" id="fname" required>
            </div>
            <div class="mt-3 relative">
                <i class="fa-regular fa-user icon custom-important-text
                        absolute top-[3px] left-1"></i>
                <input class="custom-input" type="text" placeholder="Last Name" name="lname" id="lname" required>
            </div>
            <div class="mt-3 relative">
                <i class="fa-solid fa-envelope icon custom-important-text
                        absolute top-[3px] left-1"></i>
                <input class="custom-input" type="email" placeholder="Email" name="email" id="email" required>
            </div>
            <div class="mt-3 relative">
                <i class="fa-solid fa-lock icon custom-important-text
                        absolute top-[3px] left-1"></i>
                <input class="custom-input" type="text" placeholder="Password" name="password" id="password" required>
            </div>
            <div class="mt-3 relative">
                <i class="fa-solid fa-lock icon custom-important-text
                        absolute top-[3px] left-1"></i>
                <input class="custom-input" type="text" placeholder="Confirm Password" name="cpassword" id="password" required>
            </div>

            <input type="submit" name="register" value="Sign Up" class="custom-button">
            <section class="custom-text">
                <div class="sign-up-container">
                    <p>Already have an Account? <a href="loginpage.php">
                        <span class="custom-important-text hover:underline underline-offset-2">Log in </span></a></p>
                </div>
            </section>
        </form>

    </div>

    <?php require_once "components/light-switch.php"?>
    <script src="./script/script.js"></script>

    
</body>

</html>