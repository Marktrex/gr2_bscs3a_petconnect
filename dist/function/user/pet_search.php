<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use MyApp\Controller\PetModelController;
$petSearch = new PetModelController();

// Retrieve the selected dropdown values
$type = $_GET['type'] ?? 'Cat';
$name = $_GET['name'] ?? '';
$breed = $_GET['breed'] ?? '';
$sex = $_GET['sex'] ?? '';
$weight = $_GET['weight'] ?? '';
$age = $_GET['age'] ?? '';

if($sex == ""){
    $isLike = true;
}
else{
    $isLike = false;
}

// Prepare the search values and columns
$values = [$type, $name,$breed, $sex, $weight, $age];
$columns = [['type'], ['name'],['breed'], ['sex'], ['weight'], ['age']];
$userOperator = [true, true, true, $isLike, true, true];

// Search for pets based on the selected values
$results = $petSearch->search($values, $columns, $userOperator);

// Loop through the results and output the HTML
foreach ($results as $row) {
    echo "<div class=\"img-bg\" onclick=\"window.location.href='adoptprofile.php?id=" . $row->pets_id . "'\">";
    echo "<img src=\"../upload/petImages/" . $row->image . "\" alt=\"\" />";
    echo "<p class=\"img-text\">" . htmlspecialchars($row->name) . "</p>";
    echo "<div class=\"overlay\">";
    echo "<h2>Hello, it's me " . htmlspecialchars($row->name) . "!</h2>";
    echo "<p>" . htmlspecialchars($row->about) . "</p>";
    echo "</div>";
    echo "</div>";
}
?>