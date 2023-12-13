<?php
session_start(); // Add this line to start the session

require '../function/config.php';
if (!isset($_SESSION['auth_user'])) {
  // Redirect to login page if the user is not authenticated
  header("Location: ../authentication/loginpage.php");
  exit();
}

if ($_SESSION['auth_user']['role'] === "1") { 
  // Redirect to admin dashboard if the user has admin role
  header("Location: ../admin/admin-dashboard.php");
  exit();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetConnect | Homepage</title>
  <link rel="stylesheet" href="../css/newlyAdded/home-page-light.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="..\css\colorStyle\user\home-page-color.css">
</head>
<body>
<?php require_once "../components/user/fixedNavbar.php"?>
<header>
     <div class="title-container">
          <h1 id="petsTitle">Our Pets are<br>waiting for you!</h1>
          <h2 id="UnderpetsTitle">Browse Pets and Become their Bestfriend</h2>
        <div class="search-container">
            <input type="text" class="search-bar" placeholder="Search dogs, cats, etc.">
        </div>
    </div>
  </header>
<!-- content-Buttons -->
    <div class="button-container">
        <a href="adoptpage.php?type=Dog" class="button button-find-dog">
          Find a <br> Dog
          <img src="../icons/btn-dog.png" alt="Dog Icon" class="dog-icon">
        </a>
        <a href="adoptpage.php?type=Cat" class="button button-find-cat">
          Find a <br>Cat
          <img src="../icons/btn-cat.png" alt="Dog Icon" class="cat-icon">
        </a>
    </div>
<!-- content-Available dog and cats-->
<h2 id="available-pet">Available Dogs For Adoption</h2>
<div class="pet-container">
    <?php
    $type = 'Dog'; // Set the type to 'Dog'
    $sql = "SELECT * FROM pets WHERE type = :type AND isAdopted = 0 LIMIT 4";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all rows in an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {

        $petId = $row['pets_id'];
        $imageName = $row['image'];
        $petName = $row['name'];
        if (!$imageName){
          $imageName = "default.jpg";
        }
        ?>
        <div class="pet-card" onclick="window.location.href='adoptprofile.php?id=<?php echo $petId; ?>'">
            <img class="pet-image" src="../upload/petImages/<?php echo $imageName; ?>" alt="<?php echo $petName; ?>">
            <div class="pet-name"><?php echo $petName; ?></div>
        </div>
    <?php
    }
    ?>
</div>

<h2 id="available-pet">Available Cats For Adoption</h2>
<div class="pet-container">
    <?php
    $type = 'Cat'; // Set the type to 'Dog'
    $sql = "SELECT * FROM pets WHERE type = :type AND isAdopted = 0 LIMIT 4";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all rows in an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $petId = $row['pets_id'];
        $imageName = $row['image'];
        $petName = $row['name'];
        if (!$imageName){
          $imageName = "default.jpg";
        }
        ?>
        <div class="pet-card" onclick="window.location.href='adoptprofile.php?id=<?php echo $petId; ?>'">
            <img class="pet-image" src="../upload/petImages/<?php echo $imageName; ?>" alt="<?php echo $petName; ?>">
            <div class="pet-name"><?php echo $petName; ?></div>
        </div>
    <?php
    }
    ?>
</div>
<!-- Donation container -->
<div class="overall-description-container">
    <div class="title">Planning to Donate?</div>
      <div class="description-container">
        <div class="description">
          <i class="fa fa-home fa-5x"></i> Your Donations Helps us to expand our animal shelter to provide more Comfort.
        </div>
        <div class="description">
          <i class="fa fa-heartbeat"></i> Provides Medical Care such as vaccinations, spaying/neutering, and other medical attention.
        </div>
        <div class="description">
          <i class="fa fa-handshake-o"></i> Help us to cover the cost of important pet resources and other materials.
        </div>
      </div>
      <button class="button-donations" onclick="window.location.href='donatepage.php'">Go to Donations</button>
  </div>
<!-- Become a voluteers -->
  <div class="about-volunteer">
    <div class="image-volunteer">
      <img src="../icons/picture-homepage.png">
    </div>
    <div class="content-volunteer">
      <h3>Become one of our Volunteers</h3>
      <p>Help us to take care of our furry companions and Give them the care they deserve<br> Regular interaction with volunteers helps socialize animals, making them more adaptable to human companionship.</p>
      <a href="volunteer.php" class="learn-more">Learn More</a>
    </div>
  </div>


  <?php require_once "..\components\call_across_pages.php"?>
  <?php require_once "../components/user/footer.html"?>
  <?php require_once "..\components\light-switch.php"?>

</body>
</html>