<?php
// use MyApp\Controller\AuditModelController;

// require_once __DIR__ . '/../../vendor/autoload.php';
session_start();
require '../function/config.php';
print_r($_SESSION);
// this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 
if (!isset($_SESSION['token'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: home.php");
    exit();
} 

if (isset($_POST['changepass'])) {
    // Retrieve the data from the form
    $token = $_SESSION['token'];
    $newpassword = $_POST['newpassword'];
    // Get the currently logged-in user's email
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email= :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rowCount <= 0) {
        ?>
        <script>
            alert("<?php echo "Sorry, no emails exist"; ?>");
        </script>
        <?php
    } elseif ($user) {
        $query2 = "
            UPDATE user
            SET password = :newpassword
            WHERE email = :email
        ";

        $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);

        $statement2 = $conn->prepare($query2);
        $statement2->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $statement2->bindParam(':email', $email, PDO::PARAM_STR); // Corrected this line

        if (!$statement2->execute()) {
            print_r($statement2->errorInfo());
            exit();
        } else {
            ?>
            <script>
                alert("Your Password has been successfully changed!");
                window.location.replace("../function/logout.php");
            </script>
            <?php
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
    <title>PetConnect | Change Password</title>
    <link rel="stylesheet" href="../css/change-password.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sigmar">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="main">
        <a href="../function/logout.php" class="btn back">Exit</a>
        <div class="content">

            <div class="container">
                <form action="#" class="edit" method="POST"     >
                    <h1>Change Password</h1>
                    
                    <div class="form-group">
                        <label for="newpassword">New Password:</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Enter New Password" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="changepass" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        </div>
    </div>

    <!-- <script>
        // Retrieve user data from the session
        const userData = 
        <?php 
        // echo json_encode($_SESSION['auth_user']); 
        ?>
        //;

        // Populate input fields with user data
        document.getElementById('fname').value = userData.fname;
        document.getElementById('lname').value = userData.lname;
        document.getElementById('email').value = userData.email;
    </script> -->
</body>

</html>