<?php
require '../function/config.php';
session_start();

// Count total appointments
$sql_total = "SELECT COUNT(*) AS total FROM appointment"; 
$stmtTotal = $conn->prepare($sql_total); //we prepared the sql query by using the 'prepare' function
$stmtTotal->execute();
$rowTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC); //We fetch the result using fetch(PDO::FETCH_ASSOC) to get an associative array.
$totalAppointments = $rowTotal['total'];

// $queryTotal = "SELECT COUNT(*) AS total FROM appointment";
// $resultTotal = mysqli_query($conn, $queryTotal);
// $rowTotal = mysqli_fetch_assoc($resultTotal);
// $totalAppointments = $rowTotal['total'];

// Count appointments for each category
$sql_adopt = "SELECT COUNT(*) AS adopt FROM appointment WHERE appointment_type = 'Adopt'";
$stmtAdopt = $conn->prepare($sql_adopt);
$stmtAdopt->execute();
$rowAdopt = $stmtAdopt->fetch(PDO::FETCH_ASSOC);
$countAdopt = $rowAdopt['adopt'];

// $queryAdopt = "SELECT COUNT(*) AS adopt FROM appointment WHERE appointment_type = 'Adopt'";
// $resultAdopt = mysqli_query($conn, $queryAdopt);
// $rowAdopt = mysqli_fetch_assoc($resultAdopt);
// $countAdopt = $rowAdopt['adopt'];

$sql_donate = "SELECT COUNT(*) AS donate FROM appointment WHERE appointment_type = 'Donate'";
$stmtDonate = $conn->prepare($sql_donate);
$stmtDonate->execute();
$rowDonate = $stmtDonate->fetch(PDO::FETCH_ASSOC);
$countDonate = $rowDonate['donate'];

// $queryDonate = "SELECT COUNT(*) AS donate FROM appointment WHERE appointment_type = 'Donate'";
// $resultDonate = mysqli_query($conn, $queryDonate);
// $rowDonate = mysqli_fetch_assoc($resultDonate);
// $countDonate = $rowDonate['donate'];

$sql_visit = "SELECT COUNT(*) AS visit FROM appointment WHERE appointment_type = 'Visit'";
$stmtVisit = $conn->prepare($sql_visit);
$stmtVisit->execute();
$rowVisit = $stmtVisit->fetch(PDO::FETCH_ASSOC);
$countVisit = $rowVisit['visit'];

// $queryVisit = "SELECT COUNT(*) AS visit FROM appointment WHERE appointment_type = 'Visit'";
// $resultVisit = mysqli_query($conn, $queryVisit);
// $rowVisit = mysqli_fetch_assoc($resultVisit);
// $countVisit = $rowVisit['visit'];

$sql_volunteer = "SELECT COUNT(*) AS volunteer FROM appointment WHERE appointment_type = 'Volunteer'";
$stmtVolunteer = $conn->prepare($sql_volunteer);
$stmtVolunteer->execute();
$rowVolunteer = $stmtVolunteer->fetch(PDO::FETCH_ASSOC);
$countVolunteer = $rowVolunteer['volunteer'];

