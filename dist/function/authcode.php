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
    
    
    // $fname = mysqli_real_escape_string($conn, $_POST["fname"]); //code ni aian
    // $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    // $email = mysqli_real_escape_string($conn, $_POST["email"]);
    // $password = mysqli_real_escape_string($conn, $_POST["password"]);
    // $cpassword = mysqli_real_escape_string($conn, $_POST["cpassword"]);

    // $check_email_query = "SELECT email FROM user WHERE email='$email'";
    // $searchEmail = "test@gmail.com";

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
        echo "Hello :)";
        $conn = null;
    } 
    else {
        echo "Data does not exist.";
        if ($password == $passwordRepeat){
            //insert user data
            $sql_insert = "INSERT INTO user (fname, lname, email, password, user_type) VALUES(:fname, :lname , :email, :password, 2)";
            $stmt = $conn->prepare($sql_insert);
            // Bind the parameter, needed in using PDO
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname); 
            $stmt->bindParam(':email', $email); 
            $stmt->bindParam(':password', $password); 
            // Execute the query
            if ($stmt->execute()) {
                echo '<script language="javascript">';
                echo 'alert("Sign up sucessfully");';
                echo 'window.location = "../home.php";';
                echo '</script>';
            } else {
                echo "Error inserting record: " . $stmt->errorInfo()[2];
            }
            $conn = null;
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
                'email' => $userdata['email']
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
                'email' => $userdata['email']
            ];
            echo '<script language="javascript">';
            echo 'window.location = "../user/home.php";';
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