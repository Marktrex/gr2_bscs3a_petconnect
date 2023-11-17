<?php
use MyApp\Controller\Audit;
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

            move_uploaded_file($tmpName, '../upload/' . $newImageName);
            $sql = "INSERT INTO pets (name,type,breed,sex,weight,age,about,date,image, user_id) VALUES(:name , :type, :breed, :sex, :weight, :age, :about, :date, :image, :user_id)";

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
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            // Execute the prepared statement
      
            if ($stmt) {
                $log = new Audit($_SESSION['auth_user']['id'],"add pets","admin added pets named:$name on $date");
                $log->activity_log();
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        a,
        .form-control {
            text-decoration: none !important;
        }
    </style>
</head>

<body>
    <nav class="navbar">
    <a href="admin-dashboard.php" class="logo"><img src="../image/logo (1).png" class="img-logo"></a>
        <a href="javascript:void(0);" class="list" onclick="logout()">Logout</a>
    </nav>

    <div class="setting">

        <div class="sidebar">
            <a href="admin-dashboard.php" class="menu"> Dashboard</a>
            <a href="admin-add-pets.php" class="menu"> Add Pets</a>
            <a href="admin-manage-pets.php" class="menu"> Manage Pets</a>
            <a href="admin-manage-featured.php" class="menu"> Modify Featured Image</a>
            <a href="admin-manage-user.php" class="menu"> Manage Users</a>
            <a href="admin-add-news.php" class="menu"> Add News</a>
            <a href="admin-manage-news.php" class="menu"> Manage News</a>
            <a href="../../privatechat.php" class="menu"> Chat</a>

        </div>

        <div class="main">
            <div class="container mt-1 pet-form">
                <h1>Pet Form</h1>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Pet Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">Pet Type:</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="breed">Breed:</label>
                            <select name="breed" id="breed" class="form-control">
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
                        <div class="form-group col-md-6">
                            <label for="sex">Sex:</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="">Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="weight">Weight:</label>
                            <select class="form-control" id="weight" name="weight" required>
                                <option value="">Select Weight</option>
                                <option value="Less than 5 lbs">Less than 5 lbs</option>
                                <option value="5-10 lbs">5-10 lbs</option>
                                <option value="10-20 lbs">10-20 lbs</option>
                                <option value="20-50 lbs">20-50 lbs</option>
                                <option value="over 50 lbs">over 50 lbs</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="age">Age:</label>
                            <select class="form-control" id="age" name="age" required>
                                <option value="">Select Age</option>
                                <option value="Less than 6 months">Less than 6 months</option>
                                <option value="6 months to 5 years">6 months to 5 years</option>
                                <option value="5 to 10 years">5 to 10 years</option>
                                <option value="over 10 years">over 10 years</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="date">Date of Rescue:</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="about">About:</label>
                        <textarea class="form-control" id="about" name="about" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
</body>

</html>

<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            // Perform logout action
            window.location.href = "../function/logout.php";
        }
    }
</script>