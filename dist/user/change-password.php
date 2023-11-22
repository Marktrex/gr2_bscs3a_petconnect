<?php
use MyApp\Controller\AuditModelController;

require_once __DIR__ . '/../../vendor/autoload.php';
session_start();
require '../function/config.php';
// print_r($_SESSION);
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 
if (isset($_POST['update'])) {
    // Retrieve the data from the form
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    // Get the currently logged-in user's id
    $currentUserId = $_SESSION['auth_user']['id'];

    // Check if the old password is equal to the new password
    if ($oldpassword === $newpassword) {
        echo '<script language="javascript">';
        echo 'alert("Old password and new password cannot be the same");';
        echo 'window.location = "change-password.php";';
        echo '</script>';
        exit; // Stop execution if passwords are the same
    }

    // Update the data in both tables
    $conn->beginTransaction();
    try {
        $query2 = "
            UPDATE user
            SET password = :newpassword
            WHERE user_id = :currentUserId
        ";
        $statement2 = $conn->prepare($query2);
        $statement2->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $statement2->bindParam(':currentUserId', $currentUserId, PDO::PARAM_INT);
        if (!$statement2->execute()) {
            print_r($statement2->errorInfo());
            exit;
        }

        // If both updates are successful, commit the transaction
        $conn->commit();
        $log = new AuditModelController();
        $log->activity_log($currentUserId,"Change password","User has change password");
        echo '<script language="javascript">';
        echo 'alert("Password updated successfully");';
        echo 'window.location = "change-password.php";';
        echo '</script>';
    } catch (PDOException $e) {
        // An error occurred, rollback the transaction
        $conn->rollBack();
        echo "Error updating data: " . $e->getMessage();
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
    <title>rePaw City</title>
    <link rel="stylesheet" href="../css/change-password.css">
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

            <div class="container">
                <form class="edit" method="POST">
                    <h1>Change Password</h1>
                    <div class="form-group">
                        <label for="oldpassword">Old Password:</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Enter Old Password" required>
                    </div>
                    <div class="form-group">
                        <label for="newpassword">New Password:</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Enter New Password" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        </div>
    </div>

    <script>
        // Retrieve user data from the session
        const userData = <?php echo json_encode($_SESSION['auth_user']); ?>;

        // Populate input fields with user data
        document.getElementById('fname').value = userData.fname;
        document.getElementById('lname').value = userData.lname;
        document.getElementById('email').value = userData.email;
    </script>
</body>

</html>