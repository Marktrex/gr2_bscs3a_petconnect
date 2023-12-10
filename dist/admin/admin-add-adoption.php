<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use MyApp\Controller\PetModelController;
use MyApp\Controller\UserModelController;

$petController = new PetModelController();
$userController = new UserModelController();

$petsData = $petController->getAllPets();
$usersData = $userController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="content">
        <form action="" method="post" id="add_adoption">
            <div>
                Display Profile here
            </div>
            <div>
                Display Pet here
            </div>
            <button type="submit" >Add to adoption</button>
        </form>
    </div>
    <div>
        <table id="userTable">
            <tr>
                <th>User ID</th>
                <th>Name</th>
            </tr>
            <?php foreach ($usersData as $user): ?>
                <?php
                    $id = $user->user_id;
                    $name = $user->fname . " " . $user->lname;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($id);?></td>
                    <td><?php echo htmlspecialchars($name);?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div>
        <table id = "petTable">
            <tr>
                <th>User ID</th>
                <th>Name</th>
            </tr>
            <?php foreach ($petsData as $pet): ?>
                <?php
                    $id = $pet->pets_id;
                    $name = $pet->name;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($id);?></td>
                    <td><?php echo htmlspecialchars($name);?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script>
        const addAdoption = document.querySelector('#add_adoption');
        addAdoption.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(addAdoption);
            formData.append('action', 'addAdoption');
            fetch('../function/addAdoption.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error(error);
            })
        });
    </script>
</body>
</html>