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
    
    require_once '../function/config.php';
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

                    // Check if there's a morning or afternoon session on the selected date
                    var hasMorning = hasMorningSession(selectedDate);
                    var hasAfternoon = hasAfternoonSession(selectedDate);

                    // Get the time slot select box and the hint element
                    var timeSlotSelect = document.getElementById('time-slot');
                    var hint = document.getElementById('hint');

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
</head>
<body>
    
    Make an appointment
    <form action="" method="post">
        <div>
            <label for="first-name">First Name:<span> *</span></label>
            <input type="text" id="first-name" name="first_name" required>
        </div>
        <div>
            <label for="last-name">Last Name:<span> *</span></label>
            <input type="text" id="last-name" name="last_name" required>
        </div>
        <div>
            <label for="mobile-number">Mobile Number:<span> *</span></label>
            <input type="tel" id="mobile-number" name="mobile_number" required>
        </div>
        <div>
            <label for="home-address">Home Address:<span> *</span></label>
            <input type="text" id="home-address" name="home_address" required>
        </div>
        <div>
            <label for="email-address">Email Address:</label>
            <input type="email" id="email-address" name="email_address" required readonly>
        </div>
        <select name="type" id="type" style="width: 20rem; height: 3rem;" class="type" required>
            <option value="">Select</option>
            <option value="Adopt">Adopt</option>
            <option value="Donate">Donate</option>
            <option value="Visit">Visit</option>
            <option value="Volunteer">Volunteer</option>
        </select>
        <div class="calendar-container">
            <h2 class="title">CHOOSE APPOINTMENT DATE</h2>
            <h2 class="cl">Schedule Calendar</h2>
            <div id="calendar"></div>
        </div>
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
            <p id="hint" style="color: red;"></p>
        </div>
    </form>
</body>

</html>