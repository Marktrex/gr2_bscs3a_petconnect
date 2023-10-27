<?php

session_start();
include('./function/config.php');

// Retrieve the selected dropdown values
$type = $_GET['type'] ?? '';
$sex = $_GET['sex'] ?? '';
$weight = $_GET['weight'] ?? '';
$age = $_GET['age'] ?? '';

// Build the SQL query with the selected criteria
$sql = "SELECT * FROM pets WHERE 1=1";

if (!empty($sql)) {
    $sql .= " AND type = '$type'";
}
if (!empty($sex)) {
    $sql .= " AND sex = '$sex'";
}
if (!empty($weight)) {
    $sql .= " AND weight = '$weight'";
}
if (!empty($age)) {
    $sql .= " AND age = '$age'";
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if (!empty($type)) {
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
}

if (!empty($sex)) {
    $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
}

if (!empty($weight)) {
    $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
}

if (!empty($age)) {
    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
}

// Execute the prepared statement
$stmt->execute();

// Fetch the results
$pet_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the PDO connection
$pdo = null;
?>