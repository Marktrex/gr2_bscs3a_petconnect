<?php
require '../function/config.php';


if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "admin" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}

// Promote Button
if (isset($_POST['promote'])) {
    // Retrieve the data from the form
    $id = $_POST['id'];
    $is_featured = $_POST['is_featured'];

    if ($is_featured == 1) {
        echo '<script language="javascript">';
        echo 'alert("Already a Headline");';
        echo 'window.location.href = "admin-manage-news.php";';
        echo '</script>';
        exit;
    } elseif ($is_featured == 0) {
        // Set all other news as not featured (is_featured = 0)
        $updateAllSql = "UPDATE news SET is_featured = 0 WHERE news_id <> :id";
        $stmt = $conn->prepare($updateAllSql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); //use to bind a parameter to a prepared statement. 
        // $stmt->execute(); you can put this execute method in the if statement

        if ($stmt->execute()) {
            // Set the selected news as featured (is_featured = 1)
            $updateSql = "UPDATE news SET is_featured = 1 WHERE news_id = :id";
            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
           
            if ($stmt->execute()) {
                echo '<script language="javascript">';
                echo 'alert("Set as Headlined");';
                echo 'window.location.href = "admin-manage-news.php";';
                echo '</script>';
                exit;
            } else {
                echo "Error setting as Headlined: " . $stmtUpdate->errorInfo()[2];
                exit;
            }
        } else {
            echo "Error updating news: " . $stmtUpdate->errorInfo()[2];
            exit;
        }
    } else {
        echo "Invalid user type";
        exit;
    }
}

//Update Button
if (isset($_POST['update'])) {
    // Retrieve the data from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $details = $_POST['details'];

    // $title = mysqli_real_escape_string($conn, $_POST['title']);
    // $details = mysqli_real_escape_string($conn, $_POST['details']);

    $sql = "UPDATE news SET title = :title, details = :details WHERE news_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':details', $details, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    // Perform the database query
    if ($stmt->execute()) {
        echo "
            <script> 
                alert('Data updated successfully'); 
                window.location.href = 'admin-manage-news.php';
            </script>";
    } else {
        echo "Error updating data: ";
    }
}

// Delete Button
if (isset($_POST['delete'])) {
    // Retrieve the ID of the record to delete
    $id = $_POST['id'];

        // Prepare the SQL statement with a parameterized query
        $stmt = $conn->prepare("DELETE FROM news WHERE news_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            echo "
            <script> 
                alert('Record deleted successfully'); 
                window.location.href = 'admin-manage-news.php';
            </script>";
        } else {
            echo "Error deleting record: " . $stmt->errorInfo()[2];
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
    <link rel="stylesheet" href="../css/admin-pets.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
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
        <a href="../index.php" class="logo"><img src="./image/logo (1).png" class="img-logo"></a>
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
                    <h1>News List</h1>
                    <table class="table" style="text-align:center">

                        <thead>
                            <tr>
                                <th>News ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Details</th>
                                <th>Date Published</th>
                                <th>Is_Featured</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require '../function/config.php';

                            // Query the database table
                            $sql = "SELECT news_id, image ,title , details, date_published, is_featured FROM news";
                            $stmt = $conn->query($sql);

                            // $result = $conn->query($sql);

                            // Fetch and display the data
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                    <tr>
                                        <td>
                                            <?php echo $row["news_id"]; ?>
                                        </td>
                                        <td><img src="../upload/news/<?php echo $row['image']; ?>" alt="" height="50"></td>
                                        <td>
                                            <?php echo $row["title"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["details"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["date_published"]; ?>
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

                <div class="container mt-1">
                    <h1>User Details</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="id">ID:</label>
                                <input type="text" class="form-control" id="id" name="id" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user_type">Is_Featured:</label>
                                <input type="text" class="form-control" id="is_featured" name="is_featured" required
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fname">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="about">Details:</label>
                            <textarea class="form-control" id="details" name="details" rows="4" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_created">Date Published:</label>
                                <input type="text" class="form-control" id="date_published" name="date_published"
                                    required readonly>
                            </div>

                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="update" class="btn btn-primary" id="btn-update">Update</button>
                            <button type="submit" name="delete" class="btn btn-danger" id="btn-delete">Delete</button>
                            <button type="submit" name="promote" class="btn btn-primary"id="btn-promote">Set as Headline</button>
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
                var is_featured = $(this).find("td:nth-child(6)").html().trim();
                var tilte = $(this).find("td:nth-child(3)").text().trim();
                var details = $(this).find("td:nth-child(4)").text().trim();
                var date_published = $(this).find("td:nth-child(5)").text().trim();

                // Populate the input fields with the selected row data
                $("#id").val(id);
                $("#is_featured").val(is_featured);
                $("#title").val(tilte);
                $("#details").val(details);
                $("#date_published").val(date_published);
            });
        });
    </script>


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