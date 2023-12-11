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
  header("Location: ../authentication/loginpage.php");
  exit();
} 

$loggedIn = isset($_SESSION['auth_user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetConnet Volunteer</title>
  <link rel="stylesheet" href="../css/newlyAdded/volunteer-page.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <?php require_once "../components/user/fixedNavbar.php"?>
  <header>
     <div class="title-container">
          <h1 id="petsTitle">Join PetConnect<br>and help us by<br>Volunteering</h1>
        </div>  
    </div>
  </header>
<!-- Content --> 
  <div class="about-container">
    <div class="volunteer-container">
      <img class="custom-image" src="../icons/picture2-volunteer.png" alt="picture2">
    </div>
    <div class="text-container">
      <div class="text-width">
        <div class="volunteer-title">Benefits</div>
        <p class="custom1-paragraph">Animal Welfare</p>
        <p class="custom2-paragraph">Volunteers contribute to their well-being by providing care and attention. This helps improve their chances of adoption and enhances their overall quality of life.</p>
        <p class="custom1-paragraph">Professional and Skill Development</p>
        <p class="custom2-paragraph">Volunteering in a pet shelter offers opportunities to develop and enhance a variety of skills. Helps build a network of contacts, and may open doors to future employment opportunities.</p>
        <p class="custom1-paragraph">Personal Fulfillment</p>
        <p class="custom2-paragraph">Volunteering often brings a sense of personal fulfillment and satisfaction. Knowing that you are making a difference in the lives of animals can be emotionally rewarding and provide a sense of purpose.</p>
      </div>
    </div>
  </div>

  <div class="about-container-1">
    <div class="text-container-1">
      <div class="text-width">
        <div class="volunteer-title-1">Requirements</div>
        <p class="custom1-paragraph-1">Age Limit</p>
        <p class="custom2-paragraph-1">Requires volunteers to be a certain age, often 15 or older.</p>
        <p class="custom1-paragraph-1">Time Commitment</p>
        <p class="custom2-paragraph-1">PetConnect has a specific time commitments or schedules for volunteers. Make sure you can commit to the required hours or shifts.</p>
        <p class="custom1-paragraph-1">Passion for Animals</p>
        <p class="custom2-paragraph-1">A passion for helping animals and creating a positive environment is often a key requirements.</p>
        <p class="custom1-paragraph-1">Responsible Behavior</p>
        <p class="custom2-paragraph-1">Shelters entrust volunteers with the care of animals, so responsibility is crucial. This includes following safety protocols, respecting guidelines, and being reliable.</p>
      </div>
    </div>
      <div class="volunteer-container-1">
        <img class="custom-image-1" src="../icons/picture3-volunteer.png" alt="picture2">
      </div>
  </div>

<!-- Apply now -->
<div class="applynow">
  <div class="applynow-container">
      <div class="applynow-title">Apply now!</div>
      <div class="applynow-text">Send us your Email and we will send the Instructions for your Application Process.</div>
    <input type="text" class="applynow-input" placeholder="Enter your Email">
  </div>
</div>

<?php require_once "../components/user/footer.html"?>
<?php require_once "..\components\call_across_pages.php"?>
<script src="..\script\user-navbar-change.js"></script>
<script type="module" src="..\script\translation.js"></script>
</body>
</html>