<?php 
    session_start(); // Add this line to start the session
    if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
        header("Location: ../admin/admin-dashboard.php");
        exit();
    }
    if (!isset($_SESSION['auth_user'])) { 
        header("Location: ../error/403-forbidden.html");
        exit();
    }

    // if (!isset($_POST['fname'])){
    //     header("Location: ../user/appointment.php");
    //     exit();
    // }
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time_slot = $_POST['time-slot'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo.png" type="image/png">
    <link rel="stylesheet" href="..\css\newlyAdded\appointment-confirmation.css">
    <link rel="stylesheet" href="..\css\colorStyle\user\appointment_confirm-color.css">
    <title>Appointment Confirmation</title>
</head>
<body>

        <?php require_once "../components/user/userNavbar.php"?>
    <div class="container-1">
        <form action="../function/user/makeAppointment.php" method="post">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Appointment Confirmation</span>
                    <div class="fields">                  

                        <div class="input-field">
                            <label for="fname">First Name:</label>
                            <input type="text" name="fname" id="fname" required readonly value = "<?php echo $fname?>">
                        </div>
                        <div class="input-field">
                            <label for="lname">Last Name:</label>
                            <input type="text" name="lname" id="lname"  required readonly value = "<?php echo $lname?>">
                        </div>
                        <div class="input-field">
                            <label for="mobile">Mobile:</label>
                            <input type="tel" name="mobile" id="mobile" required readonly value = "<?php echo $mobile?>">
                        </div>
                        <div class="input-field">
                            <label for="address">Home Address:</label>
                            <input type="text" name="address" id="address" required readonly value = "<?php echo $address?>">
                        </div>
                        <div class="input-field">
                        <label for="type">Type:</label>
                            <input type="text" name="type" id="type" required readonly value = "<?php echo $type?>">
                        </div>
                    </div>

                    
                    <div class="fields">
                        <div class="input-field">
                        <label for="date">Date:</label>
                        <input type="date" name="date" id="date-input" required readonly value = "<?php echo $date?>">
                        <input type="text" name = "time-slot" id="time-slot" required readonly value = "<?php echo $time_slot?>">
                        </div>
                    </div>
                        <br><br>
                    <p>
                       Make sure that the above confirmation is correct. You are welcome to go back to the previous page. If you are to proceed, please check your email for the confirmation.
                    </p>
                    <button type="submit" name="go_back" id="submit">Go Back</button>
                    <button type="submit" name="appoint" id="submit">Confirm</button>
                </div>
            </div>
        </form>
    </div>
    <?php require_once "../components/user/footer.html"?>
    <?php require_once "..\components\light-switch.php"?>
    <?php require_once "..\components\call_across_pages.php"?>
</body>
</html>