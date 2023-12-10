<?php

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

if (!$_SESSION['auth'] || $_SESSION['auth_user']['role'] !== "1" )
{
    header("location: ../error/403-forbidden.html");
    exit();
}

use MyApp\Controller\Adoption\AdoptionManage;

$adoptionController = new AdoptionManage();

$adoptionData = $adoptionController->getAllAdoption();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Adoption</title>
</head>
<body>
    <div id="content">
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
        <div>
            Story here
        </div>
    </div>
    <div>
        <table id="adoptionTable">
            <tr>
                <th>User ID</th>
                <th>Name of User</th>
                <th>Name of Pet</th>
                <th>Story</th>
                <th>Action</th>
            </tr>
            <?php foreach ($adoptionData as $adoption): ?>
                <?php
                    $id = $adoption->adoption_id;
                    $id_user = $adoption->user_id;
                    $name_user = $adoption->fname . " " . $adoption->lname;
                    $name_pet = $adoption->name;
                    $story = $adoption->story;
                    if (strlen($story) == 0) {
                        $story = "Nothing";
                    }
                    if (strlen($story) > 20) {
                        $story = substr($story, 0, 20) . '...';
                    }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($id);?></td>
                    <td><?php echo htmlspecialchars($name_user);?></td>
                    <td><?php echo htmlspecialchars($name_pet);?></td>
                    <td><?php echo htmlspecialchars($story);?></td>
                    <td>
                        <button class = "sendEmail" type="button" 
                        data-user-id = "<?php echo $id_user?>" 
                        data-adoption-id = "<?php echo $id?>">Send Email</button>
                        <button type="button" class = "deleteData"
                        data-adoption-id = "<?php echo $id?>"
                        >Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
<script>
    //send email ajax
    document.querySelectorAll('.sendEmail').forEach(button => {
        button.addEventListener('click', function(event) {
            let target = event.target;
            let userId = target.dataset.userId;
            let adoptionId = target.dataset.adoptionId;
            const formData = new FormData();
            formData.append('action', 'sendEmail');
            formData.append('userId', userId);
            formData.append('adoptionId', adoptionId);
            fetch('../function/manageAdoption.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
            })
            .catch(error => {
                console.error(error);
            })
        })
    });

    //delete data ajax
    document.querySelectorAll('.deleteData').forEach(button => {
        button.addEventListener('click', function(event) {
            let target = event.target;
            let adoptionId = target.dataset.adoptionId;
            const formData = new FormData();
            formData.append('action', 'deleteData');
            formData.append('adoptionId', adoptionId);
            fetch('../function/manageAdoption.php', {
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
        fetch('../function/addAdoption.php', {
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
        fetch('../function/addAdoption.php', {
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