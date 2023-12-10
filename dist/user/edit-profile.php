<?php
session_start();
require '../function/config.php';
use MyApp\Controller\UserModelController;
use MyApp\Controller\AuditModelController;
require_once __DIR__ . '/../../vendor/autoload.php';


// print_r($_SESSION);
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 

$user = new UserModelController();

if (isset($_POST['update'])) {
    // Retrieve the data from the form
    $firstName = $_POST["fname"];
    $lastName = $_POST["lname"];
    $currentUserId = $_SESSION['auth_user']['id'];
    $oldData = $user->get_user_data_by_id($currentUserId);
    $newData = [
        'fname' => $firstName,
        'lname' => $lastName
    ];
    // Update the data in both tables
    $conn->beginTransaction();
    try {
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
                    $image_destination = '../upload/userImages/' . $image_new_name;
                    move_uploaded_file($image_tmp, $image_destination);
    
                    // Update the image in the database
                    $newData['photo'] = $image_new_name;
                    $user->updateProfile($currentUserId, [
                        'fname' => $firstName,
                        'lname' => $lastName,
                        'photo' => $image_new_name
                    ]);
                    
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
            
            $user_update = new UserModelController();
            $user_update->updateProfile($currentUserId, [
                'fname' => $firstName,
                'lname' => $lastName
            ]);
        }
        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if(array_key_exists($key, $newData) && $value != $newData[$key]){
                $log->activity_log(
                    $_SESSION['auth_user']['id'],
                    "UPDATE",
                    "USER",
                    $key,
                    $currentUserId,
                    $value,
                    $newData[$key]
                );
            }
        }
    } catch (PDOException $e) {
        // An error occurred, rollback the transaction
        $conn->rollBack();
        echo "Error updating data: " . $e->getMessage();
    }
}

if (isset($_POST['changePassword'])) {
    $currentUserId = $_SESSION['auth_user']['id'];
    $password = $_POST['password'];
    $newPassword = $_POST['newPassword'];
    $conPassword = $_POST['conPassword'];
    $user_data = $user->get_user_data_by_id($currentUserId);
    if (password_verify($password, $user_data->password)) {
        if ($newPassword === $conPassword) {
            $user->updateProfile($currentUserId, [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ]);
            $log = new AuditModelController();
            $log->activity_log(
                $_SESSION['auth_user']['id'],
                "UPDATE",
                "USER",
                "password",
                $currentUserId,
                "SECRET",
                "SECRET"
            );
        } else {
            echo "<script>alert('New password and confirm password must be same')</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect')</script>";
    }
}


if (isset($_POST['delete'])) {
    $currentUserId = $_SESSION['auth_user']['id'];
    $user->deleteUser($currentUserId);
    $log = new AuditModelController();
            $log->activity_log(
                $_SESSION['auth_user']['id'],
                "DELETE",
                "USER",
                "ALL",
                $currentUserId,
                "ALL",
                "DESTROY"
            );
    header("Location: ../function/logout.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Connect</title>
    <link rel="stylesheet" href="..\css\newlyAdded\edit-profile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sigmar">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="main">
        <a href="home.php" class="btn back">Back</a>
        <div class="content">
            <?php $user_data = $user->get_user_data_by_id($_SESSION['auth_user']['id'])?>
            <div class="container">
                <form class="edit" method="POST" enctype="multipart/form-data">
                    <h1>Edit Profile</h1>
                    <hr>
                    <div>
                        <?php $image = $user_data->photo;
                            if (!$image){
                                $image = "default.jpg";
                            }
                        ?>
                        <img src="../upload/userImages/<?php echo $image?>" id="profile-pic" alt="image here"/>
                        <label class="img-label" for="image">Upload Image</label>
                        <input type="file" accept="image/jpeg, image/jpg, image/png" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="fname" id="fname" name="fname" required value ="<?php echo $user_data->fname?>">
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="lname"
                            placeholder="Enter your last name" required value="<?php echo $user_data->lname?>">
                    </div>
                    <div class="text-center">
                        <button type="submit" name="update" id ="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

            <div class="container">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for = "password">Current Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for = "newPassword">New Password</label>
                        <input type="password" name="newPassword" id="newPassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for = "conPassword">Confirm Password</label>
                        <input type="password" name="conPassword" id="conPassword" class = "form-control">
                    </div>
                    <button type="submit" name = "changePassword" id="changePassword" class="btn btn-primary">Change Password</button>
                </form>
            </div>

            <div class="container mt-5">
                Warning You are trying to delete your account
                <form action="" method="post">
                    <button type="submit" name = "delete" id="delete" class="btn btn-danger">Delete Account</button>
                </form>
            </div>

            
            
        </div>
    </div>
    
    <script>
        // updating profile
        let profilePic = document.getElementById("profile-pic");
        let inputFile = document.getElementById("image");
        
        inputFile.onchange = function () {
            profilePic.src = URL.createObjectURL(inputFile.files[0]);
        };
        
    </script>
    <script>
        document.querySelector('#changePassword').addEventListener('submit', function(event) {
            let password = document.querySelector('#newPassword').value;
            let confirmPassword = document.querySelector('#confirmPassword').value;
            if (password !== confirmPassword) {
                alert("Password and confirm password must be same");
                event.preventDefault();
            }
        });
    </script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>