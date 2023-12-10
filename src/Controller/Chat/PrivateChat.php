<?php

namespace MyApp\Controller\Chat;

class PrivateChat
{
	private $chat_message_id;
	private $to_user_id;
	private $from_user_id;
	private $chat_message;
	private $timestamp;
	private $status;
	protected $connect;
	// for call
	private $message_type;
	private $channel;

	public function __construct()
	{
		require_once('Database_connection.php');

		$db = new Database_connection();

		$this->connect = $db->connect();
	}

	function setChatMessageId($chat_message_id)
	{
		$this->chat_message_id = $chat_message_id;
	}

	function getChatMessageId()
	{
		return $this->chat_message_id;
	}

	function setToUserId($to_user_id)
	{
		$this->to_user_id = $to_user_id;
	}

	function getToUserId()
	{
		return $this->to_user_id;
	}

	function setFromUserId($from_user_id)
	{
		$this->from_user_id = $from_user_id;
	}

	function getFromUserId()
	{
		return $this->from_user_id;
	}

	function setChatMessage($chat_message)
	{
		$this->chat_message = $chat_message;
	}

	function getChatMessage()
	{
		return $this->chat_message;
	}

	function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	function getTimestamp()
	{
		return $this->timestamp;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function setMessageType($message_type)
	{
		$this->message_type = $message_type;
	}

	function getMessageType()
	{
		return $this->message_type;
	}

	function setChannel($channel)
	{
		$this->channel = $channel;
	}

	function getChannel()
	{
		return $this->channel;
	}

	function get_all_chat_data()
	{
		$query = "

		SELECT 
			CONCAT(a.fname, ' ', a.lname) as from_user_name,
			CONCAT(b.fname, ' ', b.lname) as to_user_name, 
			chat_message, 
			timestamp, 
			status, 
			to_user_id, 
			from_user_id, 
			message_type, 
			c.channel
		FROM chat_message 
		INNER JOIN user a 
			ON chat_message.from_user_id = a.user_id 
		INNER JOIN user b 
			ON chat_message.to_user_id = b.user_id 
		LEFT JOIN call_table c
			ON chat_message.call_id = c.call_id
		WHERE (chat_message.from_user_id = :from_user_id AND chat_message.to_user_id = :to_user_id) 
		OR (chat_message.from_user_id = :to_user_id AND chat_message.to_user_id = :from_user_id)
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':from_user_id', $this->from_user_id);

		$statement->bindParam(':to_user_id', $this->to_user_id);

		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	function save_chat()
	{
		$lastId = null;
		if ($this->message_type == 'call'){
			$sql = "INSERT INTO call_table (channel) VALUES (:channel)";
			$statement = $this->connect->prepare($sql);
			$statement->bindParam(':channel', $this->channel);
			$statement->execute();
			$lastId = $this->connect->lastInsertId();
		}
		

		$query = "
		INSERT INTO chat_message 
			(to_user_id, from_user_id, chat_message, timestamp, status, message_type, call_id) 
			VALUES (:to_user_id, :from_user_id, :chat_message, :timestamp, :status, :message_type, :call_id)
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':to_user_id', $this->to_user_id);

		$statement->bindParam(':from_user_id', $this->from_user_id);

		$statement->bindParam(':chat_message', $this->chat_message);

		$statement->bindParam(':timestamp', $this->timestamp);

		$statement->bindParam(':status', $this->status);

		$statement->bindParam(':message_type', $this->message_type);

		$statement->bindParam(':call_id', $lastId);

		$statement->execute();

		return $this->connect->lastInsertId();
	}

	function update_chat_status()
	{
		$query = "
		UPDATE chat_message 
			SET status = :status 
			WHERE chat_message_id = :chat_message_id
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':status', $this->status);

		$statement->bindParam(':chat_message_id', $this->chat_message_id);

		$statement->execute();
	}

	function change_chat_status()
	{
		$query = "
		UPDATE chat_message 
			SET status = 'Yes' 
			WHERE from_user_id = :from_user_id 
			AND to_user_id = :to_user_id 
			AND status = 'No'
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':from_user_id', $this->from_user_id);

		$statement->bindParam(':to_user_id', $this->to_user_id);

		$statement->execute();
	}

}



?>