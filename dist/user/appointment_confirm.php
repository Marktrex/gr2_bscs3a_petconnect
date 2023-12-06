<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/logo.png" type="image/png">
    <title>Appointment Confirmation</title>

</head>
<body>
    <input type="text" name="fname" id="fname" required readonly>
    <input type="text" name="lname" id="lname"  required readonly>
    <input type="text" name="mobile" id="mobile" required readonly>
    <input type="text" name="address" id="address" required readonly>
    <input type="text" name="email" id="email" required readonly>
    <select name="type" id="type" style="width: 20rem; height: 3rem;" class="type" required  readonly>
        <option value="">Select</option>
        <option value="Adopt">Adopt</option>
        <option value="Donate">Donate</option>
        <option value="Visit">Visit</option>
        <option value="Volunteer">Volunteer</option>
    </select>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" name="date" id="date-input" required readonly>
    </div>
    <div class="form-group">
        <select id="time-slot" name="time-slot" class="form-control" required readonly>
            <option value="">Select Session</option>
            <option value="Morning Session">Morning Session (9:00 AM - 11:30 AM)</option>
            <option value="Afternoon Session">Afternoon Session (1:00 PM - 4:30 PM)</option>
        </select>
    </div>
</body>
</html>