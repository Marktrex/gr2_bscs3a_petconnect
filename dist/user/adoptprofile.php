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
}
$loggedIn = isset($_SESSION['auth_user']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/newlyAdded/viewpets.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>


  <!-- Back and Searchbox -->

  <body>
  <?php require_once "../components/userNavbar.php"?>

    <!-- Pet Content -->
    <?php
    $id = $_GET['id']; //gets the id of the pet
    $stmt = $conn->prepare("SELECT * FROM pets WHERE pets_id = :id"); //only checks the information of the id that you got
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the first (and likely only) row for the given pet ID
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="not-petcontent">
    <img class="petimg" src="../upload/petImages/<?php echo $row['image']; ?>" alt="">
</div>

<div class="petcontent">
    <img src="../upload/petImages/<?php echo $row['image']; ?>" class="petimg" alt="" />
    <div class="pettxt">
        <span class="petname"><?php echo $row['name']; ?></span>
        <p class="animal">Animal: <?php echo $row['type']; ?></p>
        <div class="list">
            <span>Breed: <?php echo $row['breed']; ?></span>
            <span>Age: <?php echo $row['age']; ?></span>
            <span>Sex: <?php echo $row['sex']; ?></span>
            <span>Date of Rescue: <?php echo $row['date']; ?></span>
        </div>
        <span class="aboutinfo">About:</b></span>
        <span><?php echo $row['about']; ?></span>
        <div>
            <button class="bookbutton" onclick="window.location.href='book-appointment.php'"> 
                <span>Book Appointment</span>
            </button>
        </div>
    </div>
</div>
    
<?php require_once "../components/footer.html"?>
<script src="..\script\user-navbar-change.js"></script>
<script type="module" src="..\script\translation.js"></script>
  </body>
</html>
