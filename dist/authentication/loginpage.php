<?php 
    session_start();
    //check if user is already logged redirect to user/home.php if yes
    if(isset($_SESSION['auth_user'])){
        header("Location: ../user/home.php");
        exit();
    }
    if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
        $id=$_COOKIE['email'];
        $pass=$_COOKIE['password'];
    }
    else{
        $id="";
        $pass="";
    }
    ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect</title>

    <link rel="stylesheet" href="../css/tailwind-compiling-css/output.css">

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
                    relative
                    rounded-none md:rounded-[48px]">
            <div class="hidden lg:flex items-center justify-center flex-1">
                <img src="dist/image/LoginSignup/photo-deco-1.png" alt="design photo"
                class= "">
            </div>
            <form class="flex flex-col justify-center flex-1 gap-[3vh]"
             name="login" action="dist/function/authcode.php" method="post">
             <!-- intro -->
                <div class="custom-text">
                <h2 class="text-5xl font-bold">Login</h2>
                <p class="my-3">Welcome back, some of our furry friends are looking for their forever home!</p>
                </div>
                <!-- inputs -->
                <div class="mt-3 relative">
                    <i class="fa-solid fa-envelope icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input " type="email" placeholder="Email" name="email" id="username" required value="<?php echo $id?>">
                </div>
                <div class="mt-3 relative">
                    <i class="fa-solid fa-lock icon custom-important-text
                            absolute top-[3px] "></i>
                    <input class="custom-input  " type="password" placeholder="Password" name="password" id="password"
                        required value="<?php echo $pass?>">
                </div>
                <!-- checkbox -->
                <div class="flex justify-between
                            custom-text">
                    <div class="select-none ">
                        <input type="checkbox" name="remember_me" id="check"/> <label for="check" class="cursor-pointer">Remember me</label>
                    </div>
                    <a href="forgotpassword.php" class="custom-important-text hover:underline underline-offset-2">Forgot Password?</a>
                </div>
                <input type="submit" name="login" value="Login" class="custom-button">
                <section class="custom-text">
                    <div class="sign-up-container">
                    <p>Don't have an account?</p>
                   <a href="signuppage.php" span class="custom-important-text hover:underline underline-offset-2">Sign up</span></a>
                    </div>
                </section>
            </form>
        </div>
    </div>
    
    <?php require_once "../components/light-switch.php"?>
    <script src="../script/change-color-schema.js"></script>
    <script src="../script/translate.js"></script>
</body>
</html>