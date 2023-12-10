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
                <input type="text" name="userId" id="userId" required readonly>
            </div>
            <div>
                Display Pet here
                <input type="text" name="petId" id="petId" required readonly>
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
        document.getElementById('add_adoption').addEventListener('submit', function(event) {
                event.preventDefault();
                var userId = document.getElementById('userId');
                var petId = document.getElementById('petId');

                if (!userId.value || !petId.value) {
                    alert('Please fill out all fields');
                    return;
                }
                const add_adoption = document.querySelector("#add_adoption");
                const formData = new FormData(add_adoption);
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

        document.getElementById('userTable').addEventListener('click', function(event) {
            let target = event.target;
            let userId = target.parentNode.cells[0].textContent;

            userId = +userId;
            if (isNaN(userId)) {
                return;
            }
            document.getElementById('userId').value = userId;
        });

        document.getElementById('petTable').addEventListener('click', function(event) {
            let target = event.target;
            let petsId = target.parentNode.cells[0].textContent;
            
            petsId = +petsId;
            if (isNaN(petsId)) {
                return;
            }
            document.getElementById('petId').value = petsId;
        });
    </script>
</body>
</html>