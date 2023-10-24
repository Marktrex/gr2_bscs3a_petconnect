<?php

session_start();
include('./function/config.php');

// Retrieve the selected dropdown values
$type = $_GET['type'] ?? '';
$sex = $_GET['sex'] ?? '';
$weight = $_GET['weight'] ?? '';
$age = $_GET['age'] ?? '';

// Build the SQL query with the selected criteria
$query = "SELECT * FROM pets WHERE 1=1";
if (!empty($type)) {
    $query .= " AND type = '$type'";
}
if (!empty($sex)) {
    $query .= " AND sex = '$sex'";
}
if (!empty($weight)) {
    $query .= " AND weight = '$weight'";
}
if (!empty($age)) {
    $query .= " AND age = '$age'";
}

$result = mysqli_query($conn, $query);
$pet_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

?>