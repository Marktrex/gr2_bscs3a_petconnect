<?php
session_start();
require '../function/config.php';

// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
$loggedIn = isset($_SESSION['auth_user']);

// Retrieve the selected filter values from the form submission
$type = $_POST['type'] ?? $_GET['type'] ?? 'Cat';
$breed = $_POST['breed'] ?? '';
$sex = $_POST['sex'] ?? '';
$weight = $_POST['weight'] ?? '';
$age = $_POST['age'] ?? '';

try { //research this try catch method
   
    // Build the base query
    $query = "SELECT * FROM pets WHERE 1=1";

    // Create an array to hold the values for binding
    $values = [];

    // Add filters to the query if they are selected
    if (!empty($type)) {
        $query .= " AND type = :type";
        $values[':type'] = $type;
    }
    if (!empty($sex)) {
        $query .= " AND sex = :sex";
        $values[':sex'] = $sex;
    }
    if (!empty($weight)) {
        $query .= " AND weight = :weight";
        $values[':weight'] = $weight;
    }
    if (!empty($age)) {
        $query .= " AND age = :age";
        $values[':age'] = $age;
    }

    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Bind the values to the placeholders
    foreach ($values as $key => $value) {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }

    // Execute the statement
    $stmt->execute();

    // Fetch the pet data
    $pet_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
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
    <form action="" method="post">
      
      <section class="content">
        <!--Dropdown menu-->
        <div class="menu">
          <div class="dropdown">
            <label for="dropdown" class="dropdown-btn">
              <img src="../icons/kitty-icon.png" alt="icon" />
              <span><?php echo $type ?></span>
              <i class="fa fa-chevron-circle-down" style="color: #f9f9f9"></i>
            </label>
            <input type="checkbox" id="dropdown" />
            <div class="dropdown-content">
              <label>
                <img src="../icons/kitty-icon.png" alt="icon" />
                <span>Cat</span>
                <input <?php if($type == "Cat"){echo "checked";}?>
                type="radio" name="type" id="cat" value = "Cat" onchange="this.form.submit()">
              </label>
              <label>
                <img src="../icons/puppy-icon.png" alt="icon" />
                <span>Dog</span>
                <input <?php if($type == "Dog"){echo "checked";}?>
                type="radio" name="type" id="dog" value="Dog" onchange="this.form.submit()">
              </label>
            </div>
          </div>
          <!--Search bar-->
          <div class="search-bar">
            <i class="fa fa-search icon" style="color: #797070"></i>
            <input
              class="input-field"
              type="text"
              placeholder="Search cats,etc..."
            />
          </div>
        </div>
      </section>
      <main class="main-content">
        <!--For Cats-->
        <div class="cat-content">
          <h1>Meet our dogs and cats</h1>
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
        foreach ($pet_data as $pet) {
          $petId = $pet['pets_id'];
        ?>
          <div class="img-bg" onclick="window.location.href='adoptprofile.php?id=<?php echo $petId; ?>'">
              <img src="../upload/<?php echo $pet['image']; ?>" alt="" /> <!-- Use $cat instead of $row -->
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
  </body>
</html>
