<?php require './function/config.php' ?>
<?php
session_start(); // Add this line to start the session
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="css/notification.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include './function/navbar.php' ?>
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
                                $query = "SELECT message FROM appointment WHERE appointment_id = '$appointmentId'";
                                $result = mysqli_query($conn, $query);

                                // Check if a message is found
                                if (mysqli_num_rows($result) > 0) {
                                    // Display the message
                                    $row = mysqli_fetch_assoc($result);
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

    <?php include './function/footer.php' ?>

</body>

</html>