// $queryVolunteer = "SELECT COUNT(*) AS volunteer FROM appointment WHERE appointment_type = 'Volunteer'";
// $resultVolunteer = mysqli_query($conn, $queryVolunteer);
// $rowVolunteer = mysqli_fetch_assoc($resultVolunteer);
// $countVolunteer = $rowVolunteer['volunteer'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin-dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


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


                    // if (moment(selectedDate).isBefore(today)) {
                    //     // Do not select the date if it is before the current day
                    //     $('#calendar').fullCalendar('unselect');
                    //     return;
                    // }

                    $('#date-input').val(selectedDate).change(); // Update the input value and trigger change event
                },
                events: [
                    // Example of dynamically generated events from the database
                    <?php
                    // Retrieve the dates from the appointment table in the database
                    $sql = "SELECT appointment_date, time_slot FROM appointment";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $events = [];
                    // $result = mysqli_query($conn, $query);

                    // Generate event objects for each date
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  //We fetch the result using fetch(PDO::FETCH_ASSOC) to get an associative array.
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
    <style>
        a,
        .form-control {
            text-decoration: none !important;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="../index.php" class="logo"><img src="../image/logo (1).png" class="img-logo"></a>
        <a href="javascript:void(0);" class="list" onclick="logout()">Logout</a>
    </nav>
    <div class="setting">
        <div class="sidebar">
            <a href="admin-dashboard.php" class="menu"> Dashboard</a>
            <a href="admin-add-pets.php" class="menu"> Add Pets</a>
            <a href="admin-manage-pets.php" class="menu"> Manage Pets</a>
            <a href="admin-manage-featured.php" class="menu"> Modify Featured Image</a>
            <a href="admin-manage-user.php" class="menu"> Manage Users</a>
            <a href="admin-add-news.php" class="menu"> Add News</a>
            <a href="admin-manage-news.php" class="menu"> Manage News</a>
        </div>
        <div class="main">

            <div class="dashboard">
                <div class="card total">
                    <i class="fas fa-calendar-check card-icon"></i>
                    <div class="card-number">
                        <?php echo $totalAppointments; ?>
                    </div>
                    <div class="card-text">Total Appointments</div>
                </div>
            </div>
            <div class="dashboard2">
                <div class="card adopt">
                    <i class="fas fa-paw card-icon"></i>
                    <div class="card-number">
                        <?php echo $countAdopt; ?>
                    </div>
                    <div class="card-text">Adopt</div>
                </div>
                <div class="card adopt">
                    <i class="fas fa-hand-holding-heart card-icon"></i>
                    <div class="card-number">
                        <?php echo $countDonate; ?>
                    </div>
                    <div class="card-text">Donate</div>
                </div>
            </div>
            <div class="dashboard3">
                <div class="card adopt">
                    <i class="fas fa-eye card-icon"></i>
                    <div class="card-number">
                        <?php echo $countVisit; ?>
                    </div>
                    <div class="card-text">Visit</div>
                </div>
                <div class="card adopt">
                    <i class="fas fa-hands-helping card-icon"></i>
                    <div class="card-number">
                        <?php echo $countVolunteer; ?>
                    </div>
                    <div class="card-text">Volunteer</div>
                </div>
            </div>
            <div class="content">
                <div class="calendar-container">
                    <div id="calendar"></div>
                </div>
            </div>

            <form action="" method="post">
                <input type="date" class="form-control" name="date-input" id="date-input" required
                    onchange="submitForm()">
            </form>

            <script>
                // Define the submitForm function
                function submitForm() {
                    // Submit the form
                    document.getElementById('date-input').closest('form').submit();
                }
            </script>


            <?php
            if (isset($_POST['date-input'])) {
                $date = $_POST['date-input'];
            } else {
                $date = date("Y-m-d"); // Get today's date
            }

            // Convert the date to words
            $dateInWords = date("F j, Y", strtotime($date));

            echo '<div class="date-container">';
            echo '<div class="date">' . $dateInWords . '</div>';
            echo '</div>';
            ?>


            <div class="appointment-container">
                <div class="title">Morning Session</div>

                <table class="appointment-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Mobile #</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if the date-input field is submitted //code for accepting appointments in the morning session
                        if (isset($_POST['date-input'])) {
                            // Retrieve the selected date from the input field
                            $date = $_POST['date-input'];

                            // Retrieve the selected time slot
                            $time_slot = 'Morning Session';

                            // Query the database to fetch the appointments for the selected date and time slot
                            // $query = "SELECT * FROM appointment WHERE appointment_date = '$date' AND time_slot = '$time_slot'";
                            // $result = mysqli_query($conn, $query);

                            $sql = "SELECT * FROM appointment WHERE appointment_date = :date AND time_slot = :time_slot";
                            $result = $conn->prepare($sql); // sql query of php pdo
                            $result->bindParam(':date', $date, PDO::PARAM_STR);
                            $result->bindParam(':time_slot', $time_slot, PDO::PARAM_STR);
                            // Execute the query
                            $result->execute();

                            // $result = mysqli_query($conn, $query);

                            // Check if there are any appointments
                            if ($result->rowCount() > 0) {
                                // Iterate over each appointment and create table rows
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    $type = $row['appointment_type'];
                                    $firstName = $row['first_name'];
                                    $middleName = $row['middle_name'];
                                    $lastName = $row['last_name'];
                                    $mobile = $row['mobile_number'];
                                    $address = $row['home_address'];
                                    $email = $row['email_address'];
                                    $time = $row['time_slot'];
                                    $status = $row['status'];
                                    $appointmentId = $row['appointment_id'];

                                    // Combine the first name, middle name, and last name
                                    $fullName = $firstName . ' ' . $middleName . ' ' . $lastName;

                                    // Output the table rows with appointment details
                                    echo '<tr>';
                                    echo '<td>' . $type . '</td>';
                                    echo '<td>' . $fullName . '</td>';
                                    echo '<td>' . $mobile . '</td>';
                                    echo '<td>' . $address . '</td>';
                                    echo '<td>' . $email . '</td>';
                                    echo '<td>';

                                    if ($status == 'Pending') {
                                        // Show the "Accept" and "Cancel" buttons
                                        echo '<button class="btn btn-success accept-btn" data-appointment-id="' . $appointmentId . '">Accept</button>';
                                        echo '<button class="btn btn-danger cancel-btn" data-appointment-id="' . $appointmentId . '">Cancel</button>';
                                    } else {
                                        // Show the status value
                                        echo $status;
                                    }

                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                // No appointments found for the selected date and time slot
                                echo '<tr><td colspan="8">No appointments available</td></tr>';
                            }

                        }
                        ?>
                    </tbody>
                </table>


            </div>

            <div class="appointment-container2">
                <div class="title">Afternoon Session</div>

                <table class="appointment-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Mobile #</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if the date-input field is submitted
                        if (isset($_POST['date-input'])) {
                            // Retrieve the selected date from the input field
                            $date = $_POST['date-input'];

                            // Retrieve the selected time slot
                            $time_slot = 'Afternoon Session';

                            // Query the database to fetch the appointments for the selected date and time slot
                            $sql = "SELECT * FROM appointment WHERE appointment_date = :date AND time_slot = :time_slot";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                            $stmt->bindParam(':time_slot', $time_slot, PDO::PARAM_STR);
                            $stmt->execute();
                            // $result = mysqli_query($conn, $query);

                            // Check if there are any appointments
                            if ($stmt->rowCount() > 0) {
                                // Iterate over each appointment and create table rows
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $type = $row['appointment_type'];
                                    $firstName = $row['first_name'];
                                    $middleName = $row['middle_name'];
                                    $lastName = $row['last_name'];
                                    $mobile = $row['mobile_number'];
                                    $address = $row['home_address'];
                                    $email = $row['email_address'];
                                    $time = $row['time_slot'];
                                    $status = $row['status'];
                                    $appointmentId = $row['appointment_id'];
                                    $userId = $row['user_id'];

                                    // Combine the first name, middle name, and last name
                                    $fullName = $firstName . ' ' . $middleName . ' ' . $lastName;

                                    // Output the table rows with appointment details
                                    echo '<tr>';
                                    echo '<td>' . $type . '</td>';
                                    echo '<td>' . $fullName . '</td>';
                                    echo '<td>' . $mobile . '</td>';
                                    echo '<td>' . $address . '</td>';
                                    echo '<td>' . $email . '</td>';
                                    echo '<td>';

                                    if ($status == 'Pending') {
                                        // Show the "Accept" and "Cancel" buttons
                                        echo '<button class="btn btn-success accept-btn" data-appointment-id="' . $appointmentId . '">Accept</button>';
                                        echo '<button class="btn btn-danger cancel-btn" data-appointment-id="' . $appointmentId . '">Cancel</button>';
                                    } else {
                                        // Show the status value
                                        echo $status;
                                    }

                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                // No appointments found for the selected date and time slot
                                echo '<tr><td colspan="8">No appointments available</td></tr>';
                            }

                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>

<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            // Perform logout action
            window.location.href = "../function/logout.php";
        }
    }
</script>


<script>
    // Get all the "Accept" buttons
    const acceptButtons = document.querySelectorAll('.accept-btn');
    acceptButtons.forEach(button => {
        button.addEventListener('click', function () {
            const appointmentId = this.dataset.appointmentId;
            updateStatus(appointmentId, 'Accepted');
        });
    });

    // Get all the "Cancel" buttons
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function () {
            const appointmentId = this.dataset.appointmentId;
            updateStatus(appointmentId, 'Cancelled');
        });
    });

    // Function to update the status via AJAX
    function updateStatus(appointmentId, status) {
        // Make an AJAX request to update the status
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../function/update_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            // Check if the request was successful
            if (xhr.status === 200) {
                // Reload the page to reflect the updated status
                location.reload();
            }
        };
        xhr.send('appointmentId=' + appointmentId + '&status=' + status);
    }
</script>