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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PetConnet Homepage</title>
    <link rel="stylesheet" href="../css/newlyAdded/donate.css" />
    <link rel="stylesheet" href="../css/newlyAdded/footer.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>

  <body>
  <?php require_once "../components/fixedNavbar.php"?>
    <main>
      <div class="container">
        <div class="text1">
          Help us Maintain our Purpose
          <div class="text2">Help us to Donate our Pets</div>
        </div>
      </div>

      <div class="container5">
        <div class="content-box">
          <div class="logo-with-text">
            <img src="https://picsum.photos/200/300" alt="">
            <h5>
              Your Donations Helps us to expand our animal shelter to provide more comfort
            </h5>
          </div>

          <div class="logo-with-text">
            <img src="https://picsum.photos/200/300" alt="">
            <h5>
              Provides Medical Care such as vaccinations, spaying,neutering and other Medical attentions
            </h5>
          </div>

          <div class="logo-with-text">
            <img src="https://picsum.photos/200/300" alt="">
            <h5>
              Helps us to cover the cost of important pet resources and other materials
            </h5>
          </div>
        </div>
      </div>

      <div class="container6">
        <div class="flexbox1">
          <div class="text-center1">
            <h1>Bank Transfer</h1>
          </div>
          <div class="logo">
            <!-- Your logo goes here -->
            <img src="" alt="" />
          </div>
          <div class="text-under-logo1">
            <p>Account Number: 1234-678-91011</p>
            <p>Account Name: PetConnect</p>
          </div>
        </div>

        <div class="flexbox1">
          <div class="text-center1">
            <h1>GCash</h1>
          </div>
          <div class="logo">
            <!-- Your logo goes here -->
            <img src="" alt="" />
          </div>
          <div class="text-under-logo1">
            <p>Account Number: 09293883802</p>
            <p>Account Name: MarcMarc</p>
          </div>
        </div>
      </div>

      <div class="container8">
        <h3><p class="description1">For Other Options</p></h3>
        <div class="description">
          <span>Contact us via Gmail:</span><span> PetConnect@gmail.com</span>
        </div>
        <div class="description">
          
          Contact us via Phone Number:<span>09123456789</span>
        </div>
        <div class="description">
          
          <span>
            Contact us via
            Viber:
          </span><span>09123456789</span>
        </div>
      </div>
    </main>
    <?php require_once "../components/footer.html"?>
    <?php require_once "..\components\call_across_pages.php"?>
  </body>
</html>
