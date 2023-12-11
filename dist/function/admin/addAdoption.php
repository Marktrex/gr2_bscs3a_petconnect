<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
session_start();

use MyApp\Controller\PetModelController;
use MyApp\Controller\UserModelController;
use MyApp\Controller\Adoption\AdoptionAdd;

if($_POST['action'] == 'addAdoption'){
    addAdoption();
}

if($_POST['action'] == 'displayUser'){
    displayUser();
}

if($_POST['action'] == 'displayPet'){
    displayPet();
}

function addAdoption(){
    $petId = $_POST['petId'];
    $userId = $_POST['userId'];

    $adoptionAdd = new AdoptionAdd();

    $result = $adoptionAdd->addAdoption($_SESSION['auth_user']['id'],[
        "pets_id" => $petId,
        "user_id" => $userId,
    ]);

    echo $result; // Output the result

}

function displayUser(){
    $userId = $_POST['userId'];

    $user = new UserModelController();
    $result = $user->get_user_data_by_id($userId);
    echo json_encode($result); // Output the result
}

function displayPet(){
    $petId = $_POST['petId'];

    $pet = new PetModelController();
    $result = $pet->get_pet_data_by_id($petId);

    echo json_encode($result); // Output the result
}

?>