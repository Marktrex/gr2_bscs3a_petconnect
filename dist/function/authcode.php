<!-- Sign Up  -->
<?php
use MyApp\Controller\AuditModelController;

require_once __DIR__ . '/../../vendor/autoload.php';
session_start();
require('config.php'); //PDO connection to the database

// for chat user
require('../../database/ChatUser.php');


$log = new AuditModelController();

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
                'user_status' => $userStatus

            ];


            $log->activity_log($_SESSION['auth_user']['id'], 'Login', 'User Logged In');
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
                'user_status' => $userStatus

            ];
    

            $log->activity_log($_SESSION['auth_user']['id'], 'Login', 'Admin Logged In');
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