<?php
session_start(); // Add this line to start the session
require '../function/config.php';
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
} 
if (isset($_SESSION['auth_user'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: ../user/home.php");
    exit();
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
    <link rel="stylesheet" href="../css/notification.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>
    <section class="home">
        <div class="contact-wrapper">
            <div class="contact-wrapper">
                <div class="contact-container">
                    <div class="contact-info">
                        <p>
                            <?php                               

                            // Fetch the message for a specific appointment
                            if (isset($_GET['appointmentId'])) {
                                $appointmentId = $_GET['appointmentId'];

                                // Query the appointment table to retrieve the message
                                $sql = "SELECT message FROM appointment WHERE appointment_id = :appointment_id";
                                $result = $conn->prepare($sql);
                                $result->bindParam(':appointment_id', $appointmentId, PDO::PARAM_INT);
                                $result->execute();

                                // Check if a message is found
                                if ($result->rowCount() > 0) {
                                    // Display the message
                                    $row = $result->fetch(PDO::FETCH_ASSOC);
                                    $message = $row['message'];
                                    $formattedMessage = nl2br($message); // Convert new lines to HTML line breaks
                                    ?>
                                    <p>
                                        <?php echo $formattedMessage; ?>
                                    </p>
                                    <?php
                                } else {
                                    // No message found for the specified appointment
                                    ?>
                                    <p>No message found for this appointment.</p>
                                    <?php
                                }
                            } else {
                                // No appointment ID provided
                                ?>
                                <p>No appointment ID provided.</p>
                                <?php
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>


    </section>

    <?php include '../function/footer.php' ?>

</body>

</html>