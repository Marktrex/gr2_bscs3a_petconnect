<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect</title>

    <link rel="stylesheet" href="css/tailwind-compiling-css/output.css">

    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="tw-flex tw-items-center tw-justify-center
            tw-h-screen tw-w-screen
            tw-p-12">
    <div class="tw-flex
                tw-h-3/4 tw-w-3/4
                custom-middle-background-color">
        <div class="tw-hidden md:tw-flex tw-items-center tw-justify-center tw-flex-1">

            <img src="./image/LoginSignup/photo-deco-1.png" alt="design photo" 
            class= "tw-h-4/5">
        </div>
        <form class="tw-flex tw-flex-col tw-justify-center tw-flex-1"
         name="login" action="./function/authcode.php" method="post">
            <div class="input-container">
                <input class="input-field" type="email" placeholder="Email" name="email" id="username" required >
            </div>
            <div class="input-container password">
                <input class="input-field" type="password" placeholder="Password" name="password" id="password"
                    required>
                <i class="fa-solid fa-eye" id="show-password"></i>
            </div>
            <a href="" class="forgot-pass">
                <p>Forgot Password?</p>
            </a>
            <input type="submit" name="login" value="Login" class="loginbtn">
            <a href="signuppage.php" class="account">
                <p>Don't have an Account?<br>Sign Up</p>
            </a>
        </form>

    </div>
    <script src="./script/script.js"></script>
</body>

</html>