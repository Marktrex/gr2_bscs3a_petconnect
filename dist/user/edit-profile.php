<?php
session_start();
require '../function/config.php';

if (isset($_POST['update'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Perform the database update query
    $update_query = "UPDATE user SET fname='$fname', lname='$lname' WHERE email='$email'";
    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        $_SESSION['auth_user']['fname'] = $fname; // Update session data
        $_SESSION['auth_user']['lname'] = $lname; // Update session data
        echo '<script language="javascript">';
        echo 'alert("Profile updated successfully");';
        echo 'window.location = "edit-profile.php";';
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Failed to update profile");';
        echo 'window.location = "edit-profile.php";';
        echo '</script>';
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
    <link rel="stylesheet" href="../css/edit-profile.css">
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
                    <h1>Edit Profile</h1>
                    <div class="form-group">
                        <label for="fname">First Name:</label>
                        <input type="text" class="form-control" id="fname" name="fname"
                            placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="lname"
                            placeholder="Enter your last name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                            required>
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