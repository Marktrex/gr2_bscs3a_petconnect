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
            $log->activity_log($_SESSION['auth_user']['id'],"user promotion","admin promoted id:$id to admin");
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
            $log->activity_log($_SESSION['auth_user']['id'],"user demotion","admin demoted id:$id to admin");
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
    $log = new AuditModelController();
    $log->activity_log($_SESSION['auth_user']['id'],"admin modified user","admin change the content of user: $firstName id: $id");
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
        $log = new AuditModelController();
        $log->activity_log($_SESSION['auth_user']['id'],"admin deletes account","admin deletes account:$id");
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
                    <div class="item details2">
                        <!-- id -->
                        <div>
                            <label for="id">ID</label>
                            <input placeholder="Enter ID" type="text" class="id" id="id" name="id" readonly>
                        </div>
                        <!-- email -->
                        <div>
                            <label for="email">Email</label>
                            <input placeholder="Enter Email" type="email" class="user-email" id="email" name="email" required>
                        </div>
                        <!-- password -->
                        <div>
                            <label for="password">Password</label>
                            <input placeholder="Enter Password" type="text" class="Password" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="details3">
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
                <a id="db" href="../../privatechat.php"
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