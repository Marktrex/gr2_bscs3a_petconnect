<?php
session_start();
require '../function/config.php';

// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
$loggedIn = isset($_SESSION['auth_user']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adopt | PetConnect</title>
    <link rel="stylesheet" href="../css/newlyAdded/donate-cat-page.css" />
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
  <?php require_once "../components/userNavbar.php"?>
    <section class="content">
      <!--Dropdown menu-->
      <div class="menu">
        <div class="dropdown">
          <label for="dropdown" class="dropdown-btn">
          <img src="../icons/puppy-icon.png" alt="icon" />
            <span>Dog</span>
            <i class="fa fa-chevron-circle-down" style="color: #f9f9f9"></i>
          </label>
          <input type="checkbox" id="dropdown" />
          <div class="dropdown-content">
            <a href="adoptpage-cat.php">
              <img src="../icons/kitty-icon.png" alt="icon" />
              <span>Cat</span>
            </a>
            <a href="adoptpage-dog.php"
              ><img src="../icons/puppy-icon.png" alt="icon" />
              <span>Dog</span>
            </a>
          </div>
        </div>

        <!--Search bar-->
        <div class="search-bar">
          <i class="fa fa-search icon" style="color: #797070"></i>
          <input
            class="input-field"
            type="text"
            placeholder="Search dogs,etc..."
          />
        </div>
      </div>
    </section>

    <main class="main-content">
      <!--For Cats-->
      <div class="cat-content">
        <h1>Meet our dogs</h1>
        <ul class="cat-select">
          <li>
            <label for="breed">Breed:</label>
            <select id="breed" name="breed">
              <option value=""></option>
              <option value="American Shorthair">American Shorthair</option>
              <option value="Bengal">Bengal</option>
              <option value="British Shorthair">British Shorthair</option>
              <option value="Burmese">Burmese</option>
              <option value="Bombay">Bombay</option>
              <option value="Calico">Calico</option>
              <option value="Chinchilla">Chinchilla</option>
              <option value="Domestic Long Hair">Domestic Long Hair</option>
              <option value="Devon Rex">Devon Rex</option>
              <option value="Exotic Shorthair">Exotic Shorthair</option>
              <option value="Himalayan">Himalayan</option>
              <option value="Main Coon">Main Coon</option>
              <option value="Munchkin">Munchkin</option>
              <option value="Persian">Persian</option>
              <option value="Puspin">Puspin</option>
              <option value="Ragdoll">Ragdoll</option>
              <option value="Russian Blue">Russian Blue</option>
              <option value="Scottish Fold">Scottish Fold</option>
              <option value="Siamese">Siamese</option>
              <option value="Sphynx">Sphynx</option>
              <option value="Other breed:">Other breed:</option>
            </select>
          </li>

          <li>
            <label for="age">Age:</label>
            <select id="age" name="age">
              <option value=""></option>
              <option value="Kitten (0-1 year)">Kitten (0-1 year)</option>
              <option value="Adult (1-10 years)">Adult (1-10 years)</option>
              <option value="Senior (>11 years)">Senior (>11 years)</option>
            </select>
          </li>

          <li>
            <label for="weight">Weight:</label>
            <select id="weight" name="weight">
              <option value=""></option>
              <option value="0-20 lbs">0-20 lbs</option>
              <option value="20-50 lbs">20-50 lbs</option>
              <option value="50-90 lbs">50-90 lbs</option>
              <option value=">90 lbs">>90 lbs</option>
            </select>
          </li>

          <li>
            <label for="sex">Sex:</label>
            <select id="sex" name="sex">
              <option value=""></option>
              <option value="Female">Female</option>
              <option value="Male">Male</option>
            </select>
          </li>
        </ul>
      </div>

      <!--Cat Info-->
      <!-- <h1>Meet Our cats</h1> -->
      <div class="display-cat">
    <?php
    $stmt = $conn->prepare("SELECT * FROM pets WHERE type = 'Dog'");
    $stmt->execute(); // Correct method call

    $cats = $stmt->fetchAll(PDO::FETCH_ASSOC); // to fetch all data

    foreach ($cats as $cat) {
    ?>
    <div class="img-bg"> 
        <img src="../upload/<?php echo $cat['image']; ?>" alt="" /> <!-- Use $cat instead of $row -->
        <p class="img-text"><?php echo $cat['name']; ?></p>
        <div class="overlay">
            <h2>Hello, it's me <?php echo $cat['name']; ?>!</h2>
            <p>
                <?php echo $cat['about']; ?>
            </p>
        </div>
    </div>
    <?php
    }
    ?>
</div>

        <!-- <div class="img-bg">
          <img src="pet-pics/August(F).jpg" alt="August(F).jpeg" />
          <p class="img-text">August</p>
          <div class="overlay">
            <h2>Hello, it's me August!</h2>
            <p>
              I am a 1 year old puspin cat. I am a female and weigh 15 lbs. I am
              very curious and loves to play with toys.
            </p>
          </div>
        </div> -->

        <!-- <div class="img-bg">
          <img src="pet-pics/AustralianMist.jpeg" alt="AustralianMist.jpeg" />
          <p class="img-text">Australian Mist</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Batchoy(F).jpg" alt="Batchoy(F).jpg" />
          <p class="img-text">Batchoy</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Birman.jpeg" alt="Birman.jpeg" />
          <p class="img-text">Birman</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Bulao.jpeg" alt="Bulao.jpeg" />
          <p class="img-text">Bulao</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Chartreux.jpeg" alt="Chartreux.jpeg" />
          <p class="img-text">Chartreux</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Choco.jpeg" alt="Choco.jpeg" />
          <p class="img-text">Choco</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Cookies(F).jpg" alt="Cookies(F).jpg" />
          <p class="img-text">Cookies</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Daphne(F).jpg" alt="Daphne(F).jpg" />
          <p class="img-text">Daphne</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Holly(F).jpg" alt="Holly(F).jpg" />
          <p class="img-text">Holly</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Javanese cat.jpeg" alt="Javanese cat.jpeg" />
          <p class="img-text">Javanese</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/korat-cat.png" alt="korat-cat.png" />
          <p class="img-text">Korat</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Madam(F).jpg" alt="Madam(F).jpg" />
          <p class="img-text">Madam</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/ManxCat.jpeg" alt="ManxCat.jpeg" />
          <p class="img-text">ManxCat</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Maya(F).jpg" alt="Maya(F).jpg" />
          <p class="img-text">Maya</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Mitoy(M).jpg" alt="Mitoy(M).jpg" />
          <p class="img-text">Mitoy</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Monami(F).jpg" alt="onami(F).jpg" />
          <p class="img-text">Monami</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Ocicat.jpeg" alt="Ocicat.jpeg" />
          <p class="img-text">Ocicat</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img
            src="pet-pics/Oriental Shorthair.jpeg"
            alt="Oriental Shorthair.jpeg"
          />
          <p class="img-text">Oriental Shorthair</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Persian.jpeg" alt="Persian.jpeg" />
          <p class="img-text">Persian</p>
          <div class="overlay">
            <h2>Hello, it's me August!</h2>
            <p></p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/RussianBlue.jpeg" alt="RussianBlue.jpeg" />
          <p class="img-text">RussianBlue</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Willow(F).jpg" alt="Willow(F).jpg" />
          <p class="img-text">Willow</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>

        <div class="img-bg">
          <img src="pet-pics/Zeus(M)_Ragdoll.jpg" alt="Zeus(M)_Ragdoll.jpg" />
          <p class="img-text">Zeus</p>
          <div class="overlay">
            <h2>Hello, it's August</h2>
            <p>I am a cat.</p>
          </div>
        </div>
      </div> -->
    </main>

    <script>
      const header = document.querySelector("header");
      const hamburgerBtn = document.querySelector("#hamburger-btn");
      const closeMenuBtn = document.querySelector("#close-menu-btn");

      // Toggle mobile menu on hamburger button click
      hamburgerBtn.addEventListener("click", () =>
        header.classList.toggle("show-mobile-menu")
      );

      // Close mobile menu on close button click
      closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
    </script>
  </body>
</html>
