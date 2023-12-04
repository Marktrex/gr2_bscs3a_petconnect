<?php

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

if (isset($_SESSION['auth'])) {

    require('../../database/ChatUser.php');

	$user_object = new ChatUser;

	$user_object->setUserId($_SESSION['auth_user']['id']);

	$user_object->setUserLoginStatus('Logout');

	$user_object->setUserToken($_SESSION['auth_user']['token']);
    
	if($user_object->update_user_login_data())
	{
		unset($_SESSION['auth_user']);
        unset($_SESSION['auth']);
		unset($_SESSION['token']);
		unset($_SESSION['email']);

		session_destroy();
    }
    
}

header('Location: ../../loginpage.php');
?>