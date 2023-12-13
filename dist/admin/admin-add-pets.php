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


if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $breed = $_POST["breed"];
    $sex = $_POST["sex"];
    $weight = $_POST["weight"];
    $age = $_POST["age"];
    $date = $_POST["date"];
    $about = $_POST["about"];
    $weight = $_POST["weight"];
    $user_id = $_SESSION['auth_user']['id'];


    if ($_FILES["image"]["error"] === 4) {
        echo "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $filename = $_FILES["image"]["name"];
        $filesize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $filename);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid Image Extension'); </script>";
        } elseif ($filesize > 2000000) {
            echo "<script> alert('Image Size Is Too Large'); </script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, '../upload/petImages/' . $newImageName);
            $sql = "INSERT INTO pets (name,type,breed,sex,weight,age,about,date,image) VALUES(:name , :type, :breed, :sex, :weight, :age, :about, :date, :image)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':breed', $breed, PDO::PARAM_STR);
            $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
            $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_STR);
            $stmt->bindParam(':about', $about, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':image', $newImageName, PDO::PARAM_STR);
            $stmt->execute();
            // Execute the prepared statement
            $lastId = $conn->lastInsertId();
            if ($stmt) {
                $log = new AuditModelController();
                $log->activity_log(
                    $_SESSION['auth_user']['id'],//responsible
                    "INSERT",//type
                    "PET",//table
                    "All",//column
                    $lastId,//id
                    "None",//old
                    "None",//new val
                );
                echo "
                <script> 
                    alert('Pets added successfully'); 
                    document.location.href = './admin-add-pets.php';
                </script>";
            } else {
                echo "Error, Adding pet failed "; // Display the specific error message
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pets</title>

    <!-- content style position -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/admin-add-pets-light.css?v=2" />

    <!-- layout style position-->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/layout-light.css" />

    <link rel="stylesheet" href="../css/colorStyle/admin/layout-color.css">
    <link rel="stylesheet" href="..\css\colorStyle\admin\add-pets-color.css">
</head>

<body>

    <div class="container">
        <header class="">
            <nav class="navbar">
            <a href="admin-dashboard.php" class="logo" 
                ><img src="../icons/logo.png" alt="Insert Logo" id="logIcon"
            /></a>
            
           
            </nav>
        </header>
        
        <main class="content">
            <div class="wrapper">
                <form class ="form" action="#" method="POST" enctype="multipart/form-data">
                    <h1 class = "form-title">Pet Form</h1>
                    <div class="form-input">

                        <div class="image-container">
                            <div>
                            <img src="../icons/pet-profile-bg.jpg" id="profile-pic" />
                            <label for="image" class="img-label">Upload Image</label>
                                <input type="file" accept="image/jpeg, image/jpg, image/png"  id="image" name="image">
                            </div>
                        </div>
                        
                        <div class="pet-container">
                            <!-- name -->
                            <div class="">
                                <label for="name"><a>Pet Name</a></label>
                                <input type="text" class="pet-name" id="name" name="name" maxlength="20" required>
                            </div>
                            <br>
                            <!-- Species -->
                            <div class="">
                                <label for="type"><a>Species</a></label>
                                <select class="pet-type" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                </select>
                            </div>
                            <br>
                            <!-- breed -->
                            <div class="">
                                <label for="breed"><a>Breed</a></label>
                                <select name="breed" id="breed" class="pet-breed" required>
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
                            <br>
                            
                            
                            <!-- age -->
                            <div >
                                <label for="age"><a>Age</a></label>
                                <select class="form-control" id="age" name="age" required>
                                    <option value="">Select Age</option>
                                    <option value="Less than 6 months">Less than 6 months</option>
                                    <option value="6 months to 5 years">6 months to 5 years</option>
                                    <option value="5 to 10 years">5 to 10 years</option>
                                    <option value="over 10 years">over 10 years</option>
                                </select>
                            </div>
                            <br>
                            <!-- pet sex -->
                            <div class="">
                                <label for="sex"><a>Sex</a></label>
                                <select class="pet-sex" id="sex" name="sex" required>
                                    <option value="">Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <br>
                            <!-- weight -->
                            <div class="">
                                <label for="weight"><a>Weight</a></label>
                                <select class="form-control" id="weight" name="weight" required>
                                    <option value="">Select Weight</option>
                                    <option value="Less than 5 lbs">Less than 5 lbs</option>
                                    <option value="5-10 lbs">5-10 lbs</option>
                                    <option value="10-20 lbs">10-20 lbs</option>
                                    <option value="20-50 lbs">20-50 lbs</option>
                                    <option value="over 50 lbs">over 50 lbs</option>
                                </select>
                            </div>
                            <br>
                            <!-- date of rescue -->
                            <div class="">
                                <label for="date"><a>Date of Rescue</a></label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <br>
                            <!-- about -->
                            <div class="">
                                <label for="about"><a id="label-about">About</a></label>
                                <textarea id="about" name="about" required></textarea>
                            </div>
                            <br>
                        </div>
                    </div>
                    <section class="ac-btn">
                        <button class="add-btn" type="submit" name="submit">Add Pet</button>
                        <button class="clear-btn" type = "button" id ="clearAll">Clear all</button>
                    </section>
                </form>
            </div>
        </main>


        <?php require_once '..\components\light-switch.php'?>
        <?php require_once "../components/admin/adminSidebar.php"?>        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script/admin-general.js"></script>
    <script src="..\script\clearForm.js"></script>
</body>

</html>
