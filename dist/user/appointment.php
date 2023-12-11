<?php

use MyApp\Controller\UserModelController;
use MyApp\Controller\AppointmentModelController;
session_start(); // Add this line to start the session
//is admin
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
//not logged in
if (!isset($_SESSION['auth_user'])) { 
    header("Location: ../error/403-forbidden.html");
    exit();
}


require_once __DIR__ . '/../../vendor/autoload.php';
require_once '../function/config.php';

$defaultDate = date('Y-m-d');
$userId = $_SESSION['auth_user']['id'];
//check if user already has an appointment
$appointmentController = new AppointmentModelController();

$searchWordsArray = [$userId, $defaultDate];
$columnsArray = [['user_id'], ['appointment_date']];
$tablesArray = [['appointment'], ['appointment']]; // replace 'appointments' with your actual table name
$operatorsArray = ['=', '>='];

$result = $appointmentController->searchV2($searchWordsArray, $columnsArray, $tablesArray, $operatorsArray);

// echo json_encode($result);
if (!empty($result)){
    header("Location: ../error/appointment.html");
    exit();
}

//Retrieve the user information by id
$user = new UserModelController();
$id = $_SESSION['auth_user']['id'];
$resultUser = $user->get_user_data_by_id($id);
$type = '';
$time_slot = '';
//Go back function for appointment confirmation
if (isset($_SESSION['appointment'])){
    $resultUser->fname = $_SESSION['appointment']['fname'];
    $resultUser->lname = $_SESSION['appointment']['lname'];
    $resultUser->mobile_number = $_SESSION['appointment']['mobile'];
    $resultUser->home_address = $_SESSION['appointment']['address'];
    $type = $_SESSION['appointment']['type'];
    $defaultDate = $_SESSION['appointment']['date'];
    $time_slot = $_SESSION['appointment']['time-slot'];
}


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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo.png" type="image/png">
    <title>Appointment</title>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    
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

                    updateOptions(selectedDate);
                },
                events: events,
            });

            calendar.render();

            var today = new Date();
            calendar.select(today.toISOString().slice(0, 10));

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
            function updateOptions(selectedDate) {
                // Check if there's a morning or afternoon session on the selected date
                var hasMorning = hasMorningSession(selectedDate);
                var hasAfternoon = hasAfternoonSession(selectedDate);

                // Get the time slot select box and the hint element
                var timeSlotSelect = document.getElementById('time-slot');
                var hint = document.getElementById('hint');

                timeSlotSelect.value = '';

                var disabledOptions = 0;
                for (var i = 0; i < timeSlotSelect.options.length; i++) {
                    var option = timeSlotSelect.options[i];
                    if ((option.value === 'Morning Session' && hasMorning) || 
                        (option.value === 'Afternoon Session' && hasAfternoon)) {
                        option.disabled = true;
                        disabledOptions++;
                    } else {
                        option.disabled = false;
                    }
                }
                // Update the hint text
                if (disabledOptions === timeSlotSelect.options.length - 1) {
                    hint.textContent = 'This day has been fully booked, please select another date.';
                } else {
                    hint.textContent = '';
                }
            }
        });
    </script>
</head>
<body>
    Make an appointment
    <form action="appointment_confirm.php" method="post">
        <div>
            <label for="fname">First Name:<span> *</span></label>
            <input type="text" id="fname" name="fname" required value = "<?php echo $resultUser->fname?>">
        </div>
        <div>
            <label for="lname">Last Name:<span> *</span></label>
            <input type="text" id="lname" name="lname" required value = "<?php echo $resultUser->fname?>">
        </div>
        <div>
            <label for="mobile">Mobile Number:<span> *</span></label>
            <input type="tel" id="mobile" name="mobile" required value = "<?php echo $resultUser->mobile_number?>">
        </div>
        <div>
            <label for="address">Home Address:<span> *</span></label>
            <input type="text" id="address" name="address" required value = "<?php echo $resultUser->home_address?>">
        </div>
        <select name="type" id="type" required>
            <option value="">Select</option>
            <option value="Adopt" <?php echo $type == 'Adopt' ? 'selected' : ''; ?>>Adopt</option>
            <option value="Donate" <?php echo $type == 'Donate' ? 'selected' : ''; ?>>Donate</option>
            <option value="Visit" <?php echo $type == 'Visit' ? 'selected' : ''; ?>>Visit</option>
            <option value="Volunteer" <?php echo $type == 'Volunteer' ? 'selected' : ''; ?>>Volunteer</option>
        </select>
        <div class="calendar-container">
            <h2 class="title">CHOOSE APPOINTMENT DATE</h2>
            <h2 class="cl">Schedule Calendar</h2>
            <div id="calendar"></div>
        </div>
        <label for="date">Date:</label>
        <input type="date"name="date" id="date-input" required
            value="<?php echo $defaultDate; ?>" readonly>
        <select id="time-slot" name="time-slot" class="form-control" required>
            <option value="">Select Session</option>
            <option value="Morning Session" <?php echo $time_slot == 'Morning Session' ? 'selected' : ''; ?>>Morning Session (9:00 AM - 11:30 AM)</option>
            <option value="Afternoon Session" <?php echo $time_slot == 'Afternoon Session' ? 'selected' : ''; ?>>Afternoon Session (1:00 PM - 4:30 PM)</option>
        </select>
        <p id="hint" style="color: red;"></p>
        <button type="submit">Confirm</button>
    </form>
    <?php require_once "..\components\call_across_pages.php"?>
</body>
</html>