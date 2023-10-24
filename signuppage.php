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
    <title>rePaw City</title>
    <link rel="stylesheet" href="css/signuppage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sigmar">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
    <div class="signup">
        <div class="slideshow-container">
            <img src=".\image\LoginSignup\bg1.jpg" alt="Image 1">
            <img src=".\image\LoginSignup\bg2.jpg" alt="Image 2">
            <img src=".\image\LoginSignup\bg3.jpg" alt="Image 3">
        </div>
        <a href="index.php"><img src="./image/logo (1).png" class="logo"></a>


        <form class="signup-form" name="signup"  action="./function/authcode.php" method="post" autocomplete="off">
            <div class="content">
                <h1>Create an Account</h1>
                <p class="sub-title">Let's get started!</p>
            </div>
            <br>
            <div class="input-container">
                <i class="fa-regular fa-user icon"></i>
                <input class="input-field" type="text" placeholder="First Name" name="fname" id="fname" required>
            </div>
            <div class="input-container">
                <i class="fa-regular fa-user icon"></i>
                <input class="input-field" type="text" placeholder="Last Name" name="lname" id="lname" required>
            </div>
            <div class="input-container">
                <i class="fa-solid fa-envelope icon"></i>
                <input class="input-field" type="email" placeholder="Email" name="email" id="email" required>
            </div>
            <div class="input-container">
                <i class="fa-solid fa-lock icon"></i>
                <input class="input-field" type="text" placeholder="Password" name="password" id="password" required>
            </div>
            <div class="input-container">
                <i class="fa-solid fa-lock icon"></i>
                <input class="input-field" type="text" placeholder="Confirm Password" name="cpassword" id="password" required>
            </div>
            <input type="submit" name="register" value="Sign Up" class="signupbtn">
            <a href="loginpage.php" class="content">
                <p>Already have an Account?<br>Log in</p>
            </a>
        </form>

    </div>
    <script src="./script/script.js"></script>

    <script>
        var slideIndex = 0;
        var slides = document.getElementsByClassName("slideshow-container")[0].getElementsByTagName("img");

        function showSlides() {
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.opacity = 0;
            }

            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            slides[slideIndex - 1].style.opacity = 1;

            setTimeout(showSlides, 4000); // Delay between slides (2 seconds)
        }

        showSlides();
    </script>
</body>

</html>