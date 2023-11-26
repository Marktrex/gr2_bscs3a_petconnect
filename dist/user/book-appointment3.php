<?php
session_start();
require '../function/config.php';
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
if (!isset($_SESSION['auth_user'])) { 
    echo '<script language="javascript">';
    echo 'alert("You do not have access to this page");';
    echo '</script>';
    header("Location: ../user/home.php");
    exit();
}  

$errorMessage = "";
// Check if there is an error message in the URL
if (isset($_GET['error']) && $_GET['error'] == 1) {
    $errorMessage = "The selected date and time slot are already booked. Please choose another slot.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the selected date and time slot from the form
    $date = $_POST["date"];
    $timeSlot = $_POST["time-slot"];

    // Check if the selected date and time slot are not in the database
    $sql = "SELECT * FROM appointment WHERE appointment_date = :date AND time_slot = :timeSlot";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':timeSlot', $timeSlot, PDO::PARAM_STR);
    $stmt->execute();
 
    if ($stmt->rowCount() > 0) {
        // The selected date and time slot are already booked, handle the error condition
        $errorMessage = "The selected date and time slot are already booked. Please choose another slot.";
    } else {
        // Store the data in the session
        $_SESSION["appointment_date"] = $date;
        $_SESSION["appointment_time_slot"] = $timeSlot;

        // Redirect to the next page or perform further actions
        header("Location: book-appointment4.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/book-appointment3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                selectable: true,
                select: function (start, end) {
                    var selectedDate = moment(start).format('YYYY-MM-DD');
                    var today = moment().startOf('day'); // Get the start of the current day

                    if (moment(selectedDate).isBefore(today)) {
                        // Do not select the date if it is before the current day
                        $('#calendar').fullCalendar('unselect');
                        return;
                    }

                    $('#date-input').val(selectedDate).change(); // Update the input value and trigger change event
                },
                events: [
                    // Example of dynamically generated events from the database
                    <?php
                    // Retrieve the dates from the appointment table in the database
                    $query = "SELECT appointment_date, time_slot FROM appointment";
                    $result = $conn->prepare($query);

                    // Generate event objects for each date
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $date = $row['appointment_date'];
                        $time_slot = $row['time_slot'];

                        $event = [
                            "title" => "$time_slot",
                            "start" => $date,
                            "end" => $date,
                            "color" => "#378006"
                        ];
                        echo json_encode($event) . ",";
                    }
                    ?>
                ],
                eventRender: function (event, element) {
                    // Check if there are two events on the same day
                    if (event.title === 'Morning Session' && hasAfternoonSession(event.start)) {
                        element.css('background-color', '#fad046'); // Set background color to #fad046
                        element.css('border-color', '#fad046');
                        element.addClass('unselectable'); // Add a class to disable selection of the date
                    } else if (event.title === 'Afternoon Session' && hasMorningSession(event.start)) {
                        element.css('background-color', '#fad046'); // Set background color to #fad046
                        element.css('border-color', '#fad046');
                        element.addClass('unselectable'); // Add a class to disable selection of the date
                    }
                },

            });

            // Check if there is a Morning Session on the given date
            function hasMorningSession(date) {
                var events = $('#calendar').fullCalendar('clientEvents');
                for (var i = 0; i < events.length; i++) {
                    if (events[i].title === 'Morning Session' && moment(events[i].start).isSame(date, 'day')) {
                        return true;
                    }
                }
                return false;
            }

            // Check if there is an Afternoon Session on the given date
            function hasAfternoonSession(date) {
                var events = $('#calendar').fullCalendar('clientEvents');
                for (var i = 0; i < events.length; i++) {
                    if (events[i].title === 'Afternoon Session' && moment(events[i].start).isSame(date, 'day')) {
                        return true;
                    }
                }
                return false;
            }
        });

    </script>


</head>

<body>
    <div class="main">
        <div class="navbar1" id="myNavbar">
            <a href="../index.php" class="logo"><img src="../image/logo (1).png" class="img-logo"></a>
            <h1>Make an Appointment</h1>
        </div>
        <div class="progress1">
            <img src="../image/book-appointment/progressbar3.png" alt="" class="progressbar">
        </div>
        <div class="content">
            <div class="calendar-container">
                <h2 class="title">CHOOSE APPOINTMENT DATE</h2>
                <h2 class="cl">Schedule Calendar</h2>
                <div id="calendar"></div>
            </div>
            <div class="info">
                <div class="available">
                    <div class="square"></div>
                    <h5>Available booking slots.</h5>
                </div>
            </div>
            <div class="info2">
                <div class="unavailable">
                    <div class="square"></div>
                    <h5>Slot on this day has been booked.</h5>
                </div>
            </div>
            <div class="container" style="margin-top: 20px;">
                <form method="POST">
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" name="date" id="date-input" required
                            min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <select id="time-slot" name="time-slot" class="form-control" required>
                            <option value="">Select Session</option>
                            <option value="Morning Session">Morning Session (9:00 AM - 11:30 AM)</option>
                            <option value="Afternoon Session">Afternoon Session (1:00 PM - 4:30 PM)</option>
                        </select>
                    </div>

                    <div class="notification error <?php echo empty($errorMessage) ? 'hidden' : ''; ?>">
                        <?php echo $errorMessage; ?>
                    </div>

                    <div class="col">
                        <a href="book-appointment2.php" class="btnn  back"
                            style="text-decoration:none; color: black;">Back</a>
                        <button type="submit" class="btnn next">Next</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>

</html>