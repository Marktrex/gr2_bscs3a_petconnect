<?php
session_start();
require '../function/config.php';
// print_r($_SESSION);

if (!isset($_SESSION['token'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: home.php");
    exit();
} 

if (isset($_POST['changepass'])) {
    $token = $_SESSION['token'];
    $newpassword = $_POST['newpassword'];
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
        $statement2->bindParam(':email', $email, PDO::PARAM_STR);

        if (!$statement2->execute()) {
            print_r($statement2->errorInfo());
            exit();
        } else {
            ?>
            <script>
              
                window.location.replace("confirm.html");

            </script>
            <?php
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect | Change Password</title>
    <link rel="stylesheet" href="..\css\newlyAdded\reset-password.css">
    <script>
        function validateForm() {
            var newPassword = document.getElementById("new-password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            if (newPassword !== confirmPassword) {
                alert("New password and confirm password do not match!");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Reset your password</h1>
        <p>
            Enter your new password. 
            Make sure to not forget your new password!
        <form action="#" method="POST" onsubmit="return validateForm();">
        <div class="code-container">
            <input id="new-password" type="password" name="newpassword" placeholder="Enter your New Password" required>
            <input id="confirm-password" type="password" placeholder="Confirm new Password" required>
        </div>

        <div>
            <button type="submit" class="btn btn-verify" name="changepass">Update Password</button>
        </div>
        </form>
    </div>
</body>
</html>
