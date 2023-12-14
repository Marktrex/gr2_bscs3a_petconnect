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

    <link rel="stylesheet" href="..\css\admin\admin-manage-adoption.css">
    <link rel="stylesheet" href="..\css\newlyAdded\layout-light.css">

    <link rel="stylesheet" href="..\css\colorStyle\admin\layout-color.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar">
                <a href="admin-dashboard.php" class="logo"
                    ><img src="../icons/logo.png" alt="Insert Logo" id="logIcon"
                /></a>
                
            </nav>
        </header>

        <main>
            <div id="content">
                <div>
                    <h1>User Profile</h1>
                    <div>
                        <div>
                            <img src="../upload/userImages/default.jpg" alt="" id="image_user">
                            <div>
                                <label for="userId">ID: </label>
                                <input type="text" name="userId" id="userId" required readonly>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="name_user">Name: </label>
                                <input type="text" id = "name_user" readonly >
                            </div>
                            <div>
                                <label for="email_user">Email: </label>
                                <input type="text" id = "email_user" readonly>
                            </div>
                            <div>
                                <label for="mobile_user">Mobile: </label>
                                <input type="text" id = "mobile_user" readonly>
                        
                            </div>
                            <div>
                                <label for="home_user">Address: </label>
                                <input type="text" id = "home_user" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h1>Pet Profile</h1>
                    <div>
                        <div>
                            <img src="../upload/petImages/default.jpg" alt="" id="image_pet">
                            <div>
                                <label for="petId">ID: </label>
                                <input type="text" name="petId" id="petId" required readonly>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="name_pet">Name: </label>
                                <input type ="text" id = "name_pet" readonly>
                            </div>
                            <div>
                                <label for="type_pet">Type: </label>
                                <input type="text" id = "type_pet" readonly>
                        
                            </div>
                            <div>
                                <label for="breed_pet">Breed: </label>
                                <input type="text" id = "breed_pet" readonly>
                            </div>
                            <div>
                                <label for="sex_pet">Sex: </label>
                                <input type="text" id = "sex_pet" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h1>Story:</h1>
                    <p id="text_story">

                    </p>
                </div>
            </div>
            <div id = "containsTable">
                <h1>Adoption Table</h1>
                <section>
                    <table id="adoptionTable">
                        <thead>
                            <tr>
                                <th>Adoption ID</th>
                                <th>Name of User</th>
                                <th>Name of Pet</th>
                                <th>Story</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <td class = "actionButtons">
                                        <button class = "sendEmail" type="button"
                                        data-user-id = "<?php echo $id_user?>"
                                        data-adoption-id = "<?php echo $id?>">Send Email</button>
                                        <button type="button" class = "deleteData"
                                        data-adoption-id = "<?php echo $id?>"
                                        >Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
        <?php require_once '..\components\light-switch.php'?>
        <?php require_once "../components/admin/adminSidebar.php"?>
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
            fetch('../function/admin/manageAdoption.php', {
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
            fetch('../function/admin/manageAdoption.php', {
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
        fetch('../function/admin/manageAdoption.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            const adoption = JSON.parse(data);
            // update user profile
            const user_name = adoption.fname + " " + adoption.lname;
            const user_image = adoption.photo;
            updateUserProfile(adoption,user_name, user_image);
            //update pet profile
            const pet_name = adoption.name;
            const pet_image = adoption.image;
            updatePetProfile(adoption,pet_name, pet_image);
            //update story
            const story = adoption.story;
            const tagStory = document.querySelector("#text_story");
            tagStory.textContent = story;
        })
        .catch(error => {
            console.error(error);
        })
    });

    function updateUserProfile(data,name, image){
        document.getElementById('userId').value = data.user_id;
        document.getElementById('name_user').value = name;
        document.getElementById('email_user').value = data.email;
        document.getElementById('mobile_user').value = data.mobile_number;
        document.getElementById('home_user').value = data.home_address;


        const defaultImage = '../upload/userImages/default.jpg';
        const change = '../upload/userImages/' + image;
        const tagImage = document.querySelector("#image_user");
        changePicture(defaultImage, change, tagImage);
    }

    
    function updatePetProfile(data,name, image){
        document.getElementById('petId').value = data.pets_id;
        document.getElementById('name_pet').value = name;
        document.getElementById('breed_pet').value = data.breed;
        document.getElementById('type_pet').value = data.type;
        document.getElementById('sex_pet').value = data.sex;

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