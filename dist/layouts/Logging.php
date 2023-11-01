<!-- layout for logging in, sign up, forgot password etc -->

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect</title>

    <!-- change the link depending on the position of the file(look for output.css) -->
    <link rel="stylesheet" href="../css/tailwind-compiling-css/output.css">

    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="h-screen w-screen
            custom-background-color">
    <div class = "h-[5rem] flex justify-start items-center ps-8 custom-navbar-color">
        <a href="#">
            <img src="image/icon.png" alt="icon" class="w-[75px]">
        </a>
    </div>
    <div class = "flex items-center justify-center mt-10">
        <div class="flex gap-12
                    min-h-fit w-full
                    md:w-3/4
                    py-16 px-20
                    custom-frame
                    rounded-none md:rounded-[48px]">
            <div class="hidden lg:flex items-center justify-center flex-1">
                <!-- photo for the right(change here) -->
                <img src="../image/LoginSignup/photo-deco-1.png" alt="design photo" 
                class= "">
            </div>
            <!-- form -->
            <form class="flex flex-col justify-center flex-1 gap-7"
             name="" action="" method="">
             <!-- change here for introduction -->
                <div class="custom-text">
                    <h2 class = "text-5xl font-bold">Sample Header</h2>
                    <p class= "my-3">Welcome back, some of our furry friends are looking for their forever home!</p>
                </div>
    
                <!-- inputs  -->
                <!-- class is "custom-input(put inside a div if necessary) -->
                <div class="relative">
                    <i class="fa-regular fa-user icon custom-important-text
                            absolute top-[3px] left-1"></i>
                    <input class="custom-input " type="text" placeholder="Sample Email" name="" id="" required >
                </div>
                <div class="mt-3 relative">
                <i class="fa-solid fa-lock icon custom-important-text
                            absolute top-[3px] left-1"></i>
                    <input class="custom-input  " type="password" placeholder="Sample Passoword" name="" id=""
                        required>
                        <!-- <i class="fa-solid fa-eye" id="show-password"></i> -->
                </div>
    
                <!-- Checkbox -->
                <div class="flex justify-between
                            custom-text">
                    <div class="select-none ">
                        <input type="checkbox" id="check"/>
                        <label for="check" class="cursor-pointer">Remember me</label>
                    </div>
                    <a href="#" class="custom-important-text hover:underline underline-offset-2">Forgot Password?</a>
                </div>
    
                <!-- submit button(uses class "custom-button") -->
                <input type="submit" name="" value="" class="custom-button">
    
                <!-- This section is for redirecting -->
                <section class="custom-text">
                    <div class="sign-up-container">
                        <p>Don't have an account? <a href="">
                            <span class="custom-important-text hover:underline underline-offset-2">Sign up </span></a></p>
                    </div>
                </section>
            </form>
    
        </div>
    </div>

    <!-- For the switching light -->
    <?php require_once "components/light-switch.php"?>

    <!-- For the js script -->
    <script src="./script/script.js"></script>
</body>

</html>