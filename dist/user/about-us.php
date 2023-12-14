<?php
require '../function/config.php';
session_start(); // Add this line to start the session
if (!isset($_SESSION['auth_user'])) {
  // Redirect to login page if the user is not authenticated
  header("Location: ../authentication/loginpage.php");
  exit();
}

if ($_SESSION['auth_user']['role'] === "1") { 
  // Redirect to admin dashboard if the user has admin role
  header("Location: ../admin/admin-dashboard.php");
  exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetConnet Homepage</title>
  <link rel="stylesheet" href="../css/newlyAdded/about-us.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
  <link rel="stylesheet" href="..\css\colorStyle\user\about-us-color.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="..\css\colorStyle\user\about-us-color.css">
</head>

<body>
  <?php require_once "../components/user/fixedNavbar.php"?>
    <main>
      <div class="about-section">
        <div>
          <h1>About Us</h1>
            <p class="text">
            PetConnect raises awareness about the value of animal rescue and the difficulties they encounter. We advocate responsible pet ownership and emphasize issues related to animal overpopulation and abandonment.            </p>
        </div>
        <div>
        </div>
      </div>
      <div class="team">
        <h1>Our team</h1>
        <div class="flex">
          <div>
            <img src="../image/team/Airam_Aguilar.JPG" alt="">
            <p>Airam</p>
          </div>
          <div>
            <img src="../image/team/Aries_Tagle.png" alt="">
            <p>Aries</p>
          </div>
          <div>
            <img src="../image/team/Armyn Jace Ibay.jpg" alt="">
            <p>Armyn</p>
          </div>
          <div>
            <img src="../image/team/Buglosa, Kriesha Mae T.jpg" alt="">
            <p>Kriesha</p>
          </div>
          <div>
            <img src="../image/team/Marc_David.jpeg" alt="">
            <p>Marc1</p>
          </div>
          <div>
            <img src="../image/team/Mark_Kevin.jpg" alt="">
            <p>Mark2</p>
          </div>

          <div>
            <img src="../image/team/Mark_lerit.jpeg" alt="">
            <p>Mark3</p>
          </div>
          <div>
            <img src="../image/team/nyah.jpg" alt="">
            <p>Nyah</p>
          </div>

          <div>
            <img src="../image/team/Soriano, Ryand, M..jpg" alt="">
            <p>Ryand</p>
          </div>

          <div>
            <img src="../image/team/Feliciano, EJ.jpg" alt="">
            <p>Ej</p>
          </div>
        </div>
        </div>
      <div class="extraInfo">
        <div>
          <h1>
            Contact Us
          </h1>
        </div>
        <div>
          <h1>
            Address
          </h1>
        </div>
      </div>
    </main>
    <?php require_once "..\components\light-switch.php"?>
    <?php require_once "../components/user/footer.html"?>
    <?php require_once "..\components\light-switch.php"?>
</body>
</html>