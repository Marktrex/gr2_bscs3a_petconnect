<?php
use MyApp\Controller\AuditModelController;
require_once __DIR__ . '/../../vendor/autoload.php';


require '../function/config.php';
session_start();

if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "1" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}

// Check if the form is submitted
if (isset($_POST['update'])) {
    // Retrieve the data from the form

    $id = $_POST['id'];  //this code is for PHP PDO (PHP Data Objects)
    
    $sql = "SELECT name, type, breed, sex, weight, age, date, about, image FROM pets WHERE pets_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $oldData = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $_POST["name"];
    $type = $_POST["type"];
    $breed = $_POST["breed"];
    $sex = $_POST["sex"];
    $weight = $_POST["weight"];
    $age = $_POST["age"];
    $date = $_POST["date"];
    $about = $_POST["about"];
    $newData = [
        "name" => $_POST["name"],
        "type" => $_POST["type"],
        "breed" => $_POST["breed"],
        "sex" => $_POST["sex"],
        "weight" => $_POST["weight"],
        "age" => $_POST["age"],
        "date" => $_POST["date"],
        "about" => $_POST["about"],
    ];

    // Check if the image is uploaded
    if (!empty($_FILES['image']['name'])) {
        // Retrieve the image file details
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];

        // Check if there is no upload error
        if ($image_error === 0) {
            // Get the file extension
            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_ext = strtolower($image_ext);

            // Check if the file is a valid image
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            if (in_array($image_ext, $allowed_extensions)) {
                // Generate a unique name for the image file
                $image_new_name = uniqid('image_') . '.' . $image_ext;

                // Upload the image to the server
                $image_destination = '../upload/petImages/' . $image_new_name;
                move_uploaded_file($image_tmp, $image_destination);

                $newData["image"] = $image_new_name;
                // Update the image in the database
                $sql = "UPDATE pets SET name = :name, type = :type, breed = :breed, sex = :sex, weight = :weight, age = :age, date = :date, about = :about, image = :image_new_name WHERE pets_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':breed', $breed);
                $stmt->bindParam(':sex', $sex);
                $stmt->bindParam(':weight', $weight);
                $stmt->bindParam(':age', $age);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':about', $about);
                $stmt->bindParam(':image_new_name', $image_new_name);
                $stmt->bindParam(':id', $id);
            } else {
                echo "Invalid image format. Only JPG, JPEG, and PNG files are allowed.";
                exit;
            }
        } else {
            echo "Error uploading image: " . $image_error;
            exit;
        }
    } else {
        // Update the data in the database without changing the image
        
        $sql = "UPDATE pets SET name = :name, type = :type, breed = :breed, sex = :sex, weight = :weight, age = :age, date = :date, about = :about WHERE pets_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':breed', $breed);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':about', $about);
        $stmt->bindParam(':id', $id);
    }
        
    // Perform the database query
    if ($stmt->execute()) {
        $lastId = $conn->lastInsertId();
        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if(array_key_exists($key, $newData) && $value != $newData[$key]){
                $log->activity_log(
                    $_SESSION['auth_user']['id'],
                    "UPDATE",
                    "PET",
                    $key,
                    $id,
                    $value,
                    $newData[$key]
                );
            }
        }
        echo "
        <script> 
            alert('Data updated successfully'); 
            window.location.href = './admin-manage-pets.php';
        </script>";
    } else {
        echo "Error updating data";
    }
}

// Close the database connection
$conn = null;
?>


<?php
require '../function/config.php';

// Check if the form is submitted
if (isset($_POST['delete'])) {
    // Retrieve the id of the record to delete
    $id = $_POST['id'];

    // Delete the record from the database
    $sql = "DELETE FROM pets WHERE pets_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt) {
        $log = new AuditModelController();
        $log->activity_log(
            $_SESSION['auth_user']['id'],
            "DELETE",
            "PET",
            "ALL",
            $id,
            "Null",
            "Null"
        );
        echo "
        <script> 
            alert('Record deleted successfully'); 
            document.location.href = './admin-manage-pets.php';
        </script>";
    } else {
        echo "Error deleting record";
    }
}

// Close the database connection
$conn = null;

?>


<!DOCTYPE html>
<html lang="en">

<head>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../image/icon.png" type="image/png">
    <!-- content style -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/manage-pets.css" />

    <!-- for layout color -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/admin-layout-colors.css" />
    
    <!-- layout style -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/layout-light.css" />

    <link rel="stylesheet" href="..\css\colorStyle\admin\manage-color.css">
    <link rel="stylesheet" href="..\css\colorStyle\admin\layout-color.css">
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Manage Pets</title>
  </head>
</head>

