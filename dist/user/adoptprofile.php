<?php
session_start(); // Add this line to start the session
require '../function/config.php';
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 
$loggedIn = isset($_SESSION['auth_user']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/newlyAdded/viewpets.css" />
    <link rel="stylesheet" href="../css/newlyAdded/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>


  <!-- Back and Searchbox -->

  <body>
  <?php require_once "../components/userNavbar.php"?>
    
    <div class="navbar">
      <a href="home.php" class="back">
        <span>• Back</span>
      </a>
      <input type="text" class="searchbox" placeholder="Search" />
    </div>

    <!-- Pet Content -->
    <?php
    $id = $_GET['id']; //gets the id of the pet
    $stmt = $conn->prepare("SELECT * FROM pets WHERE pets_id = :id"); //only checks the information of the id that you got
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the first (and likely only) row for the given pet ID
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div>
    <img class="petimg" src="../upload/<?php echo $row['image']; ?>" alt="">
</div>

<div class="petcontent">
    <img src="../upload/<?php echo $row['image']; ?>" class="petimg" alt="" />
    <div class="pettxt">
        <span class="petname"><?php echo $row['name']; ?></span>
        <p class="animal"><?php echo $row['type']; ?></p>
        <div class="list">
            <span>Breed: <?php echo $row['breed']; ?></span>
            <span>Age: <?php echo $row['age']; ?></span>
            <span>Sex: <?php echo $row['sex']; ?></span>
            <span>Date of Rescue: <?php echo $row['rescue_date']; ?></span>
        </div>
        <span class="aboutinfo">About <b><?php echo $row['name']; ?></b>:</span>
        <span><?php echo $row['about']; ?></span>
        <div>
            <button class="bookbutton">
                <span>Book Appointment</span>
            </button>
        </div>
    </div>
</div>
    
    <footer> <!--src: footer.css-->
      <div class="footer-content">
        <div  class="item logo">
          <a href="#">
          <img src="../icons/footer-logo.png" alt="logo">
          </a>
          <br>
          <div class="socmed">
            <strong>Connect with us</strong>
            <ul>
              <li><a href="#" class="fa fa-facebook"></a></li>
              <li><a href="#" class="fa fa-instagram"></a></li>
              <li><a href="#" class="fa fa-twitter"></a></li>
            </ul>
          </div>
        </div>
        <div class="item quick-links">
          <strong>Quick Links</strong>
          <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="adoptpage.php">Adopt</a></li>
            <li><a href="volunteer.php">Volunteer</a>
            </li>
            <li><a href="donatepage.php">Donate</a></li>
          </ul>
        </div>
        <div class="item about">
          <strong>About</strong>
          <ul>
            <li><a href="team.php">Team</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Address</a></li>
            <li><a href="#">Testimonials</a></li>
          </ul>
        </div>
        <div class="item Services">
          <strong>Services</strong>
        </div>
      </div>
      <div class="info">
        <div class="item content1"> 
          <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Use</a></li>
          </ul>
        </div>
        <div class="item content2">
          <p> © PetConnect 2023</p>
        </div>
      </div>
      
  </footer>
  </body>
</html>
