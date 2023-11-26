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
    <link rel="stylesheet" href="../css/mission.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>
    <section class="home">
        <div class="contact-wrapper">
            <div class="contact-container">
                <div class="contact-heading">
                    <h2>Mission</h2>
                </div>
                <div class="contact-info">
                    <p>
                        The mission of our pet shelter is to provide a safe, nurturing, and loving environment for
                        animals in need. We are
                        dedicated to rescuing and rehabilitating abandoned, abused, and neglected pets, and finding them
                        forever homes.
                        Our primary focus is on promoting animal welfare, responsible pet ownership, and reducing the
                        number of homeless
                        animals through adoption, education, and community outreach.
                    </p>
                </div>
                <div class="contact-heading">
                    <h2>Vision</h2>
                </div>
                <div class="contact-info">
                    <p>
                        Our vision is to create a world where every animal has a loving and caring home. We strive to be
                        a leading advocate
                        for animal welfare in our community, promoting compassion, empathy, and respect for all living
                        beings. We envision
                        a society where every pet is treated with kindness and provided with the care they deserve,
                        resulting in a decrease in
                        the number of animals suffering from neglect or homelessness.
                    </p>
                </div>
                <div class="contact-heading">
                    <h2>Goals</h2>
                </div>
                <div class="contact-info">
                    <ol>
                        <li>Rescue and Rehabilitation: Our foremost goal is to rescue animals in need, provide them with
                            necessary medical
                            care, and rehabilitate them both physically and emotionally. We aim to give them a second
                            chance
                            at life and
                            prepare them for successful adoptions.</li>
                        <li>Adoption and Placement: We aim to find permanent, loving homes for our rescued animals
                            through responsible
                            adoption processes. Our goal is to match each animal with the most suitable family, ensuring
                            a positive and lasting
                            bond.</li>
                        <li>Education and Outreach: We are committed to educating the community about responsible pet
                            ownership, animal
                            welfare, and the importance of spaying/neutering. Through workshops, seminars, and outreach
                            programs, we strive
                            to raise awareness and promote humane treatment of animals.</li>
                        <li>Advocacy and Legislation: We strive to be a voice for animals in our community and beyond.
                            We actively advocate
                            for stronger animal protection laws, policies, and regulations to ensure the well-being of
                            all animals. We aim to
                            influence positive change at local and national levels.</li>
                        <li>Volunteer and Staff Development: We value our dedicated volunteers and staff members and
                            provide them with
                            ongoing training and support. By fostering a positive work environment and encouraging
                            personal growth, we can
                            enhance our organization's effectiveness and ability to serve animals in need.</li>
                    </ol>
                    <p>
                        These goals collectively contribute to our mission and vision, guiding our efforts to make a
                        meaningful difference in
                        the lives of animals and the community we serve.
                    </p>
                </div>
            </div>

        </div>

    </section>

    <?php include '../function/footer.php' ?>

</body>

</html>