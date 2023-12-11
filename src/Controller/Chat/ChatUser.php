<?php

namespace MyApp\Controller\Chat;
use PDO;
use MyApp\Controller\Chat\Database_connection;

class ChatUser
{
	private $user_id;
	private $user_name;
	private $user_email;
	private $user_password;
	private $user_status;
	private $user_created_on;
	private $user_verification_code;
	private $user_login_status;
	private $user_token;
	private $user_connection_id;
	public $connect;

	public function __construct()
	{

		$db = new Database_connection();

		$this->connect = $db->connect();
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setUserName($user_name)
	{
		$this->user_name = $user_name;
	}

	function getUserName()
	{
		return $this->user_name;
	}

	function setUserEmail($user_email)
	{
		$this->user_email = $user_email;
	}

	function getUserEmail()
	{
		return $this->user_email;
	}

	function setUserPassword($user_password)
	{
		$this->user_password = $user_password;
	}

	function getUserPassword()
	{
		return $this->user_password;
	}

	function setUserStatus($user_status)
	{
		$this->user_status = $user_status;
	}

	function getUserStatus()
	{
		return $this->user_status;
	}

	function setUserCreatedOn($user_created_on)
	{
		$this->user_created_on = $user_created_on;
	}

	function getUserCreatedOn()
	{
		return $this->user_created_on;
	}

	function setUserVerificationCode($user_verification_code)
	{
		$this->user_verification_code = $user_verification_code;
	}

	function getUserVerificationCode()
	{
		return $this->user_verification_code;
	}

	function setUserLoginStatus($user_login_status)
	{
		$this->user_login_status = $user_login_status;
	}

	function getUserLoginStatus()
	{
		return $this->user_login_status;
	}

	function setUserToken($user_token)
	{
		$this->user_token = $user_token;
	}

	function getUserToken()
	{
		return $this->user_token;
	}

	function setUserConnectionId($user_connection_id)
	{
		$this->user_connection_id = $user_connection_id;
	}

	function getUserConnectionId()
	{
		return $this->user_connection_id;
	}

	function get_user_data_by_email()
	{
		$query = "
		SELECT * FROM user 
		WHERE email = :user_email
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_email', $this->user_email);

		if($statement->execute())
		{
			$user_data = $statement->fetch(PDO::FETCH_ASSOC);
		}
		return $user_data;
	}

	function is_valid_email_verification_code()
	{
		// error here
		$query = "
		SELECT * FROM user 
		WHERE user_verification_code = :user_verification_code
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_verification_code', $this->user_verification_code);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function enable_user_account()
	{
		$query = "
		UPDATE user 
		SET user_status = :user_status 
		WHERE user_verification_code = :user_verification_code
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_status', $this->user_status);

		$statement->bindParam(':user_verification_code', $this->user_verification_code);

		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function update_user_login_data()
	{
		$query = "
		UPDATE user 
		SET user_login_status = :user_login_status, user_token = :user_token  
		WHERE user_id = :user_id
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_login_status', $this->user_login_status);

		$statement->bindParam(':user_token', $this->user_token);

		$statement->bindParam(':user_id', $this->user_id);

		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_user_data_by_id()
	{
		$query = "
		SELECT * FROM user 
		WHERE user_id = :user_id";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_id', $this->user_id);

		try
		{
			if($statement->execute())
			{
				$user_data = $statement->fetch(PDO::FETCH_ASSOC);
			}
			else
			{
				$user_data = array();
			}
		}
		catch (Exception $error)
		{
			echo $error->getMessage();
		}
		return $user_data;
	}

	function get_user_all_data()
	{
		$query = "
		SELECT * FROM user 
		";

		$statement = $this->connect->prepare($query);

		$statement->execute();

		$data = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}

	function get_user_all_data_with_status_count()
	{
		if (isset($_SESSION['auth_user']['role'])) {
			$user_type = $_SESSION['auth_user']['role'];
	
			if ($user_type === '1') {
				// User is an admin, execute the admin query
				$query = "
					SELECT user_id, lname, fname, user_login_status, 
						(SELECT COUNT(*) FROM chat_message 
						 WHERE to_user_id = :user_id AND from_user_id = user.user_id AND status = 'No') AS count_status 
					FROM user
					WHERE user_type = 2

				";
			} elseif ($user_type === '2') {
			//User is a regular user, execute the user query
				$query = "
					SELECT user_id, lname, fname, user_login_status, 
						(SELECT COUNT(*) FROM chat_message 
						 WHERE to_user_id = :user_id AND from_user_id = user.user_id AND status = 'No') AS count_status 
					FROM user
					WHERE user_type = '1'
				";
				
			} else {
				// Handle other user types or return an empty array
				return [];
			}
	
			$statement = $this->connect->prepare($query);
	
			$statement->bindParam(':user_id', $this->user_id);
	
			$statement->execute();
	
			$data = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			return $data;
		} else {
			// User type not set in the session, handle accordingly
			return [];
		}
	}

	function update_user_connection_id()
	{
		$query = "
		UPDATE user 
		SET user_connection_id = :user_connection_id 
		WHERE user_token = :user_token
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_connection_id', $this->user_connection_id);

		$statement->bindParam(':user_token', $this->user_token);

		$statement->execute();
	}

	function get_user_id_from_token()
	{
		$query = "
		SELECT user_id FROM user 
		WHERE user_token = :user_token
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_token', $this->user_token);

		$statement->execute();

		$user_id = $statement->fetch(PDO::FETCH_ASSOC);

		return $user_id;
	}

}



?>