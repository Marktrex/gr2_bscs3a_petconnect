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

// Check if the form is submitted
if (isset($_POST['promote'])) {
    // Retrieve the data from the form
    $id = $_POST['id'];
    $userType = $_POST['user_type'];

    // Check the user type
    if ($userType == 1) {
        echo '<script language="javascript">';
        echo 'alert("Already an Admin");';
        echo 'window.location.href = "admin-manage-user.php";';
        echo '</script>';
        exit;
    } elseif ($userType == 2) {
        // Promote to admin
        $sql = "UPDATE user SET user_type = 1 WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) {
            $log = new Audit($_SESSION['auth_user']['id'],"user promotion","admin promoted id:$id to admin");
            $log->activity_log();
            echo '<script language="javascript">';
            echo 'alert("Promoted to Admin");';
            echo 'window.location.href = "admin-manage-user.php";';
            echo '</script>';
            exit;
        } else {
            echo "Error promoting user to admin: ";
            exit;
        }
    } else {
        echo "Invalid user type";
        exit;
    }
}


// Close the database connection
$conn = null;
?>

<?php
require '../function/config.php';

// Check if the form is submitted
if (isset($_POST['demote'])) {
    // Retrieve the data from the form
    $id = $_POST['id'];
    $userType = $_POST['user_type'];

    // Check the user type
    if ($userType == 2) {
        echo '<script language="javascript">';
        echo 'alert("Already a Regular User");';
        echo 'window.location.href = "admin-manage-user.php";';
        echo '</script>';
        exit;
    } elseif ($userType == 1) { 
        // Demote to regular user
        $sql = "UPDATE user SET user_type = 2 WHERE user_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $log = new Audit($_SESSION['auth_user']['id'],"user demotion","admin demoted id:$id to admin");
            $log->activity_log();
            echo '<script language="javascript">';
            echo 'alert("Demoted to Regular User");';
            echo 'window.location.href = "admin-manage-user.php";';
            echo '</script>';
            exit;
        } else {
            echo "Error demoting user to regular user" . $conn = null;
            exit;
        }
    } else {
        echo "Invalid user type";
        exit;
    }
}

// Close the database connection
$conn = null;
?>

<?php
require '../function/config.php';
if (isset($_POST['update'])) {
    // Retrieve the data from the form
    $id = $_POST['id'];
    $firstName = $_POST["fname"];
    $lastName = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Update the data in both tables
    $conn->beginTransaction();
try {
    // Update chat_user_table
    $query1 = "
        UPDATE chat_user_table
        SET user_name = :firstName, user_email = :email, user_password = :password
        WHERE user_id = :id
    ";
    $statement1 = $conn->prepare($query1);
    $statement1->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $statement1->bindParam(':email', $email, PDO::PARAM_STR);
    $statement1->bindParam(':password', $password, PDO::PARAM_STR);
    $statement1->bindParam(':id', $id, PDO::PARAM_INT);
    if (!$statement1->execute()) {
        print_r($statement1->errorInfo());
        exit;
    }

    // Update user table
    $query2 = "
        UPDATE user
        SET fname = :firstName, lname = :lastName, email = :email, password = :password
        WHERE user_id = :id
    ";
    $statement2 = $conn->prepare($query2);
    $statement2->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $statement2->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $statement2->bindParam(':email', $email, PDO::PARAM_STR);
    $statement2->bindParam(':id', $id, PDO::PARAM_INT);
    $statement2->bindParam(':password', $password, PDO::PARAM_STR);
    if (!$statement2->execute()) {
        print_r($statement2->errorInfo());
        exit;
    }
    
    // If both updates are successful, commit the transaction
    $conn->commit();
    $log = new Audit($_SESSION['auth_user']['id'],"admin modified user","admin change the content of user: $firstName id: $id");
    $log->activity_log();
    echo '<script language="javascript">';
        echo 'alert("User updated successfully");';
        echo 'window.location = "admin-manage-user.php";';
        echo '</script>';
} catch (PDOException $e) {
    // An error occurred, rollback the transaction
    $conn->rollBack();
    echo "Error updating data: " . $e->getMessage();
}
}
?>

<?php
require '../function/config.php';

// Check if the form is submitted
if (isset($_POST['delete'])) {
    // Retrieve the id of the record to delete
    $id = $_POST['id'];

    // Delete the record from the database
    $sql = "DELETE FROM user WHERE user_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt ->execute();

    if ($stmt) {
        // might change to update
        $log = new Audit($_SESSION['auth_user']['id'],"admin deletes account","admin deletes account:$id");
        $log->activity_log();
        echo "
        <script> 
            alert('Record deleted successfully'); 
            document.location.href = 'admin-manage-user.php';
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
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin-pets.css">
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
            <div class="modify-featured">
                <div class="container mt-4 table-container">
                    <h1>User List</h1>
                    <table class="table" style="text-align:center">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>User Type</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require '../function/config.php';

                            // Query the database table
                            $sql = "SELECT user_id, fname ,lname , email, password, user_type, created_at FROM user";
                            $stmt = $conn->query($sql);
                            $stmt -> execute();
                            // $result = $conn->query($sql);

                            // Fetch and display the data
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                    <tr>
                                        <td>
                                            <?php echo $row["user_id"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["fname"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["lname"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["email"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["password"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["user_type"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["created_at"]; ?>
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
                                <label for="user_type">User Type:</label>
                                <input type="text" class="form-control" id="user_type" name="user_type" required
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fname">First Name:</label>
                                <input type="text" class="form-control" id="fname" name="fname" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lname">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password:</label>
                                <input type="text" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_created">Date Created:</label>
                                <input type="text" class="form-control" id="date_created" name="date_created" required
                                    readonly>
                            </div>

                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="update" class="btn btn-primary" id="btn-update">Update</button>
                            <button type="submit" name="delete" class="btn btn-danger" id="btn-delete">Delete</button>
                            <button type="submit" name="promote" class="btn btn-primary"
                                id="btn-promote">Promote</button>
                            <button type="submit" name="demote" class="btn btn-danger" id="btn-demote">Demote</button>
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
                var fname = $(this).find("td:nth-child(2)").html().trim();
                var lname = $(this).find("td:nth-child(3)").text().trim();
                var email = $(this).find("td:nth-child(4)").text().trim();
                var password = $(this).find("td:nth-child(5)").text().trim();
                var user_type = $(this).find("td:nth-child(6)").text().trim();
                var date_created = $(this).find("td:nth-child(7)").text().trim();

                // Populate the input fields with the selected row data
                $("#id").val(id);
                $("#fname").val(fname);
                $("#lname").val(lname);
                $("#email").val(email);
                $("#password").val(password);
                $("#user_type").val(user_type);
                $("#date_created").val(date_created);
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