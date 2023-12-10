<?php

namespace MyApp\Controller\Chat;

class Database_connection
{
	function connect()
	{
		$conn = new PDO("mysql:host=localhost; dbname=petconnect", "root", "");

		return $conn;
	}
}

?>