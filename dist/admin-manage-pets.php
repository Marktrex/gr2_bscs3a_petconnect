<?php
require './function/config.php';

// Check if the form is submitted
if (isset($_POST['update'])) {
    // Retrieve the data from the form

    $id = $_POST['id'];  //this code is for PHP PDO (PHP Data Objects)
    $name = $_POST["name"];
    $type = $_POST["type"];
    $breed = $_POST["breed"];
    $sex = $_POST["sex"];
    $weight = $_POST["weight"];
    $age = $_POST["age"];
    $date = $_POST["date"];
    $about = $_POST["about"];

    // $name = mysqli_real_escape_string($conn, $_POST["name"]); this code is for PHP MYSQLI
    // $type = mysqli_real_escape_string($conn, $_POST["type"]);
    // $breed = mysqli_real_escape_string($conn, $_POST["breed"]);
    // $sex = mysqli_real_escape_string($conn, $_POST["sex"]);
    // $weight = mysqli_real_escape_string($conn, $_POST["weight"]);
    // $age = mysqli_real_escape_string($conn, $_POST["age"]);
    // $date = mysqli_real_escape_string($conn, $_POST["date"]);
    // $about = mysqli_real_escape_string($conn, $_POST["about"]);

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
                $image_destination = 'upload/' . $image_new_name;
                move_uploaded_file($image_tmp, $image_destination);

                // Update the image in the database
                $sql = "UPDATE pets SET name='$name', type='$type', breed='$breed', sex='$sex', weight='$weight', age='$age', date='$date', about='$about', image='$image_new_name' WHERE pets_id='$id'";
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
        echo "
        <script> 
            alert('Data updated successfully'); 
            window.location.href = 'admin-manage-pets.php';
        </script>";
    } else {
        echo "Error updating data";
    }
}

// Close the database connection
$conn = null;
?>


<?php
require './function/config.php';

// Check if the form is submitted
if (isset($_POST['delete'])) {
    // Retrieve the id of the record to delete
    $id = $_POST['id'];

    // Delete the record from the database
    $sql = "DELETE FROM pets WHERE pets_id='$id'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt) {
        echo "
        <script> 
            alert('Record deleted successfully'); 
            document.location.href = 'admin-manage-pets.php';
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
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/admin-pets.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sigmar">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS to remove text decoration */
        a,
        .form-control {
            text-decoration: none !important;
        }

        .table-container {
            max-height: 400px;
            overflow-y: scroll;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="index.php" class="logo"><img src="./image/logo (1).png" class="img-logo"></a>
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
            <div class="modify-featured">
                <div class="container mt-4 table-container">
                    <h1>Pets List</h1>
                    <table class="table" style="text-align:center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Breed</th>
                                <th>Sex</th>
                                <th>Weight</th>
                                <th>Age</th>
                                <th>Date of Rescue</th>
                                <th style="width: 20rem">About</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require './function/config.php';

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
                                        <td><img src="./upload/<?php echo $row['image']; ?>" alt="" height="50"></td>
                                        <td>
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
                                        <td style="text-align:justify">
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
                </div>

                <div class="container mt-1">
                    <h1>Pet Form</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="id">ID:</label>
                                <input type="text" class="form-control" id="id" name="id" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Pet Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Pet Type:</label>
                                <select class="form-control" id="type" name="type" required>
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
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="weight">Weight:</label>
                                <select class="form-control" id="weight" name="weight" required>
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
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="update" class="btn btn-primary" id="btn-update">Update</button>
                            <button type="submit" name="delete" class="btn btn-danger" id="btn-delete">Delete</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                var image = $(this).find("td:nth-child(2)").html().trim();
                var name = $(this).find("td:nth-child(3)").text().trim();
                var type = $(this).find("td:nth-child(4)").text().trim();
                var breed = $(this).find("td:nth-child(5)").text().trim();
                var sex = $(this).find("td:nth-child(6)").text().trim();
                var weight = $(this).find("td:nth-child(7)").text().trim();
                var age = $(this).find("td:nth-child(8)").text().trim();
                var date = $(this).find("td:nth-child(9)").text().trim();
                var about = $(this).find("td:nth-child(10)").text().trim();

                // Populate the input fields with the selected row data
                $("#id").val(id);
                // $("#pet-image").attr("src", image); // Uncomment if you have an <img> tag for the image
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


</body>

</html>

<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            // Perform logout action
            window.location.href = "logout.php";
        }
    }
</script>