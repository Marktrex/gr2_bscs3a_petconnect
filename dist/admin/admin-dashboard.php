<?php
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


</head>

<body>
    <div class="container">
        <header class="">
            <nav class="navbar">
                <a href="admin-dashboard.php" class="logo"
                    ><img src="../icons/logo.png" alt="Insert Logo"
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
            <div class="cards">
                <!--Calendar-->
                <div class="card-date">
                    <div class="box">
                    <div class="calendar-container"></div>
                    </div>
                </div>
                <!--Appointments-->
                <div class="card">
                <i class="fa fa-calendar fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        100
                    </div>
                    <h1>APPOINTMENTS</h1>
                </div>
                </div>
                <!--Adopt-->
                <div class="card">
                <i class="fa fa-paw fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        99
                    </div>
                    <h1>ADOPT</h1>
                </div>
                </div>
            <!--Volunteer-->
                <div class="card">
                <i class="fa fa-users fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        10
                    </div>
                    <h1>VOLUNTEER</h1>
                </div>
                </div>
            <!--donate-->
                <div class="card">
                <i class="fa fa-money fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        5
                    </div>
                    <h1>Donate</h1>
                </div>
                </div>
            <!--Visit-->
                <div class="card">
                <i class="fa fa-eye fa-5x"></i>
                <div class="box">
                    <div class="card-number">
                        8
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
                            <th>Mobile #</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Data1</td>
                            <td>Data2</td>
                            <td>Data3</td>
                            <td>Data4</td>
                            <td>Data5</td>
                            <td>
                            <span class="action-btn">
                                <a href="#">Accept</a>
                                <a href="#" class="delete-link">Delete</a>
                            </span>
                            </td>
                        </tr>
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
                                        echo '<span class = "action-btn">';
                                        echo '<button class="" data-appointment-id="' . $appointmentId . '">Accept</button>';
                                        echo '<button class="delete-link" data-appointment-id="' . $appointmentId . '">Cancel</button>';
                                        echo '</span>';
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
            <!-- afternoon -->
            <div class="table_responsive">
                <h2>Afternoon Session</h2>

                <table class="tables">


                    <thead>
                        <tr>
                        <th data-translate="Type">Type</th>
                        <th data-translate="Name">Name</th>
                        <th data-translate="Mobile #">Mobile #</th>
                        <th data-translate="Address">Address</th>
                        <th data-translate="Email">Email</th>
                        <th data-translate="Status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Data1</td>
                        <td>Data2</td>
                        <td>Data3</td>
                        <td>Data4</td>
                        <td>Data5</td>
                        <td>
                        <span class="action-btn">
                            <a href="#">Accept</a>
                            <a href="#" class="delete-link">Delete</a>
                        </span>
                        </td>
                    </tr>
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
                                        echo '<span class = "action-btn">';
                                        echo '<button class="" data-appointment-id="' . $appointmentId . '">Accept</button>';
                                        echo '<button class="delete-link" data-appointment-id="' . $appointmentId . '">Cancel</button>';
                                        echo '</span>';
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
        </main>
        <!--SideBar-->
        <aside id="sidenav" class="sidebar">
            <ul class="menu-links menu-links-color">
            <span
                id="close-btn"
                href="javascript:void(0)"
                >&times;</span
            >
            <li>
                <a id="db" href="admin-dashboard.php"
                ><i class="fa fa-list-ul"></i>&nbsp;&nbsp;&nbsp;Dashboard</a
                >
            </li>
            <li>
                <a id="db" href="../../privatechat.php"
                ><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Messages</a
                >
            </li>
            <li>
                <a id="add" href="admin-add-pets.php"
                ><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add Pets</a
                >
            </li>
            <li>
                <a id="manage" href="admin-manage-pets.php"
                ><i class="fa fa-paw"></i>&nbsp;&nbsp;&nbsp;Manage Pets</a
                >
            </li>
            <li>
                <a id="users" href="admin-manage-user.php"
                ><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Manage Users</a
                >
            </li>
            <li>
                <a id="add" href="admin-audit-trail.php">
                <i class="fa fa-clock-o"></i>
                &nbsp;&nbsp;&nbsp;Audit Trail</a>
            </li>
            <li>
                <a id="logout" href="javascript:void(0);" onclick="logout()"
                ><i class="fa fa-arrow-circle-right"></i
                >&nbsp;&nbsp;&nbsp;Logout</a
                >
            </li>
            </ul>
            <span
            id="menu-btn"
            style="font-size: 30px; cursor: pointer"
            >&#9776;</span
            >
        </aside>
    </div>
</body>

<script src="../script/admin-general.js"></script>
</html>

<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            // Perform logout action
            window.location.href = "../function/logout.php";
        }
    }
</script>

<!-- calendar script -->
<script>
    // Function to generate a calendar
    function generateCalendar() {
        const calendarContainer = document.querySelector(
        ".calendar-container"
        );
        const currentDate = new Date();
        const currentDay = currentDate.getDate(); // Get the current day of the month

        const firstDayOfMonth = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth(),
        1
        ).getDay();
        const daysInMonth = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth() + 1,
        0
        ).getDate();
        const currentMonth = currentDate.toLocaleString("default", {
        month: "long",
        });
        const currentYear = currentDate.getFullYear();

        let calendarHTML = `<h2>${currentMonth} ${currentYear}</h2>`;

        // Add days of the week with red color for Sundays
        calendarHTML += `<div class="days-of-week">
                            <span class="day red">Sun</span>
                            <span class="day">Mon</span>
                            <span class="day">Tue</span>
                            <span class="day">Wed</span>
                            <span class="day">Thu</span>
                            <span class="day">Fri</span>
                            <span class="day">Sat</span>
                        </div>`;

        calendarHTML += "<table>";

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < firstDayOfMonth; i++) {
        calendarHTML += "<td></td>";
        }

        let dayCounter = 1;
        for (let day = 1; day <= daysInMonth; day++) {
        if (
            new Date(currentYear, currentDate.getMonth(), day).getDay() === 0
        ) {
            calendarHTML += "</tr><tr>";
        }

        if (day === currentDay) {
            calendarHTML += `<td class="today">${day}</td>`;
        } else {
            // Add the "red" class for Sundays
            calendarHTML += `<td class="${
            new Date(currentYear, currentDate.getMonth(), day).getDay() ===
            0
                ? "red"
                : ""
            }">${day}</td>`;
        }

        dayCounter++;
        }

        // Add empty cells for remaining days in the last week
        for (let i = dayCounter; i <= 7; i++) {
        calendarHTML += "<td></td>";
        }

        calendarHTML += "</tr></table>";
        calendarContainer.innerHTML = calendarHTML;
    }

    // Call the function to generate the calendar
    document.addEventListener("DOMContentLoaded", function () {
        generateCalendar();
    });
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