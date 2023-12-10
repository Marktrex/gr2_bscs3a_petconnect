<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use MyApp\Controller\Adoption\AdoptionManage;

session_start();



if($_POST['action'] == 'sendEmail') {
    sendEmail();
}

if($_POST['action'] == 'deleteData') {
    deleteData();
}

function sendEmail() {
    $manageAdoption = new AdoptionManage();
    $userId = $_POST['userId'];
    $adoptionId = $_POST['adoptionId'];

    $result = $manageAdoption->askStory($_SESSION['auth_user']['id'],$adoptionId, $userId);
    
    echo $result;
}

function deleteData(){
    $manageAdoption = new AdoptionManage();
    $adoptionId = $_POST['adoptionId'];

    $result = $manageAdoption->deleteData($_SESSION['auth_user']['id'],$adoptionId);

    echo $result;
}

?>