<body>
    <div class="container">
        <!-- header -->
        <header>
            <nav class="navbar">
            <a href="#" class="logo"><img src="../icons/logo.png" alt="Logo" id="logIcon" /></a>
           
            </nav>
        </header>
        <main class="content">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="profile">
                    <div class="item details1">
                        <!-- image here -->
                        <div>
                            <img src="../icons/pet-profile-bg.jpg" id="profile-pic" alt="image here"/>
                            <label class="img-label" for="image">Upload Image</label>
                            <input type="file" accept="image/jpeg, image/jpg, image/png" id="image" name="image">
                        </div>
                        <!-- id here -->
                        <label for="id"><a>ID</a></label>
                        <input type="text" class="id" id="id" name="id" placeholder="Enter ID" readonly>
                    </div>
                    <div class="item details2">
                        <!-- name here -->
                        <div class="form-group col-md-6">
                            <label for="name"><a>Pet Name</a></label>
                            <input type="text" class="pet-name" id="name" name="name" required>
                        </div>
                        <!-- species here -->
                        <div>
                            <label for="type"><a>Species</a></label>
                            <select class="pet-type" id="type" name="type" required>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                            </select>
                        </div>
                        <!-- breed -->
                        <div>
                            <label for="breed"><a>Breed</a></label>
                            <select name="breed" id="breed" class="pet-breed">
                                <option value="">Select Breed</option>
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
                                </optgroup>
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
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="details3">
                        <!-- age -->
                        <div>
                            <label for="age"><a>Age</a></label>
                            <select class="pet-age" id="age" name="age" required>
                                <option value="Less than 6 months">Less than 6 months</option>
                                <option value="6 months to 5 years">6 months to 5 years</option>
                                <option value="5 to 10 years">5 to 10 years</option>
                                <option value="over 10 years">over 10 years</option>
                            </select>
                        </div>
                        <!-- sex -->
                        <div>
                            <label for="sex"><a>Sex</a></label>
                            <select class="pet-sex" id="sex" name="sex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <!-- weight -->
                        <div>
                            <label for="weight"><a>Weight</a></label>
                            <select class="pet-weight" id="weight" name="weight" required>
                                <option value="Less than 5 lbs">Less than 5 lbs</option>
                                <option value="5-10 lbs">5-10 lbs</option>
                                <option value="10-20 lbs">10-20 lbs</option>
                                <option value="20-50 lbs">20-50 lbs</option>
                                <option value="over 50 lbs">over 50 lbs</option>
                            </select>
                        </div>
                    </div>
                    <div class="details4">
                        <!-- date of rescue -->
                        <div class="flex">
                            <label for="date"><a>Date of Rescue</a></label>
                            <input type="date" class="" id="date" name="date" required>
                        </div>
                        <!-- about text area -->
                        <div>
                            <label for="about"><a id="label-about">About</a></label>
                            <textarea class="form-control" id="about" name="about" required></textarea>
                        </div>
                        <!-- update and delete button -->
                        <section class="upd-btn">
                            <button type="submit" name="update" class="update-btn" id="btn-update">Update</button>
                            <button type="submit" name="delete" class="delete-btn" id="btn-delete">Delete</button>
                        </section>
                    </div>
                </div>
            </form>
            <div class="list">
                <h1>Pets List</h1>
                <section class="list-body">
                    <!-- table here -->
                    <table class="table" id ="pets-list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Species</th>
                                <th>Breed</th>
                                <th>Sex</th>
                                <th>Weight</th>
                                <th>Age</th>
                                <th>Date of Rescue</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require '../function/config.php';
                            // Query the database table
                            $sql = "SELECT pets_id, name ,type , breed, sex, weight, age, date, about, image FROM pets";
                            $stmt = $conn->query($sql);
                            // $stmt->execute(); no need to execute because you only views the data not insert,update, or delete
                            // $result = $conn->query($sql);
                            // Fetch and display the data
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row["pets_id"]; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $image = "../upload/petImages/".$row['image'];
                                                if($row['image'] == null){
                                                    $image = "../upload/petImages/default.jpg";
                                                }
                                            ?>
                                            <img src="<?php echo $image; ?>" alt="" height="50">
                                            <br>
                                            <?php echo $row["name"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["type"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["breed"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["sex"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["weight"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["age"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["date"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["about"]; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'>No data available</td></tr>";
                            }
                            // Close the connection
                            $conn = null;
                            ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
        <?php require_once '..\components\light-switch.php'?>
        <?php require_once "../components/admin/adminSidebar.php"?>        
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- adding active state to rows -->
    <script>
        $(document).ready(function () {
            // Handle click event on table rows
            $(".table tbody tr").click(function () {
                // Remove the active class from other rows
                $(".table tbody tr").removeClass("active");

                // Add the active class to the clicked row
                $(this).addClass("active");

                // Get the selected row's data
                var id = $(this).find("td:nth-child(1)").text().trim();
                var image = $(this).find("td:nth-child(2) img").attr("src");
                var name = $(this).find("td:nth-child(2)").contents().last().text().trim();
                var type = $(this).find("td:nth-child(3)").text().trim();
                var breed = $(this).find("td:nth-child(4)").text().trim();
                var sex = $(this).find("td:nth-child(5)").text().trim();
                var weight = $(this).find("td:nth-child(6)").text().trim();
                var age = $(this).find("td:nth-child(7)").text().trim();
                var date = $(this).find("td:nth-child(8)").text().trim();
                var about = $(this).find("td:nth-child(9)").text().trim();
                
                // process to get image source
                

                // Populate the input fields with the selected row data
                $("#id").val(id);
                $("#profile-pic").attr("src", image); // Uncomment if you have an <img> tag for the image
                $("#name").val(name);
                $("#type").val(type);
                $("#breed").val(breed);
                $("#sex").val(sex);
                $("#weight").val(weight);
                $("#age").val(age);
                $("#date").val(date);
                $("#about").val(about);
            });
        });
    </script>
<script src="../script/admin-general.js"></script>

</body>

</html>