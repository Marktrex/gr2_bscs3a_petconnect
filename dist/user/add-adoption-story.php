<?php
session_start();
// print_r($_SESSION);
// Include the database connection
require '../function/config.php';

// Function to get adoption data based on adoption ID
function getAdoptionData($adoptionId, $token) {
    global $conn;

    try {
        // Fetch data for the specific adoption ID and token
        $stmt = $conn->prepare("SELECT adoption_id, user_id, pets_id, story, token FROM adoption WHERE adoption_id = :adoption_id AND token = :token");
        $stmt->bindParam(':adoption_id', $adoptionId, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $adoptionData = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $specificAdoptionData = getAdoptionData($specificAdoptionId, $specificToken);

    if ($specificAdoptionData) {
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
    if (isset($_SESSION['specific_adoption_data']['adoption_id'])) {
        $adoptionId = $_SESSION['specific_adoption_data']['adoption_id'];
        $newStory = $_POST['story'];

        // Update the story
        if (updateAdoptionStory($adoptionId, $newStory)) {
            echo 'Story updated successfully.';
        } else {
            echo 'Error updating the story.';
        }
    } else {
        echo 'Please log in to update the story.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content... -->
</head>
<body>

<!-- Display the form for user input -->

<form action="#" method="POST">
    <label for="story"><a id="label-about">Story</a></label>
    <textarea id="story" name="story" required></textarea>
    <button type="submit">Add Story</button>
</form>

</body>
</html>
