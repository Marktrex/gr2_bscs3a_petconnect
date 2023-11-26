<?php
session_start();
require '../function/config.php';

// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
if (!isset($_SESSION['auth_user'])) { 
  echo '<script language="javascript">';
  echo 'alert("You do not have access to this page");';
  echo '</script>';
  header("Location: ../loginpage.php");
  exit();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../image/icon.png" type="image/png">    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="../css/success-stories.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>

    <section class="home">
        <div class="top">
            <div class="title">
                <h1>FROM STRAYS TO STARS</h1>
                <h2>Heartwarming Stories of Shelter Pets Finding Forever.</h2>
                <h2>Homes with the help of PawCity!</h2>
                <h2>Have a success story of your own? Share it here!</h2>
            </div>
        </div>

        <div class="content">

            <div class="img1">
                <img src="../image/Success Stories\img1.jpg" alt="Lucky Dog">
            </div>

            <div class="story-container">
                <div class="story-details">
                    <h2>"The Lucky Stray"</h2>
                    <p>
                        In a bustling city, there was a stray dog named Lucky. Lucky was always on the streets,
                        searching
                        for food and shelter. One rainy day, he stumbled upon a pet shelter where the staff took him in,
                        providing him with food, a bath, and a comfortable bed. They took care of him until he was back
                        in
                        good condition. Lucky slowly adjusted to his new surroundings, grateful for the kindness shown
                        by
                        the staff.
                    </p>
                </div>
                <div class="story-details2">
                    <h2>Lucky</h2>
                    <p>
                        He started to play with other dogs out there, making a lot of pawfriends! As time passed, he
                        found a
                        loving family who adopted him, offering a forever home. Now, Lucky spends his days playing with
                        his
                        new
                        family, spreading happiness wherever he goes.
                    </p>
                </div>
                <div class="story-details3">
                    <h2>"Rebuilding Trust"</h2>
                    <p>
                        Bella, a once-beloved cat, found herself in a pet shelter after her owner passed away. Confused
                        and
                        heartbroken, Bella became wary of humans. The shelter staff understood her trauma and patiently
                        worked
                        to rebuild her trust. Through gentle interactions, soft-spoken words, and consistent care, Bella
                        began
                        to open up. Slowly, Bella began to trust humans again, purring with delight whenever approached.
                        Then, a
                        kind-hearted woman named Emily visited the shelter and instantly fell in love with Bella's
                        gentle
                        nature. Adopting her, Emily provided Bella with a forever home filled with warmth and affection.
                        Bella
                        now spends her days curled up on Emily's lap, grateful for the second chance at a happy life.
                    </p>
                </div>
            </div>

            <div class="img2">
                <img src="../image/Success Stories\img2.jpg" alt="Lucky Dog">
                <h2>Bella</h2>
            </div>
            <div class="img3">
                <img src="../image/Success Stories\img3.jpg" alt="Lucky Dog">
                <h2>Max</h2>
            </div>

            <div class="story-container">
                <div class="story-details4">
                    <h2>"From Fear to Friendship"</h2>
                    <p>
                        Meet Max, a timid and frightened dog rescued from an abusive situation. Upon arriving at the pet
                        shelter, Max was terrified of everything and everyone around him. The patient shelter staff
                        worked tirelessly to help him overcome his fears, introducing him to friendly dogs and providing
                        a safe space for healing. Over time, Max's trust in humans grew, his tail wagging in delight
                        upon their approach. One day, a loving couple visited the shelter and instantly connected with
                        Max's gentle eyes.
                    </p>
                </div>
                <div class="story-details5">
                    <p>
                        They made the decision to adopt him, promising the love and care he deserved. Today, Max is a
                        happy and confident dog, enjoying long walks and endless belly rubs with his new family.
                    </p>
                </div>
            </div>
        </div>

    </section>

    <?php include '../function/footer.php' ?>
</body>

</html>