<?php

use MyApp\Controller\Adoption\AdoptionUser;
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

if (!isset($_SESSION['auth_user'])) {
    header('location: ..\authentication\loginpage.php');
    exit();
}

if ($_SESSION['auth_user']['role'] == 1) {
    header('location: ..\admin\admin-dashboard.php');
    exit();
}

$adoptionController = new AdoptionUser();

$stories = $adoptionController->getAllAdoption();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Story</title>
    <link rel="stylesheet" href="..\css\user\adoption-story.css">
    <link rel="stylesheet" href="..\css\colorStyle\user\adoption-story-color.css">
</head>
<body>
    <?php require_once "../components/user/fixedNavbar.php"?>
    
    <header>
        <h1>
            Adoption Story
        </h1>
        <h3>
            Find out the latest stories from our users
        </h3>
    </header>
    <main>
        <?php
        foreach ($stories as $story) {
            $image = $story->image;
            if($image == null) {
                $image = "default.jpg";
            }
            echo '<div>';
            echo '  <div>';
            echo '    <h1> Story by' . htmlspecialchars($story->fname, ENT_QUOTES, 'UTF-8') . '</h1>'; // Replace 'title' with the actual property name
            echo '    <p>' . htmlspecialchars($story->story, ENT_QUOTES, 'UTF-8') . '</p>'; // Replace 'content' with the actual property name
            echo '  </div>';
            echo '  <img src="../upload/petImages/' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . '" alt="">'; // Replace 'image' with the actual property name
            echo '</div>';
        }
        ?>
        <div>
            <div>
                <h1>
                    No more stories
                </h1>
                <p>Wow such emptiness</p>
            </div>
            <img src="../image/pet-stories/empty.png" alt="">
        </div>
    </main>
    <?php require_once "../components/user/footer.html"?>
    <?php require_once "..\components\light-switch.php"?>
</body>
</html>