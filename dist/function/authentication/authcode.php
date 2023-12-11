<!-- Sign Up  -->
<?php

use MyApp\Controller\Chat\ChatUser;


require_once __DIR__ . '/../../../vendor/autoload.php';
session_start();
require('../config.php'); //PDO connection to the database



// LOG IN
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // loging in
    $sql_check = "SELECT * FROM user WHERE email = :email";
    $stmt = $conn->prepare($sql_check);
    // binding the parameters
    $stmt->bindParam(':email', $email);
    //execute the query
    $stmt->execute();
    $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1 && password_verify($password, $userdata['password'])) { //account exists
       // Retrieve the data and put it in the variable $userdata so that it can save the information
        $userType = $userdata["user_type"];
        $userID = $userdata["user_id"]; // Get the ID of the logged-in user
        $userStatus = $userdata["user_status"];

        $user_object = new ChatUser;
        $user_object->setUserEmail($email);
        $user_data = $user_object->get_user_data_by_email();
        $user_object->setUserId($userID);

        $user_object->setUserLoginStatus('Login');

        $user_token = md5(uniqid());

        $user_object->setUserToken($user_token);
        $user_object->update_user_login_data();

        if ($userStatus === 'Disabled') { 
            $_SESSION['email'] = $email;
            // Redirect to login page if the user status is 'Disabled'
            echo '<script language="javascript">';
              echo 'alert("Your account is not verified! Please verify it first!");';
              echo 'window.location.href = "../../verify.php";';  // Redirect using JavaScript
              echo '</script>';
            exit();
          }
        if ($userType === '1') {
            // Redirect admin to an admin dashboard
            $_SESSION['auth'] = true;
        
            $_SESSION['auth_user'] = [
                'id' => $userID,
                // Save the ID in the session
                'fname' => $userdata['fname'],
                'lname' => $userdata['lname'],
                'email' => $userdata['email'],
                'role' => "1",
                'token' =>  $user_token,
                'user_status' => $user_status // assuming 'user_status' is part of the session data

            ];

            echo '<script language="javascript">';
           
            echo 'alert("Logged In Successfully as Admin");';
            echo '</script>';
            header("Location: ../admin/admin-dashboard.php");
        } 
        else if ($userType === '2') {
            // Redirect user to a user dashboard
            $_SESSION['auth'] = true;
            
            $_SESSION['auth_user'] = [
                'id' => $userID,
                // Save the ID in the session
                'fname' => $userdata['fname'],
                'lname' => $userdata['lname'],
                'email' => $userdata['email'],
                'role' => "2",
                'token' =>  $user_token,
                'user_status' => $userStatus // assuming 'user_status' is part of the session data

            ];
            if (isset($_POST['remember_me'])) {
                // Set secure and HTTP-only cookies for remembering email and password
                setcookie('email', $_POST['email'], time() + (60 * 60 * 24), '/', '', true, true);
                setcookie('password', $_POST['password'], time() + (60 * 60 * 24), '/', '', true, true);
           
            echo '<script language="javascript">';
            header("Location: ../user/home.php");
            echo '</script>';
            }
            else{
                setcookie('email','', time() - (60 * 60 * 24), '/', '', false, false);
                setcookie('password','', time() - (60 * 60 * 24), '/', '', false, false);

            }
        echo '<script language="javascript">';
        header("Location: ../user/home.php");
        echo '</script>';
        }
        
    } else {
        // Login failed
        echo '<script language="javascript">';
        echo 'alert("Invalid username or password. Please try again.");';
        echo 'window.location = "../../loginpage.php";';
        echo '</script>';
        $conn = null;
    }

    $conn = null;
}

   

?>