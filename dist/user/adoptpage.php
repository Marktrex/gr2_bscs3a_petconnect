<?php
session_start();
require '../function/config.php';


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

// Retrieve the selected filter values from the form submission
$type = $_GET['type'] ?? $_GET['type'] ?? 'Cat';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adopt | PetConnect</title>
    <link rel="stylesheet" href="../css/newlyAdded/donate-cat-page.css" />
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
    <form action="" method="get" id= "searchForm">
      
      <section class="content">
        <!--Dropdown menu-->
        <div class="menu max-width">
          <div class="dropdown">
            <label for="dropdown" class="dropdown-btn">
              <img src="../icons/kitty-icon.png" alt="icon" id = "iconType"/>
              <span id = "selectedType"><?php echo $type ?></span>
              <i class="fa fa-chevron-circle-down" style="color: #f9f9f9"></i>
            </label>
            <input type="checkbox" id="dropdown" />
            <div class="dropdown-content">
              <label>
                <img  src="../icons/kitty-icon.png" alt="icon" />
                <span >Cat</span>
                <input <?php if($type == "Cat"){echo "checked";}?>
                type="radio" name="type" id="cat" value = "Cat" >
              </label>
              <label>
                <img src="../icons/puppy-icon.png" alt="icon" />
                <span>Dog</span>
                <input <?php if($type == "Dog"){echo "checked";}?>
                type="radio" name="type" id="dog" value="Dog" >
              </label>
            </div>
          </div>
          <!--Search bar-->
          <div class="search-bar">
            <i class="fa fa-search icon" style="color: #797070"></i>
            <input
              class="input-field"
              type="text"
              name = "name"
              placeholder="Search cats,etc..."
            />
          </div>
        </div>
      </section>
      <main class="main-content max-width">
        <!--For Cats-->
        <div class="cat-content">
          <h1>Meet our <?php echo $type."s" ?></h1>
          <ul class="cat-select">
            <li>
              <label for="breed">Breed:</label>
              <select id="breed" name="breed" >
                <option value=""></option>
                <optgroup label="Dog Breeds">
                                        <option value="Aspin">Aspin</option>
                                        <option value="Shih Tzu">Shih Tzu</option>
                                        <option value="Pomeranian">Pomeranian</option>
                                        <option value="Labrador Retriever">Labrador Retriever</option>
                                        <option value="German Shepherd">German Shepherd</option>
                                        <option value="Golden Retriever">Golden Retriever</option>
                                        <option value="Rottweiler">Rottweiler</option>
                                        <option value="Chihuahua">Chihuahua</option>
                                        <option value="Bulldog">Bulldog</option>
                                        <option value="Dalmatian">Dalmatian</option>
                                        <option value="Beagle">Beagle</option>
                                        <option value="Boxer">Boxer</option>
                                        <option value="Doberman Pinscher">Doberman Pinscher</option>
                                        <option value="Siberian Husky">Siberian Husky</option>
                                        <option value="Pug">Pug</option>
                                        <option value="Cocker Spaniel">Cocker Spaniel</option>
                                        <option value="Australian Shepherd">Australian Shepherd</option>
                                        <option value="Poodle">Poodle</option>
                                        <option value="Bichon Frise">Bichon Frise</option>
                                      <optgroup label="Cat Breeds">
                                        <option value="Persian">Persian</option>
                                        <option value="Siamese">Siamese</option>
                                        <option value="Maine Coon">Maine Coon</option>
                                        <option value="Bengal">Bengal</option>
                                        <option value="Puspin">Puspin</option>
                                        <option value="Scottish Fold">Scottish Fold</option>
                                        <option value="British Shorthair">British Shorthair</option>
                                        <option value="Ragdoll">Ragdoll</option>
                                        <option value="Sphynx">Sphynx</option>
                                        <option value="Norwegian Forest Cat">Norwegian Forest Cat</option>
                                        <option value="Russian Blue">Russian Blue</option>
                                        <option value="Exotic Shorthair">Exotic Shorthair</option>
                                        <option value="Persian Chinchilla">Persian Chinchilla</option>
                                        <option value="Himalayan">Himalayan</option>
                                        <option value="Devon Rex">Devon Rex</option>
                                        <option value="Manx">Manx</option>
                                        <option value="Cornish Rex">Cornish Rex</option>
                                        <option value="Tonkinese">Tonkinese</option>
                                        <option value="Burmese">Burmese</option>
                                        <option value="Abyssinian">Abyssinian</option>
              </select>
            </li>
            <li>
              <label for="age">Age:</label>
              <select id="age" name="age" >
                <option value=""></option>
                                    <option value="Less than 6 months">Less than 6 months</option>
                                    <option value="6 months to 5 years">6 months to 5 years</option>
                                    <option value="5 to 10 years">5 to 10 years</option>
                                    <option value="over 10 years">over 10 years</option>
              </select>
            </li>
            <li>
              <label for="weight">Weight:</label>
              <select id="weight" name="weight" >
                <option value=""></option>
                                    <option value="Less than 5 lbs">Less than 5 lbs</option>
                                    <option value="5-10 lbs">5-10 lbs</option>
                                    <option value="10-20 lbs">10-20 lbs</option>
                                    <option value="20-50 lbs">20-50 lbs</option>
                                    <option value="over 50 lbs">over 50 lbs</option>
              </select>
            </li>
            <li>
              <label for="sex">Sex:</label>
              <select id="sex" name="sex" >
                <option value=""></option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
              </select>
            </li>
          </ul>
        </div>
        <!--Cat Info-->
        <!-- <h1>Meet Our cats</h1> -->
        <div id="result" class="display-cat">
        <?php
        foreach ($pet_data as $pet) {
          $petId = $pet['pets_id'];
        ?>
          <div class="img-bg" onclick="window.location.href='adoptprofile.php?id=<?php echo $petId; ?>'">
              <img src="../upload/petImages/<?php echo $pet['image']; ?>" alt="" /> <!-- Use $cat instead of $row -->
              <p class="img-text"><?php echo $pet['name']; ?></p>
              <div class="overlay">
                  <h2>Hello, it's me <?php echo $pet['name']; ?>!</h2>
                  <p>
                      <?php echo $pet['about']; ?>
                  </p>
              </div>
          </div>
        <?php
        }
        ?>
      </main>
    </form>
    
    <?php require_once "../components/footer.html"?>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('searchForm');
        const results = document.getElementById('result');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
        });
        form.addEventListener('input', async function(e) {
            e.preventDefault();

            const url = '../function/search.php?' + new URLSearchParams(new FormData(form)).toString();
            try {
                const response = await fetch(url);
                if (!response.ok) { // if HTTP-status is 200-299
                    // get the error message from the server's response
                    throw new Error(await response.text());
                }
                const data = await response.text();
                results.innerHTML = data;
            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        });

        const type = document.querySelectorAll("input[name='type']");
        const iconType = document.getElementById('iconType');
        const selectedType = document.getElementById('selectedType');

        type.forEach(function (input) {
            input.addEventListener('change', function (e) {
              if (e.target.checked) {
                  if (e.target.value == 'dog'){
                    icon = '../icons/puppy-icon.png';
                  } else {
                    icon = "../icons/kitty-icon.png";
                  }
                  iconType.src = icon;
                  selectedType.textContent = e.target.value;
              }
              const check = document.getElementById('dropdown');
              check.checked = false;
            });
        });
    });
    </script>
  </body>
</html>
