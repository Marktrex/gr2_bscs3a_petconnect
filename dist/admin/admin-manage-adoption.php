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
        </div>
        <div>
            <img src="../upload/petImages/default.jpg" alt="" id="image_pet">
            <p id = "name_pet">none</p>
            Display Pet here
        </div>
        <div>
            Story here
            <textarea name="text_story" id="text_story" cols="30" rows="10" readonly ></textarea>
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
                    $id_pet = $adoption->pets_id;
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


    //click table pet
    document.getElementById('adoptionTable').addEventListener('click', function(event) {
        let target = event.target;
        let adoptionId = target.parentNode.cells[0].textContent;
        
        adoptionId = +adoptionId;
        if (isNaN(adoptionId)) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'displayData');
        formData.append('adoptionId', adoptionId);
        fetch('../function/manageAdoption.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            const adoption = JSON.parse(data);
            // update user profile
            const user_name = adoption.fname + " " + adoption.lname;
            const user_image = adoption.photo;
            updateUserProfile(user_name, user_image);
            //update pet profile
            const pet_name = adoption.name;
            const pet_image = adoption.image;
            updatePetProfile(pet_name, pet_image);
            //update story
            const story = adoption.story;
            const tagStory = document.querySelector("#text_story");
            tagStory.value = story;
        })
        .catch(error => {
            console.error(error);
        })
    });

    function updateUserProfile(name, image){
        const tagName = document.querySelector("#name_user");
        tagName.textContent = name;


        const defaultImage = '../upload/userImages/default.jpg';
        const change = '../upload/userImages/' + image;
        const tagImage = document.querySelector("#image_user");
        changePicture(defaultImage, change, tagImage);
    }

    
    function updatePetProfile(name, image){
        const tagName = document.querySelector("#name_pet");
        tagName.textContent = name;

        const defaultImage = '../upload/petImages/default.jpg';
        const change = '../upload/petImages/' + image;
        const tagImage = document.querySelector("#image_pet");
        changePicture(defaultImage, change, tagImage);
    }

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