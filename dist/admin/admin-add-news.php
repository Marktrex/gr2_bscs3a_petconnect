<?php
require '../function/config.php';
session_start();

if (isset($_POST["submit"])) {
    $title = $_POST["title"]; //php pdo code
    $details = $_POST["details"];
    $user_id = $_SESSION['auth_user']['id'];

    // $title = mysqli_real_escape_string($conn, $_POST["title"]);
    // $details = mysqli_real_escape_string($conn, $_POST["details"]);
    // $user_id = $_SESSION['auth_user']['id'];

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
        } elseif ($filesize > 3000000) {
            echo "<script> alert('Image Size Is Too Large'); </script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            $imagePath = 'upload/news/' . $newImageName;

            if (move_uploaded_file($tmpName, $imagePath)) {
                try {
                
                    $query = "INSERT INTO news (title, details, image, user_id) VALUES (:title, :details, :image, :user_id)";
                    $stmt = $conn->prepare($query);

                    $stmt->bindParam(':title', $title, PDO::PARAM_STR); //bind param
                    $stmt->bindParam(':details', $details, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $newImageName, PDO::PARAM_STR);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "<script> 
                            alert('Successfully Added'); 
                            window.location.href = 'admin-add-news.php';
                        </script>";
                    } else {
                        echo "Error: " . $stmt->errorInfo()[2];
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Error moving uploaded file.";
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
    <link rel="stylesheet" href="../css/admin news.css">
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
        <a href="../index.php" class="logo"><img src="../image/logo (1).png" class="img-logo"></a>
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
        </div>
        <div class="main">

            <div class="container mt-1 pet-form">
                <h1>News Form</h1>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">News Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="about">Details:</label>
                        <textarea class="form-control" id="details" name="details" rows="4" required></textarea>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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