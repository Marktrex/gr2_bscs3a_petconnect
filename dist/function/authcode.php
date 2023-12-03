<!-- Sign Up  -->
<?php
use MyApp\Controller\AuditModelController;

require_once __DIR__ . '/../../vendor/autoload.php';
session_start();
require('config.php'); //PDO connection to the database

// for chat user
require('../../database/ChatUser.php');


$log = new AuditModelController();
if (isset($_POST["register"])) { //code ni marc
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["cpassword"];
    
    
    //php using PDO
    $sql_check = "SELECT * FROM user WHERE email = :email";
    $stmt = $conn->prepare($sql_check);
    // Bind the parameter
    $stmt->bindParam(':email', $email);
    // Execute the query
    $stmt->execute();
    // Count the number of rows returned
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        echo '<script language="javascript">';
        echo 'alert("Email already exist");';
        echo 'window.location = "../signuppage.php";';
        echo '</script>';
        $conn = null;
    } 
    else {
        
        if ($password == $passwordRepeat) {
            // Passwords match, proceed with insertion
            $password = password_hash($password, PASSWORD_DEFAULT);
            // Set the common user_type for both queries
            $user_status = 'Enable';
            $user_type = '2';
            $type = 'User';
            // Insert into user table
            $query2 = "
                INSERT INTO user (fname, lname, email, password, user_type) 
                VALUES (:fname, :lname , :email, :password, :user_type)
            ";
        
            $statement2 = $conn->prepare($query2);
            $statement2->bindParam(':fname', $fname);
            $statement2->bindParam(':lname', $lname);
            $statement2->bindParam(':email', $email);
            $statement2->bindParam(':password', $password);
            $statement2->bindParam(':user_type', $user_type);
        
            // Execute both queries
            $conn->beginTransaction();
        
            try {
                $statement2->execute();
                $lastId = $conn->lastInsertId();
                // If both queries are successful, commit the transaction
                $conn->commit();
                $log->activity_log($lastId, 'Register', 'Created a new user account');
                echo '<script language="javascript">';
                echo 'alert("Sign up successfully");';
                echo 'window.location = "../loginpage.php";';
                echo '</script>';
            } catch (PDOException $e) {
                // If any query fails, roll back the transaction
                $conn->rollBack();
        
                echo "Error inserting record: " . $e->getMessage();
            }
        }
        else
        {
            echo '<script language="javascript">';
            echo 'alert("Password and confirm password must be the same");';
            echo 'window.location = "../signuppage.php";';
            echo '</script>';
        }
    }
}
// LOG IN
else if (isset($_POST["login"])) {
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
                'token' =>  $user_token
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
                'token' =>  $user_token
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
        echo 'window.location = "../loginpage.php";';
        echo '</script>';
        $conn = null;
    }

    $conn = null;
}

   

?>