<?php
session_start();
print_r($_SESSION);
// Include the database connection
require '../function/config.php';

// Function to get adoption data based on adoption ID
function getAdoptionData($adoptionId) {
    global $conn;

    try {
        // Fetch data for the specific adoption ID
        $stmt = $conn->prepare("SELECT adoption_id, user_id, pets_id, story, token FROM adoption WHERE adoption_id = :adoption_id");
        $stmt->bindParam(':adoption_id', $adoptionId, PDO::PARAM_INT);
        $stmt->execute();
        $adoptionData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $adoptionData;
    } catch (PDOException $e) {
        return null; // Handle the error as needed
    }
}

// Handle form submission
if (isset($_GET['adoptionId'])) {
    $specificAdoptionId = $_GET['adoptionId'];
    $specificAdoptionData = getAdoptionData($specificAdoptionId);

    if ($specificAdoptionData) {
        // Store the data in the session
        $_SESSION['specific_adoption_data'] = $specificAdoptionData;
    } else {
        echo 'No data found for the specified Adoption ID.';
    }
}

// Display the specific adoption data from the session
if (isset($_SESSION['specific_adoption_data'])) {
    $specificAdoptionData = $_SESSION['specific_adoption_data'];

    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Adoption ID</th>';
    echo '<th>User ID</th>';
    echo '<th>Pets ID</th>';
    echo '<th>Story</th>';
    echo '<th>Token</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    echo '<tr>';
    echo '<td>' . $specificAdoptionData['adoption_id'] . '</td>';
    echo '<td>' . $specificAdoptionData['user_id'] . '</td>';
    echo '<td>' . $specificAdoptionData['pets_id'] . '</td>';
    echo '<td>' . $specificAdoptionData['story'] . '</td>';
    echo '<td>' . $specificAdoptionData['token'] . '</td>';
    echo '</tr>';

    echo '</tbody>';
    echo '</table>';
} else {
    echo 'Please enter an Adoption ID.';
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
<form method="get" action="add-adoption-story.php">
    <label for="adoptionId">Enter Adoption ID:</label>
    <input type="text" id="adoptionId" name="adoptionId" required>
    <button type="submit">View Adoption Details</button>
</form>

<form action="#" method="POST">
    <label for="story"><a id="label-about">Story</a></label>
    <textarea id="story" name="story" required></textarea>
    <button type="submit">Add Story</button>
</form>

</body>
</html>
