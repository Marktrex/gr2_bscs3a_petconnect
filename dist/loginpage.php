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
            <img src="./image/LoginSignup/photo-deco-1.png" alt="design photo" 
            class= "">
        </div>
        <form class="flex flex-col justify-center flex-1 gap-7"
         name="login" action="./function/authcode.php" method="post">
            <div class="custom-text">
                <h2 class = "text-5xl font-bold">Login</h2>
                <p class= "my-3">Welcome back, some of our furry friends are looking for their forever home!</p>
            </div>
            <div class="">
                <input class="custom-input " type="email" placeholder="Email" name="email" id="username" required >
            </div>
            <div class="mt-3">
                <input class="custom-input  " type="password" placeholder="Password" name="password" id="password"
                    required>
                    <!-- <i class="fa-solid fa-eye" id="show-password"></i> -->
            </div>
            <div class="flex justify-between
                        custom-text">
                <div class="select-none ">
                    <input type="checkbox" id="check"/>
                    <label for="check" class="cursor-pointer">Remember me</label>
                </div>
                <a href="#" class="custom-important-text hover:underline underline-offset-2">Forgot Password?</a>
            </div>
            <input type="submit" name="login" value="Login" class="custom-button">
            <section class="custom-text">
                <div class="sign-up-container">
                    <p>Don't have an account? <a href="signuppage.php">
                        <span class="custom-important-text hover:underline underline-offset-2">Sign up </span></a></p>
                </div>
            </section>
        </form>

    </div>
    <?php require_once "components/light-switch.php"?>
    <script src="./script/script.js"></script>
</body>

</html>