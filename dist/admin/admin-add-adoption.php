<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "1" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}


use MyApp\Controller\PetModelController;
use MyApp\Controller\UserModelController;

$petController = new PetModelController();
$userController = new UserModelController();

$petsData = $petController->search([0], [['isAdopted']], [true]);
$usersData = $userController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Adoption</title>
</head>
<body>
    <div id="content">
        <form action="" method="post" id="add_adoption">
            <div>
                <img src="../upload/userImages/default.jpg" alt="" id="image_user">
                <p id = "name_user">none</p>
                Display Profile here
                <input type="text" name="userId" id="userId" required readonly>
            </div>
            <div>
                <img src="../upload/petImages/default.jpg" alt="" id="image_pet">
                <p id = "name_pet">none</p>
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
    
</body>
<script>
    //adoption form
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
            fetch('../function/admin/addAdoption.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => {
                console.error(error);
            })
    });

    //click table user
    document.getElementById('userTable').addEventListener('click', function(event) {
        let target = event.target;
        let userId = target.parentNode.cells[0].textContent;

        userId = +userId;
        if (isNaN(userId)) {
            return;
        }
        document.getElementById('userId').value = userId;

        const formData = new FormData();
        formData.append('action', 'displayUser');
        formData.append('userId', userId);
        fetch('../function/admin/addAdoption.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            let user = JSON.parse(data);
            document.getElementById('name_user').textContent = user.fname + " " + user.lname;
            const defaultImage = '../upload/userImages/default.jpg';
            const change = '../upload/userImages/' + user.photo;
            console.log(change);
            const tag = document.querySelector("#image_user");
            changePicture(defaultImage, change, tag);
        })
        .catch(error => {
            console.error(error);
        })
    });

    //click table pet
    document.getElementById('petTable').addEventListener('click', function(event) {
        let target = event.target;
        let petsId = target.parentNode.cells[0].textContent;
        
        petsId = +petsId;
        if (isNaN(petsId)) {
            return;
        }
        document.getElementById('petId').value = petsId;

        const formData = new FormData();
        formData.append('action', 'displayPet');
        formData.append('petId', petsId);
        fetch('../function/admin/addAdoption.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            let pets = JSON.parse(data);
            document.getElementById('name_pet').textContent = pets.name;
            const defaultImage = '../upload/petImages/default.jpg';
            const change = '../upload/petImages/' + pets.image;
            const tag = document.querySelector("#image_pet");
            changePicture(defaultImage, change, tag);
        })
        .catch(error => {
            console.error(error);
        })
    });

    function changePicture(defaultImage, change, tag){
        let last = change.split('/');
        last = last[last.length - 1];
        if(last == 'null'){
            tag.src = defaultImage;
            return;
        }
        tag.src = change;
    }
</script>
</html>