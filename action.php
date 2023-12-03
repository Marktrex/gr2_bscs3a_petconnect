<?php

//action.php

session_start();

if(isset($_POST['action']) && $_POST['action'] == 'leave')
{
	require('database/ChatUser.php');

	$user_object = new ChatUser;

	$user_object->setUserId($_POST['user_id']);

	$user_object->setUserLoginStatus('Logout');

	$user_object->setUserToken($_SESSION['auth_user']['token']);

	if($user_object->update_user_login_data())
	{
		unset($_SESSION['auth_user']);

		session_destroy();

		echo json_encode(['status'=>1]);
	}
}

if(isset($_POST["action"]) && $_POST["action"] == 'fetch_chat')
{
	require 'database/PrivateChat.php';

	

	try {
		$private_chat_object = new PrivateChat;
		$private_chat_object->setFromUserId($_POST["to_user_id"]);
		$private_chat_object->setToUserId($_POST["from_user_id"]);
		$private_chat_object->change_chat_status();
		echo json_encode($private_chat_object->get_all_chat_data());
	} catch (Exception $e) {
		// Handle the exception
		echo json_encode(['error' => $e->getMessage()]);
	}
}

if(isset($_POST["action"]) && $_POST["action"] == 'join_call')
{
	$_SESSION['channel'] = $_POST['channel'];
	echo json_encode($_SESSION['channel']);
}
?>