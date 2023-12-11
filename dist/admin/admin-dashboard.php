<?php

use MyApp\Controller\AppointmentModelController;
require_once __DIR__ . '/../../vendor/autoload.php';
require '../function/config.php';
session_start();

if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "1" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}

// Count total appointments
$sql_total = "SELECT COUNT(*) AS total FROM appointment"; 
$stmtTotal = $conn->prepare($sql_total); //we prepared the sql query by using the 'prepare' function
$stmtTotal->execute();
$rowTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC); //We fetch the result using fetch(PDO::FETCH_ASSOC) to get an associative array.
$totalAppointments = $rowTotal['total'];

// Count appointments for each category
$sql_adopt = "SELECT COUNT(*) AS adopt FROM appointment WHERE appointment_type = 'Adopt'";
$stmtAdopt = $conn->prepare($sql_adopt);
$stmtAdopt->execute();
$rowAdopt = $stmtAdopt->fetch(PDO::FETCH_ASSOC);
$countAdopt = $rowAdopt['adopt'];


$sql_donate = "SELECT COUNT(*) AS donate FROM appointment WHERE appointment_type = 'Donate'";
$stmtDonate = $conn->prepare($sql_donate);
$stmtDonate->execute();
$rowDonate = $stmtDonate->fetch(PDO::FETCH_ASSOC);
$countDonate = $rowDonate['donate'];


$sql_visit = "SELECT COUNT(*) AS visit FROM appointment WHERE appointment_type = 'Visit'";
$stmtVisit = $conn->prepare($sql_visit);
$stmtVisit->execute();
$rowVisit = $stmtVisit->fetch(PDO::FETCH_ASSOC);
$countVisit = $rowVisit['visit'];


$sql_volunteer = "SELECT COUNT(*) AS volunteer FROM appointment WHERE appointment_type = 'Volunteer'";
$stmtVolunteer = $conn->prepare($sql_volunteer);
$stmtVolunteer->execute();
$rowVolunteer = $stmtVolunteer->fetch(PDO::FETCH_ASSOC);
$countVolunteer = $rowVolunteer['volunteer'];

// Retrieve the dates from the appointment table in the database
$query = "SELECT appointment_date, time_slot FROM appointment";
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch all the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate event objects for each date
$events = [];
foreach ($results as $row) {
    $date = $row['appointment_date'];
    $time_slot = $row['time_slot'];

    $event = [
        "title" => "$time_slot",
        "start" => $date
    ];
    $events[] = $event;
}

// Sort the events based on the title
usort($events, function($a, $b) {
    return strcmp($a['title'], $b['title']);
});

// Encode the events array to a JSON string
$eventsJson = json_encode($events);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- content style position -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/admin-dashboard-light.css" />

    <!-- for layout color -->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/admin-layout-colors.css" />

    <!-- layout style position-->
    <link rel="stylesheet" type="text/css" href="../css/newlyAdded/layout-light.css" />

    <!-- for calendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    
</head>

