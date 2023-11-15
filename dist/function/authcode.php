<!-- Sign Up  -->
<?php
session_start();
require('config.php'); //PDO connection to the database

if (isset($_POST["register"])) { //code ni marc
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["password"];
    
    
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
        // echo "Hello :)";
        $conn = null;
    } 
    else {
        echo "Data does not exist.";
        if ($password == $passwordRepeat) {
            // Passwords match, proceed with insertion
        
            // Set the common user_type for both queries
            $user_status = 'Enable';
            $user_type = '2';
            $type = 'User';
            // Insert into chat_user_table
            $query1 = "
                INSERT INTO chat_user_table (user_name, user_email, user_password, user_status, user_type) 
                VALUES (:fname, :email, :password , :user_status, :user_type)
            ";
             // automatically set the user_type to "User" when creating an account
            $statement1 = $conn->prepare($query1);
            $statement1->bindParam(':fname', $fname);
            $statement1->bindParam(':email', $email);
            $statement1->bindParam(':password', $password);
            $statement1->bindParam(':user_status', $user_status); // Set the user_status to 'User'
            $statement1->bindParam(':user_type', $type); // Set user_type to 'User'

        
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
                $statement1->execute();
                $statement2->execute();
        
                // If both queries are successful, commit the transaction
                $conn->commit();
        
                echo '<script language="javascript">';
                echo 'alert("Sign up successfully");';
                echo 'window.location = "../user/home.php";';
                echo '</script>';
            } catch (PDOException $e) {
                // If any query fails, roll back the transaction
                $conn->rollBack();
        
                echo "Error inserting record: " . $e->getMessage();
            }
        }
    }
}
// LOG IN
else if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // loging in
    $sql_check = "SELECT * FROM user WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($sql_check);
    // binding the parameters
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    //execute the query
    $stmt->execute();
    // $rowCount = $stmt->rowCount();


    if ($stmt->rowCount() == 1) { //account exists
       // Retrieve the data and put it in the variable $userdata so that it can save the information
        $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
        $userType = $userdata["user_type"];
        $userID = $userdata["user_id"]; // Get the ID of the logged-in user
        
        if ($userType === '1') {
            // Redirect admin to an admin dashboard
            $_SESSION['auth'] = true;
        
            $_SESSION['auth_user'] = [
                'id' => $userID,
                // Save the ID in the session
                'fname' => $userdata['fname'],
                'lname' => $userdata['lname'],
                'email' => $userdata['email'],
                'role' => "1"
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
                'role' => "2"
            ];
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