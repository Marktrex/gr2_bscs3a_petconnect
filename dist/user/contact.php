<?php
session_start();
require '../function/config.php';

// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
if (!isset($_SESSION['auth_user'])) { 
  echo '<script language="javascript">';
  echo 'alert("You do not have access to this page");';
  echo '</script>';
  header("Location: ../loginpage.php");
  exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect | Contact</title>
    <link rel="stylesheet" href="../css/contact.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>
    <section class="home">
        <div class="contact-wrapper">
            <div class="contact-container">
                <div class="contact-heading">
                    <h2>Contact Us</h2>
                </div>
                <div class="contact-info">
                    <p>
                        We're thrilled that you're interested in connecting with us. If you have questions or feedback,
                        don't hesitate to reach out. Our team is ready to assist you and provide the information you
                        need.
                        We look forward to connecting with you! We appreciate your interest and can't wait to hear from
                        you!
                    </p>
                    <hr class="horizontal-line">
                    <p>
                        <strong><i class="fas fa-phone fa-lg"></i></strong> +63 923 4897 632
                    </p>
                    <p>
                        <strong><i class="fas fa-envelope fa-lg"></i></strong> repawcity@gmail.com
                    </p>
                    <p class="address">
                        <strong><i class="fas fa-map-marker-alt fa-lg"></i></strong> #135 Purok 3, Balsik,
                        Hermosa, Bataan, Philippines 2111
                    </p>
                    <hr class="horizontal-line">
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d619.8446481048363!2d120.4906345!3d14.862239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396f20a82a1a269%3A0x0!2s14%C2%B051&#39;44.1%22N%20120%C2%B029&#39;26.3%22E!5e0!3m2!1sen!2sus!4v1626317845211!5m2!1sen!2sus"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

        </div>

    </section>

    <?php include '../function/footer.php' ?>

</body>

</html>