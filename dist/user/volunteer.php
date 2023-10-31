<?php require '../function/config.php';

session_start(); // Add this line to start the session

$loggedIn = isset($_SESSION['auth_user']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="../css/volunteer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>

    <section class="home">
        <div class="content">
            <img src="..\image\volunteer\img1.jpg" alt="Image 1">
        </div>
        <div class="title">
            <h1>Join a passionate community of animal lovers and contribute to a meaningful cause.</h1>
        </div>
        <div class="content2">
        <a href="<?php echo $loggedIn ? 'book-appointment.php' : '../loginpage.php'; ?>" <?php echo $loggedIn ? 'target="_blank"' : ''; ?>><img src="..\image\volunteer\title1.png" alt="Image 1"></a>
        </div>
        <div class="content3">
            <img src="..\image\volunteer\img2.jpg" alt="Image 1">
            <img src="..\image\volunteer\img3.jpg" alt="Image 1">
        </div>
        <div class="requirement">
            <h1>Volunteer Requirements:</h1>
            <img class="b1" src="..\image\volunteer\bullet.png" alt="Image 1">
            <img class="b2" src="..\image\volunteer\bullet.png" alt="Image 1">
            <img class="b3" src="..\image\volunteer\bullet.png" alt="Image 1">
            <img class="b4" src="..\image\volunteer\bullet.png" alt="Image 1">
            <div class="content">
                <p>Compassion and respect for animals, with a commitment to their well-being.</p>
                <br>
                <p>Availability to commit to a regular schedule or specific event dates.</p>
                <br>
                <p>No age limit</p>
                <br>
                <p>Want to learn and grow</p>
            </div>
        </div>
        <div class="opportunity">
            <h1>Volunteer Opportunities:</h1>
            <img class="b1" src="..\image\volunteer\bullet.png" alt="Image 1">
            <img class="b2" src="..\image\volunteer\bullet.png" alt="Image 1">
            <img class="b3" src="..\image\volunteer\bullet.png" alt="Image 1">
            <div class="content">
                <p>Support adoption events and assist potential adopters in meeting our animals.</p>
                <br>
                <p>Help with socializing, grooming, and exercising the animals in preparation for adoption.</p>
                <br>
                <p>Assist with feeding, cleaning, and providing enrichment activities for the animals.</p>
            </div>
        </div>
        <div class="benefits">
            <h1>Benefits:</h1>
            <img class="b1" src="..\image\volunteer\bullet.png" alt="Image 1">
            <img class="b2" src="..\image\volunteer\bullet.png" alt="Image 1">
            <img class="b3" src="..\image\volunteer\bullet.png" alt="Image 1">
            <div class="content">
                <p>Gain valuable experience working with animals and developing essential skills.</p>
                <br>
                <p>Join a passionate community of animal lovers and contribute to a meaningful cause.</p>
                <br>
                <p>Personal fulfillment and the joy of seeing animals thrive in their new homes.</p>
            </div>
        </div>
        <div class="button">
            <a href="<?php echo $loggedIn ? 'book-appointment.php' : '../loginpage.php'; ?>" <?php echo $loggedIn ? 'target="_blank"' : ''; ?>><img src="..\image\volunteer\title2.png" alt="Image 1"></a>
        </div>

    </section>

    <?php include '../function/footer.php' ?>

</body>

</html>