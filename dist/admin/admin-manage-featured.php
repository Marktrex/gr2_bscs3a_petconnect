<?php
require '../function/config.php';

if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "admin" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Clear the is_featured column for all records
    $clearSql = "UPDATE pets SET is_featured = 0";
    $stmt = $conn->prepare($clearSql);
    $stmt->execute();
    // mysqli_query($conn, $clearSql);
    

    // Retrieve the selected IDs from the number inputs
    $featuredImage1 = $_POST['featured_image_1'];
    $featuredImage2 = $_POST['featured_image_2'];
    $featuredImage3 = $_POST['featured_image_3'];
    $featuredImage4 = $_POST['featured_image_4'];

    // Update the is_featured column for the selected records
    $sql1 = "UPDATE pets SET is_featured = 1 WHERE pets_id = :featuredImage1";
    $sql2 = "UPDATE pets SET is_featured = 2 WHERE pets_id = :featuredImage2";
    $sql3 = "UPDATE pets SET is_featured = 3 WHERE pets_id = :featuredImage3";
    $sql4 = "UPDATE pets SET is_featured = 4 WHERE pets_id = :featuredImage4";

    $stmt1 = $conn->prepare($sql1);
    $stmt1->bindParam(':featuredImage1', $featuredImage1, PDO::PARAM_INT);
    $stmt1->execute();
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':featuredImage2', $featuredImage2, PDO::PARAM_INT);
    $stmt2->execute();
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bindParam(':featuredImage3', $featuredImage3, PDO::PARAM_INT);
    $stmt3->execute();
    $stmt4 = $conn->prepare($sql4);
    $stmt4->bindParam(':featuredImage4', $featuredImage4, PDO::PARAM_INT);
    $stmt4->execute();

    if ($stmt1 && $stmt2 && $stmt3 && $stmt4) {
        echo "
        <script> 
            alert('Records updated successfully'); 
            window.location.href = 'admin-manage-featured.php';
        </script>";
    } else {
        echo "Error updating records: " . $conn = null;
    }

    // Retrieve the current values of is_featured column from the database
    $featuredImage1 = "";
    $featuredImage2 = "";
    $featuredImage3 = "";
    $featuredImage4 = "";

    $sql = "SELECT pets_id, is_featured FROM pets WHERE is_featured > 0";
    $stmt = $pdo->query($sql);
    // $result = mysqli_query($conn, $sql); 

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['pets_id'];
        $isFeatured = $row['is_featured'];

        if ($isFeatured == 1) {
            $featuredImage1 = $id;
        } elseif ($isFeatured == 2) {
            $featuredImage2 = $id;
        } elseif ($isFeatured == 3) {
            $featuredImage3 = $id;
        } elseif ($isFeatured == 4) {
            $featuredImage4 = $id;
        }
    }
}

// Close the database connection
$conn = null;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin-featured.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sigmar">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            <div class="modify-featured">
                <div class="container mt-4 table-container">
                    <h1>Pets List</h1>
                    <table class="table" style="text-align:center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Is_Featured</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require '../function/config.php';

                            // Query the database table
                            $sql = "SELECT pets_id, name, image , is_featured, sex FROM pets";
                            $stmt = $conn->query($sql); //PHP PDO QUERY 

                            // $result = $conn->query($sql); //PHP MYSQLI query

                            // Fetch and display the data
                            if ($stmt->rowCount() > 0) { //php PDO rowcount or function that displays the data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //this code if for php pdo that fetch or gets the data in the db
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row["pets_id"]; ?>
                                        </td>
                                        <td><img src="../upload/<?php echo $row['image']; ?>" alt="" height="50"></td>
                                        <td>
                                            <?php echo $row["name"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["is_featured"]; ?>
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

                <h4 style="text-align: center;">Select IDs to set as Featured Images</h4>
                <form method="POST">
                    <div class="form-container">
                        <div class="form-group">
                            <label for="featured_image_1">Featured Image 1:</label>
                            <input type="number" name="featured_image_1" id="featured_image_1"
                                value="<?php echo isset($featuredImage1) ? $featuredImage1 : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="featured_image_2">Featured Image 2:</label>
                            <input type="number" name="featured_image_2" id="featured_image_2"
                                value="<?php echo isset($featuredImage2) ? $featuredImage2 : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="featured_image_3">Featured Image 3:</label>
                            <input type="number" name="featured_image_3" id="featured_image_3"
                                value="<?php echo isset($featuredImage3) ? $featuredImage3 : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="featured_image_4">Featured Image 4:</label>
                            <input type="number" name="featured_image_4" id="featured_image_4"
                                value="<?php echo isset($featuredImage4) ? $featuredImage4 : ''; ?>">
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Set as Featured Images">
                </form>

            </div>
        </div>
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