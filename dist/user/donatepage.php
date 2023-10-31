<?php require '../function/config.php' ?>
<?php
session_start(); // Add this line to start the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="../css/donate.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>

    <section class="home">
        <div class="top">
            <div class="title">
                <h2>Give a little, helps a lot.</h2> <br>
                <h2 class="content">DONATE to support pets in need.</h2>
            </div>
        </div>

        <div class="info-container">

            <div class="content-container"> 
                <div class="info-img">

                    <img src="../image/donDog.jpeg">
                    <img src="../image/donCat.jpeg">

                </div>

                <div class="info-content">
                    <h2>DONATE</h2>
                    <p>
                        Welcome to our pet donation page, where you have the opportunity to make a positive impact
                        on the lives of pets in need.
                        <br><br>
                        At our organization, we are passionate about ensuring that every pet has access to the care
                        and support they need to live a happy, healthy life. Unfortunately, many pets find
                        themselves in difficult situations, whether they are homeless, sick, or in need of medical
                        care that their owners cannot afford. That's where your donation can make a real difference.
                        <br><br>
                        Through your generosity, we are able to provide essential resources to pets in need,
                        including food, shelter, medical care, and other vital services. With your support, we can
                        help more pets find loving homes, receive the medical attention they require, and live the
                        lives they deserve.
                        <br><br>
                        Every donation, no matter the size, makes a difference in the lives of pets and their
                        families. Your support can help us continue to make a positive impact in the lives of pets
                        and the people who love them.
                        <br><br>
                        Thank you for considering a donation to support our mission. Together, we can create a world
                        where every pet has the chance to thrive.
                    </p>
                </div>

            </div>
            <div class="grid-container">
                <div class="card">
                    <h2>Bank Transfer</h2>
                    <hr>
                    <img src="../image/qrcode_bank.png" alt="Bank Transfer QR Code" width="240">
                    <p><strong>Account Number:</strong></p>
                    <p>0036-4007-0350</p>
                    <p><strong>Account Name:</strong></p>
                    <p>Repaw City</p>
                </div>
                <div class="card">
                    <h2>Gcash Transfer</h2>
                    <hr>
                    <img src="../image/qrcode_gcash.png" alt="Gcash Transfer QR Code" width="240">
                    <p><strong>Account Number:</strong></p>
                    <p>0912-345-6789</p>
                    <p><strong>Account Name:</strong></p>
                    <p>Repaw City</p>
                </div>
                <div class="card">
                    <h2>Cash</h2>
                    <hr style="margin-bottom:90px;">
                    <p>Please <a href="contact.php">let us know</a> when would be a good time for you to drop by the shelter. <br><br>
                        We'll be very pleased to meet you and show some of our pets that we're helping!</p>
                </div>
            </div>

        </div>
    </section>

    <?php include '../function/footer.php' ?>
</body>

</html>