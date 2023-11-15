<?php
session_start(); // Add this line to start the session
require '../function/config.php';
//this checks the session if the admin is logged in
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
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
    <link rel="stylesheet" href="../css/team.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>
    <section class="home">
        <div class="team-page">
            <h1 class="team-title">OUR TEAM</h1>
        </div>
        <div class="profile-card-container">
            <div class="profile-card">
                <img src="../image/team/ALFARO.png" alt="Profile Image">
                <div class="details">
                    <p class="name">AIAN LOUISE A. ALFARO</p>
                    <p class="position">Administrative</p>
                    <p class="email">aianlouisealfaro@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="profile-card-container">
            <div class="profile-card">
                <img src="../image/team/GAMBOA.png" alt="Profile Image">
                <div class="details">
                    <p class="name">EDGAR GAMBOA JR.</p>
                    <p class="position">Appointments/Inquiries</p>
                    <p class="email">edgargamboa@gmail.com</p>
                </div>
            </div>
            <div class="profile-card">
                <img src="../image/team/IBAY.png" alt="Profile Image">
                <div class="details">
                    <p class="name">ARMYN JACE IBAY</p>
                    <p class="position">Donations and Volunteers</p>
                    <p class="email">armynjace@gmail.com</p>
                </div>
            </div>
            <div class="profile-card">
                <img src="../image/team/LAXAMANA.png" alt="Profile Image">
                <div class="details">
                    <p class="name">ALFRED LAXAMANA</p>
                    <p class="position">Adoption</p>
                    <p class="email">alfredlaxamana@gmail.com</p>
                </div>
            </div>
            <div class="profile-card">
                <img src="../image/team/LUZANO.png" alt="Profile Image">
                <div class="details">
                    <p class="name">NICOLE LUZANO</p>
                    <p class="position">General Information</p>
                    <p class="email">nicoleluzano@gmail.com</p>
                </div>
            </div>
        </div>
    </section>

    <?php include '../function/footer.php' ?>

</body>

</html>