<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect</title>
    <link rel="stylesheet" href="css/loginpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sigmar">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
    <div class="login">
        <div class="slideshow-container">
            <img src=".\image\LoginSignup\bg1.jpg" alt="Image 1">
            <img src=".\image\LoginSignup\bg2.jpg" alt="Image 2">
            <img src=".\image\LoginSignup\bg3.jpg" alt="Image 3">
        </div>
        <a href="home.php"><img src="./image/logo (1).png" class="logo"></a>


        <form class="login-form" name="login" action="./function/authcode.php" method="post">
            <div class="content">
                <h1>WELCOME!</h1>
                <p>Let's get started</p>
            </div>
            <br>
            <div class="input-container">
                <i class="fa-regular fa-user icon"></i>
                <input class="input-field" type="email" placeholder="Email" name="email" id="username" required >
            </div>
            <div class="input-container password">
                <i class="fa-solid fa-lock icon"></i>
                <input class="input-field" type="password" placeholder="Password" name="password" id="password"
                    required>
                <i class="fa-solid fa-eye" id="show-password"></i>
            </div>
            <a href="" class="forgot-pass">
                <p></p>
            </a>
            <input type="submit" name="login" value="Login" class="loginbtn">
            <a href="signuppage.php" class="account">
                <p>Don't have an Account?<br>Sign Up</p>
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