<?php
session_start();
require '../function/config.php';
include '../function/navbar.php';
// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 
$loggedIn = isset($_SESSION['auth_user']);

// Retrieve the selected filter values from the form submission
$type = $_POST['type'] ?? $_GET['type'] ?? '';
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
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="../css/adoptpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <section class="home">

        <div class="top">
            <img src="../image/doggo.png" class="paw-bg">
            <img src="../image/catto.png" class="paw-bg2">
            <h1 class="title">Adopt</h1>
            <p class="content">All of our cats and dogs can be seen by appointment only.</p>
            <a href="<?php echo $loggedIn ? 'book-appointment.php' : '../loginpage.php'; ?>" class="book-app btn" <?php echo $loggedIn ? 'target="_blank"' : ''; ?>>
                Book Appointment
            </a>

        </div>
        <div class="pets" id="pets">
            <h1 class="adopt-title">MEET OUR PETS</h1>
            <p class="sort">Sort by:</p>
             <!-- Sorting menu -->
            <div class="menu">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="type">Pet Type:</label>
                            <select class="form-control" id="type" name="type" required onchange="this.form.submit()">
                                <option value="">Select Type</option>
                                <option value="Dog" <?php if ($type === 'Dog')
                                    echo 'selected'; ?>>Dog</option>
                                <option value="Cat" <?php if ($type === 'Cat')
                                    echo 'selected'; ?>>Cat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sex">Sex:</label>
                            <select class="form-control" id="sex" name="sex" required onchange="this.form.submit()">
                                <option value="">Select Sex</option>
                                <option value="Male" <?php if ($sex === 'Male')
                                    echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($sex === 'Female')
                                    echo 'selected'; ?>>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight:</label>
                            <select class="form-control" id="weight" name="weight" required
                                onchange="this.form.submit()">
                                <option value="">Select Weight</option>
                                <option value="Less than 5 lbs" <?php if ($weight === 'Less than 5 lbs')
                                    echo 'selected'; ?>>Less than 5 lbs</option>
                                <option value="5-10 lbs" <?php if ($weight === '5-10 lbs')
                                    echo 'selected'; ?>>5-10 lbs
                                </option>
                                <option value="10-20 lbs" <?php if ($weight === '10-20 lbs')
                                    echo 'selected'; ?>>10-20 lbs
                                </option>
                                <option value="20-50 lbs" <?php if ($weight === '20-50 lbs')
                                    echo 'selected'; ?>>20-50 lbs
                                </option>
                                <option value="over 50 lbs" <?php if ($weight === 'over 50 lbs')
                                    echo 'selected'; ?>>over
                                    50 lbs</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <select class="form-control" id="age" name="age" required onchange="this.form.submit()">
                                <option value="">Select Age</option>
                                <option value="Less than 6 months" <?php if ($age === 'Less than 6 months')
                                    echo 'selected'; ?>>Less than 6 months</option>
                                <option value="6 months to 5 years" <?php if ($age === '6 months to 5 years')
                                    echo 'selected'; ?>>6 months to 5 years</option>
                                <option value="5 to 10 years" <?php if ($age === '5 to 10 years')
                                    echo 'selected'; ?>>5 to
                                    10 years</option>
                                <option value="over 10 years" <?php if ($age === 'over 10 years')
                                    echo 'selected'; ?>>over
                                    10 years</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="hero">
        <div class="adoption">
            <div class="card-container">
                <?php
                if (!empty($pet_data)) {
                    foreach ($pet_data as $row) {
                        $name = $row['name'];
                        $sex = $row['sex'];
                        $age = $row['age'];
                        $image = $row['image'];
                        $petId = $row['pets_id'];

                        echo '<a href="adoptprofile.php?id=' . $petId . '" class="card feature">';
                        echo '<img src="../upload/' . $image . '" alt="">';
                        echo '<h4><b>' . $name . '</b></h4>';
                        echo '<p class="gender">' . $sex . '</p>';
                        echo '<div class="vl2"></div>';
                        echo '<p class="age">' . $age . '</p>';
                        echo '</a>';
                    }
                } else {
                    echo '<p>No pets found.</p>';
                }
                ?>

            </div>

        </div>
    </section>
    <?php include '../function/footer.php' ?>
</body>

</html>

<script>
    // Add this script at the bottom of the HTML file or in a separate JavaScript file
    document.addEventListener('DOMContentLoaded', function () {
        var typeSelect = document.getElementById('type');
        var sexSelect = document.getElementById('sex');
        var weightSelect = document.getElementById('weight');
        var ageSelect = document.getElementById('age');

        typeSelect.addEventListener('change', function () {
            scrollToSection('pets');
        });

        sexSelect.addEventListener('change', function () {
            scrollToSection('pets');
        });

        weightSelect.addEventListener('change', function () {
            scrollToSection('pets');
        });

        ageSelect.addEventListener('change', function () {
            scrollToSection('pets');
        });

        function scrollToSection(sectionId) {
            var section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
</script>