<?php

use MyApp\Controller\UserModelController;
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
            $log = new AuditModelController();
            $log->activity_log(
                $_SESSION['auth_user']['id'],
                "UPDATE",
                "USER",
                "user_type",
                $id,
                "2",
                "1"
            );
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
            $log = new AuditModelController();
            $log->activity_log(
                $_SESSION['auth_user']['id'],
                "UPDATE",
                "USER",
                "user_type",
                $id,
                "1",
                "2"
            );
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
if (isset($_POST['update'])) {
    // Retrieve the data from the form
    $id = $_POST['id'];
    $sql = "SELECT fname, lname, email, photo user WHERE pets_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $oldData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $newData = [
        'fname' => $_POST["fname"],
        'lname' => $_POST["lname"],
        'email' => $_POST["email"],
    ];

    $firstName = $_POST["fname"];
    $lastName = $_POST["lname"];
    $email = $_POST["email"];
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
                    $newData['photo'] = $image_new_name;
                    // Update the image in the database
                    $user_update = new UserModelController();
                    $user_update->updateProfile($id, [
                        'fname' => $firstName,
                        'lname' => $lastName,
                        'email' => $email,
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
            $user_update->updateProfile($id, [
                'fname' => $firstName,
                'lname' => $lastName,
                'email' => $email
            ]);
        }
        
        $lastId = $conn->lastInsertId();
        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if($value != $newData[$key]){
                $log->activity_log(
                    $_SESSION['auth_user']['id'],
                    "UPDATE",
                    "USER",
                    $key,
                    $id,
                    $value,
                    $newData[$key]
                );
            }
        }
        echo '<script language="javascript">';
            echo 'alert("User updated successfully");';
            echo 'window.location = "admin-manage-user.php";';
            echo '</script>';
    } catch (PDOException $e) {
        // An error occurred, rollback the transaction
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
        $lastId = $conn->lastInsertId();
        $log = new AuditModelController();
        $log->activity_log(
            $_SESSION['auth_user']['id'],
            "DELETE",
            "USER",
            "ALL",
            $id,
            "Null",
            "Null"
        );
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
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../image/icon.png" type="image/png">
    <!-- content color -->

    <!-- for content position -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/manage-users.css" />

    <!-- for layout color -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/admin-layout-colors.css" />

    <!-- layout position -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/layout-light.css" />

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Manage Users</title>
</head>

<body>
    <div class="container">
        <!-- header/nav -->
        <header>
            <nav class="navbar">
                <a href="#" class="logo"><img src="../icons/logo.png" alt="Logo" /></a>

                <ul class="items">
                <li>
                    <a id="messages" href="#"><i class="fa fa-envelope"></i></a>
                </li>
                <li>
                    <a id="notifications" href="#"><i class="fa fa-bell"></i></a>
                </li>
                <li>
                    <a href="#"><img src="../icons/icons-user.png" alt="Profile" /></a>
                </li>
                </ul>
            </nav>
        </header>
        <!-- content -->
        <main class="content">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="profile">
                    <div class="item details1">
                        <!-- image here -->
                        <div>
                            <img src="../upload/userImages/default.jpg" id="profile-pic" alt="image here"/>
                            <label class="img-label" for="image">Upload Image</label>
                            <input type="file" accept="image/jpeg, image/jpg, image/png" id="image" name="image">
                        </div>
                        <!-- id here -->
                        <label for="id"><a>ID</a></label>
                        <input type="text" class="id" id="id" name="id" placeholder="Enter ID" readonly>
                    </div>
                    <div class="item details2">
                        <!-- firstname -->
                        <div>
                            <label for="fname">First Name</label>
                            <input placeholder="Enter First Name" type="text" class="UserFname" id="fname" name="fname" required>
                        </div>
                        <!-- last name -->
                        <div>
                            <label for="lname">Last Name</label>
                            <input placeholder="Enter Last Name" type="text" class="UserLname" id="lname" name="lname" required>
                        </div>
                    </div>
                    <div class="details3">
                        
                         <!-- email -->
                         <div>
                            <label for="email">Email</label>
                            <input placeholder="Enter Email" type="email" class="user-email" id="email" name="email" required>
                        </div>
                        <!-- user type -->
                        <div>
                            <label for="user_type">User Type</label>
                            <input placeholder="Enter User Type" type="text" class="User-Type" id="user_type" name="user_type" required
                                readonly>
                        </div>
                    </div>
                    <div class="details4">
                        <!-- date created -->
                        <div class = "flex">
                            <label for="date_created">Date Created:</label>
                            <input type="text" class="Date" id="date_created" name="date_created" required
                                readonly placeholder="MM.DD.YY">
                        </div>
                        <!-- buttons -->
                        <section class="upd-btn">
                            <button type="submit" name="update" class="update-btn" id="btn-update">Update</button>
                            <button type="submit" name="delete" class="delete-btn" id="btn-delete">Delete</button>
                            <button type="submit" name="promote" class="update-btn"
                                id="btn-promote">Promote</button>
                            <button type="submit" name="demote" class="delete-btn" id="btn-demote">Demote</button>
                        </section>
                    </div>
                </div>
            </form>
            <div class="list">
                <h1>User List</h1>
                <!-- table here -->
                <section class="list-body">
                    <table class="table" id="pets-list">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Photo</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require '../function/config.php';
                            // Query the database table
                            $sql = "SELECT * FROM user";
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
                                            <?php 
                                                $image = "../upload/userImages/".$row['photo'];
                                                if($row['photo'] == null){
                                                    $image = "../upload/userImages/default.jpg";
                                                }
                                            ?>
                                        <img src="<?php echo $image; ?>" alt="" height="50"><br>
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
                </section>
            </div>
        </main>
        <!--SideBar-->
        <aside id="sidenav" class="sidebar">
            <ul class="menu-links menu-links-color">
            <span
                id="close-btn"
                href="javascript:void(0)"
                >&times;</span
            >
            <li>
                <a id="db" href="admin-dashboard.php"
                ><i class="fa fa-list-ul"></i>&nbsp;&nbsp;&nbsp;Dashboard</a
                >
            </li>
            <li>
                <a id="db" href="#"
                ><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Messages</a
                >
            </li>
            <li>
                <a id="add" href="admin-add-pets.php"
                ><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add Pets</a
                >
            </li>
            <li>
                <a id="manage" href="admin-manage-pets.php"
                ><i class="fa fa-paw"></i>&nbsp;&nbsp;&nbsp;Manage Pets</a
                >
            </li>
            <li>
                <a id="users" href="admin-manage-user.php"
                ><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Manage Users</a
                >
            </li>
            <li>
                <a id="add" href="admin-audit-trail.php">
                <i class="fa fa-clock-o"></i>
                &nbsp;&nbsp;&nbsp;Audit Trail</a>
            </li>
            <li>
                <a id="logout" href="javascript:void(0);" onclick="logout()"
                ><i class="fa fa-arrow-circle-right"></i
                >&nbsp;&nbsp;&nbsp;Logout</a
                >
            </li>
            </ul>
            <span
            id="menu-btn"
            style="font-size: 30px; cursor: pointer"
            >&#9776;</span
            >
        </aside>
    </div>

    <script src="../script/general.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

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
                var fname = $(this).find("td:nth-child(3)").contents().last().text().trim();
                var lname = $(this).find("td:nth-child(3)").text().trim();
                var email = $(this).find("td:nth-child(4)").text().trim();
                var user_type = $(this).find("td:nth-child(5)").text().trim();
                var date_created = $(this).find("td:nth-child(6)").text().trim();

                // Populate the input fields with the selected row data
                $("#id").val(id);
                $("#profile-pic").attr("src", image);
                $("#fname").val(fname);
                $("#lname").val(lname);
                $("#email").val(email);
                $("#user_type").val(user_type);
                $("#date_created").val(date_created);
            });
        });
    </script>

<script src="../script/admin-general.js"></script>

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