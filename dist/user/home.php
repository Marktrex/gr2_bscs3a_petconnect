<?php
require '../function/config.php';
session_start(); // Add this line to start the session
// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") {
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetConnect Homepage</title>
  <link rel="stylesheet" href="../css/newlyAdded/home-page-light.css">
  <link rel="stylesheet" href="../css/newlyAdded/footer.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <a href="index.php" class="logo">
        <img src="../icons/logo.png" alt="Logo">
      </a>
      <ul class="menu-links">
        <li><a href="home.php">Home</a></li>
        <li><a href="adoptpage-dog.php">Adopt</a></li>
        <li><a href="donatepage.php">Donate</a></li>
        <li><a href="volunteer.php">Volunteer</a></li><li class="language-item">
          <a href="#">
            <span class="material-symbols-outlined">language</span>
            English
          </a>
        </li>
          <a href="#">
            <img class="icon-user" src="../icons/icons-user.png" alt="User Icon">
          </a>
        <span id="close-menu-btn" class="material-symbols-outlined">close</span>
      </ul>
      <span id="hamburger-btn" class="material-symbols-outlined">menu</span>
    </nav>
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
        <a href="adoptpage-dog.php" class="button button-find-dog">
          Find a <br> Dog
          <img src="../icons/btn-dog.png" alt="Dog Icon" class="dog-icon">
        </a>
        <a href="adoptpage-cat.php" class="button button-find-cat">
          Find a <br>Cat
          <img src="../icons/btn-cat.png" alt="Dog Icon" class="cat-icon">
        </a>
    </div>
<!-- content-Available dog and cats-->
<h2 id="available-pet">Available Dogs For Adoption</h2>
<div class="pet-container">
    <?php
    $type = 'Dog'; // Set the type to 'Dog'
    $sql = "SELECT * FROM pets WHERE type = :type LIMIT 4"; // Adjust the SQL query to fetch only dogs and limit to 4 results
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all rows in an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $petId = $row['pets_id'];
        $imageName = $row['image'];
        $petName = $row['name'];
        ?>
        <div class="pet-card">
            <a href="adoptprofile.php?id=<?php echo $petId; ?>">
                <img class="pet-image" src="../upload/<?php echo $imageName; ?>" alt="<?php echo $petName; ?>">
            </a>
            <div class="pet-name"><?php echo $petName; ?></div>
        </div>
    <?php
    }
    ?>
</div>

<h2 id="available-pet">Available Cats For Adaption</h2>
<div class="pet-container">
    <?php
    $type = 'Cat'; // Set the type to 'Dog'
    $sql = "SELECT * FROM pets WHERE type = :type LIMIT 4"; // Adjust the SQL query to fetch only dogs and limit to 4 results
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all rows in an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $petId = $row['pets_id'];
        $imageName = $row['image'];
        $petName = $row['name'];
        ?>
        <div class="pet-card">
            <a href="adoptprofile.php?id=<?php echo $petId; ?>">
                <img class="pet-image" src="../upload/<?php echo $imageName; ?>" alt="<?php echo $petName; ?>">
            </a>
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
      <button class="button-donations" a href="donatepage.php">Go to Donations</button>
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
<!-- script for header responsive -->  
  <script>
    const header = document.querySelector("header");
    const hamburgerBtn = document.querySelector("#hamburger-btn");
    const closeMenuBtn = document.querySelector("#close-menu-btn");
    // Toggle mobile menu on hamburger button click
    hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));
    // Close mobile menu on close button click
    closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
  </script>
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
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Hide pet cards with names "Cheese" and "Stacy" when screen width is 900 pixels or less
            if ($(window).width() <= 900) {
                $(".pet-name:contains('Cheese'), .pet-name:contains('Stacy'), .pet-name:contains('Cali'), .pet-name:contains('Doja')").closest('.pet-card').hide();
            }
            // Adjust visibility on window resize
            $(window).resize(function () {
                if ($(window).width() <= 900) {
                    $(".pet-name:contains('Cheese'), .pet-name:contains('Stacy'), .pet-name:contains('Cali'), .pet-name:contains('Doja')").closest('.pet-card').hide();
                } else {
                    $(".pet-card").show();
                }
            });
        });
    </script>
    
</body>
</html>