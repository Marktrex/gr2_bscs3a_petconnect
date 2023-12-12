<?php

use MyApp\Controller\Adoption\AdoptionUser;
session_start();
// Include the database connection
require '../function/config.php';

require_once __DIR__ . '/../../vendor/autoload.php';

// Function to get adoption data based on adoption ID
function getAdoptionData($adoptionId) {
    $adoptionController = new AdoptionUser();
    try {
        $adoptionData = $adoptionController->get_adoption_data($adoptionId);
        return $adoptionData;
    } catch (PDOException $e) {
        return null; // Handle the error as needed
    }
}

// Handle form submission
if (isset($_GET['adoptionId']) && isset($_GET['token'])) {
    $specificAdoptionId = $_GET['adoptionId'];
    $specificToken = $_GET['token'];
    
    // Check if the token matches
    $specificAdoptionData = getAdoptionData($specificAdoptionId);

    if ($specificAdoptionData && $specificAdoptionData->token === $specificToken) {
        // Store the data in the session
        $_SESSION['specific_adoption_data'] = $specificAdoptionData;
    } else {
        // Redirect to the error page
        header('Location: ../error/403-forbidden.html');
        exit();
    }
} else {

    header('Location: ../error/403-forbidden.html');

}

// Function to update the "story" for a specific adoption ID
function updateAdoptionStory($adoptionId, $newStory) {
    global $conn;

    try {
        // Update the "story" for the specific adoption ID
        $stmt = $conn->prepare("UPDATE adoption SET story = :new_story WHERE adoption_id = :adoption_id");
        $stmt->bindParam(':new_story', $newStory, PDO::PARAM_STR);
        $stmt->bindParam(':adoption_id', $adoptionId, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false; // Handle the error as needed
    }
}

// Handle form submission for updating story
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['story'])) {
    // Check if the user is logged in
    if (isset($_SESSION['specific_adoption_data']->adoption_id)) {
        $adoptionId = $_SESSION['specific_adoption_data']->adoption_id;
        $newStory = $_POST['story'];

        // Update the story
        if (updateAdoptionStory($adoptionId, $newStory)) {
            echo "<script>
                alert('The story has been updated.');
                window.location.href='../user/index.php';
            </script>";
        } else {
            echo "<script>
                alert('There was an error updating the story.');
                window.location.href='../user/index.php';
            </script>";
        }
    } else {
        header('Location: ../error/403-forbidden.html');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Adoption Story</title>
    <link rel="stylesheet" href="../css/user/add-adoption-story.css">
</head>
<body>
    <?php require_once "../components/user/userNavbar.php"?>
    <main>
        <h1>ADD STORY</h1>
        <hr>
        <p>
            How was your story with:
        </p>
        <div id = "section">
            <label for="pet">Pet name: </label>
            <input type="text" readonly id="pet" value = "<?php echo $specificAdoptionData->name?>">
        </div>
        <form action="#" method="POST">
            <textarea id="story" name="story" required></textarea>
            <button type="submit">Add Story</button>
        </form>
    </main>

    <?php require_once "../components/user/footer.html"?>    
</body>
</html>
