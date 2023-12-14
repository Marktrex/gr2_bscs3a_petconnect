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
    <link rel="stylesheet" href="../css/newlyAdded/layout-light.css">
    <link rel="stylesheet" href="../css/admin/admin-add-adoption.css">

    <link rel="stylesheet" href="..\css\colorStyle\admin\layout-color.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar">
                <a href="admin-dashboard.php" class="logo"
                    ><img src="../icons/logo.png" alt="Insert Logo" id="logIcon"
                /></a>
                <ul class="items">
                    <li>
                    <a class="" id="messages" href="../../privatechat.php"
                        ><i class="fa fa-envelope"></i
                    ></a>
                    </li>
                    <li>
                    <a class="" id="notifications" href="#"
                        ><i class="fa fa-bell"></i
                    ></a>
                    </li>
                    <li>
                    <a href="#"><img src="../icons/icons-user.png" alt="Profile" /></a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <div id="content">
                <form action="" method="POST" id="add_adoption">
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
                </form>
                <button id="submit_button" class="btn-add">Add to adoption</button>
            </div>
            <div id="theTables">
                <div class = "containsTable">
                    <h1>User List</h1>
                    <section>
                        <table id="userTable">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usersData as $user): ?>
                                    <?php
                                        $id = $user->user_id;
                                        $name = $user->fname . " " . $user->lname;
                                        $email = $user->email;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($id);?></td>
                                        <td><?php echo htmlspecialchars($name);?></td>
                                        <td><?php echo htmlspecialchars($email);?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                </div>
                <div class = "containsTable">
                    <h1>Pets List</h1>
                    <section>
                        <table id = "petTable">
                            <thead>
                                <tr>
                                    <th>Pet ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Breed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($petsData as $pet): ?>
                                    <?php
                                        $id = $pet->pets_id;
                                        $name = $pet->name;
                                        $type = $pet->type;
                                        $breed = $pet->breed;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($id);?></td>
                                        <td><?php echo htmlspecialchars($name);?></td>
                                        <td><?php echo htmlspecialchars($type);?></td>
                                        <td><?php echo htmlspecialchars($breed);?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </main>
        
        <?php require_once '..\components\light-switch.php'?>
        <?php require_once "../components/admin/adminSidebar.php"?>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('add_adoption');
        var button = document.getElementById('submit_button');

        button.addEventListener('click', function() {
            form.submit();
        });
        
        document.querySelector('#add_adoption').addEventListener('submit', function(event) {
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
                // location.reload();
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
            document.getElementById('name_user').value = user.fname + " " + user.lname;
            document.getElementById('email_user').value = user.email;
            document.getElementById('mobile_user').value = user.mobile_number;
            document.getElementById('home_user').value = user.home_address;

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
            document.getElementById('name_pet').value = pets.name;
            document.getElementById('breed_pet').value = pets.breed;
            document.getElementById('type_pet').value = pets.type;
            document.getElementById('sex_pet').value = pets.sex;

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

    });
    //adoption form
   
</script>
</html>