<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var dateInput = document.getElementById('date-input');

            var events = <?php echo $eventsJson; ?>;
            events = events.map(event => {
                if ((event.title === 'Afternoon Session' && hasMorningSession(event.start))) {
                    return {
                        ...event,
                        classNames: ['unselectable'],
                        backgroundColor: 'green',
                        borderColor: '#fad046'
                    };
                }
                return event;
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                selectable: true,
                select: function(info) {
                    var selectedDate = info.startStr;
                    var today = new Date().toISOString().slice(0, 10);

                    if (selectedDate < today) {
                        calendar.unselect();
                        return;
                    }

                    dateInput.value = selectedDate;
                    dateInput.dispatchEvent(new Event('change'));
                },
                events: events,
            });

            calendar.render();

            function hasMorningSession(date) {
                return events.some(function(event) {
                    return event.title === 'Morning Session' && event.start.slice(0, 10) === date.slice(0, 10);
                });
            }

            function hasAfternoonSession(date) {
                return events.some(function(event) {
                    return event.title === 'Afternoon Session' && event.start.slice(0, 10) === date.slice(0, 10);
                });
            }
        });
    </script>
    <div class="container">
        <header class="">
            <nav class="navbar">
                <a href="admin-dashboard.php" class="logo"
                    ><img src="../icons/logo.png" alt="Insert Logo" id="logIcon"
                /></a>
                <ul class="items">
                    <li>
                    <a class="" id="messages" href="../../privatechat.php"
                        ><i class="fa fa-envelope"></i
                    ></a>
                    </li>
                    <li>
                    <a class="" id="notifications" href="#"
                        ><i class="fa fa-bell"></i
                    ></a>
                    </li>
                    <li>
                    <a href="#"><img src="../icons/icons-user.png" alt="Profile" /></a>
                    </li>
                </ul>
            </nav>
        </header>
        <main class="content">
            <form action="" method="post" style = "display:none">
                <input type="date" id="date-input" name="date-input" onchange = "this.form.submit()">
            </form>
        <div id='calendar'></div>
            <div class="cards">
                <!--Adopt-->
                <div class="card">
                <i class="fa fa-paw fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        <?php echo $countAdopt?>
                    </div>
                    <h1>ADOPT</h1>
                </div>
                </div>
            <!--Volunteer-->
                <div class="card">
                <i class="fa fa-users fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        <?php echo $countVolunteer?>
                    </div>
                    <h1>VOLUNTEER</h1>
                </div>
                </div>
            <!--donate-->
                <div class="card">
                <i class="fa fa-money fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        <?php echo $countDonate?>
                    </div>
                    <h1>Donate</h1>
                </div>
                </div>
            <!--Visit-->
                <div class="card">
                <i class="fa fa-eye fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        <?php echo $countVisit?>
                    </div>
                    <h1>Visit</h1>
                </div>
                </div>            
            </div>
            <!-- tables for sessions -->
            <!-- morning -->
            <div class="table_responsive">
                <h2>Morning Session</h2>

                <table class="tables">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile #</th>
                            <th>Home Address</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            // Check if the date-input field is submitted //code for accepting appointments in the morning session
                            if (isset($_POST['date-input'])) {
                                // Retrieve the selected date from the input field
                                $date = $_POST['date-input'];

                                // Retrieve the selected time slot
                                $time_slot = 'Morning Session';

                                // Check if there are any appointments
                                $appointment = new AppointmentModelController();
                                $result = $appointment->search([$date, $time_slot], [["appointment_date"], ["time_slot"]], [true, true]);
                                if (count($result) > 0) {
                                    foreach ($result as $row) {
                                        // Combine the first name, middle name, and last name
                                        $fullName = $row->fname . ' ' . $row->lname;

                                        // Output the table rows with appointment details
                                        echo '<tr>';
                                        echo '<td>' . $row->appointment_type . '</td>';
                                        echo '<td>' . $fullName . '</td>';
                                        echo '<td>' . $row->mobile_number . '</td>';
                                        echo '<td>' . $row->home_address . '</td>';
                                        echo '<td>' . $row->email . '</td>';
                                        echo '<td>' .$row->status. '</td>';
                                        echo '<td>';
                                        if ($row->status == 'Pending') {
                                            // Show the "Accept" and "Cancel" buttons
                                            echo '<span class = "action-btn">';
                                            echo '<button type = "button" class="accept-btn" data-appointment-id="' . $row->appointment_id . '">Accept</button>';
                                            echo '<button type = "button" class="cancel-btn" data-appointment-id="' . $row->appointment_id . '">Cancel</button>';
                                            echo '</span>';
                                        } else {
                                            // Show the status value
                                            echo $row->status;
                                        }

                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    // No appointments found for the selected date and time slot
                                    echo '<tr><td colspan="7">No appointments available</td></tr>';
                                }

                            }
                            ?>
                        </tr>
                        
                    </tbody>
                </table>


            </div>
            <!-- afternoon -->
            <div class="table_responsive">
                <h2>Afternoon Session</h2>

                <table class="tables">


                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile #</th>
                            <th>Home Address</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            // Check if the date-input field is submitted //code for accepting appointments in the morning session
                            if (isset($_POST['date-input'])) {
                                // Retrieve the selected date from the input field
                                $date = $_POST['date-input'];

                                // Retrieve the selected time slot
                                $time_slot = 'Afternoon Session';

                                // Check if there are any appointments
                                $appointment = new AppointmentModelController();
                                $result = $appointment->search([$date, $time_slot], [["appointment_date"], ["time_slot"]], [true, true]);
                                if (count($result) > 0) {
                                    foreach ($result as $row) {
                                        // Combine the first name, middle name, and last name
                                        $fullName = $row->fname . ' ' . $row->lname;

                                        // Output the table rows with appointment details
                                        echo '<tr>';
                                        echo '<td>' . $row->appointment_type . '</td>';
                                        echo '<td>' . $fullName . '</td>';
                                        echo '<td>' . $row->mobile_number . '</td>';
                                        echo '<td>' . $row->home_address . '</td>';
                                        echo '<td>' . $row->email . '</td>';
                                        echo '<td>' .$row->status. '</td>';
                                        echo '<td>';
                                        if ($row->status == 'Pending') {
                                            // Show the "Accept" and "Cancel" buttons
                                            echo '<span class = "action-btn">';
                                            echo '<button type = "button" class="accept-btn" data-appointment-id="' . $row->appointment_id . '">Accept</button>';
                                            echo '<button type = "button" class="cancel-btn" data-appointment-id="' . $row->appointment_id . '">Cancel</button>';
                                            echo '</span>';
                                        } else {
                                            // Show the status value
                                            echo $row->status;
                                        }

                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    // No appointments found for the selected date and time slot
                                    echo '<tr><td colspan="7">No appointments available</td></tr>';
                                }

                            }
                            ?>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </main>
        
        <?php require_once "../components/admin/adminSidebar.php"?>        
    </div>
</body>

</html>

<script>
    // Attach event listeners to the document
    document.addEventListener('click', function(event) {
        event.preventDefault();
        // Check if the clicked element is an "Accept" button
        if (event.target.matches('.accept-btn')) {
            const appointmentId = event.target.dataset.appointmentId;
            updateStatus(appointmentId, 'Accepted');
        }
        // Check if the clicked element is a "Cancel" button
        else if (event.target.matches('.cancel-btn')) {
            const appointmentId = event.target.dataset.appointmentId;
            updateStatus(appointmentId, 'Cancelled');
        }
    });

    // Function to update the status via AJAX
    function updateStatus(appointmentId, status) {
        // Make an AJAX request to update the status
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../function/admin/update_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            // Check if the request was successful
            if (xhr.status === 200) {
                // Reload the page to reflect the updated status
                // location.reload();
            }
        };
        xhr.send('appointmentId=' + appointmentId + '&status=' + status);
    }
</script>


<script src="../script/admin-general.js"></script>