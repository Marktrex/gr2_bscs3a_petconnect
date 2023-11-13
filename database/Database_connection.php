<?php

//Database_connection.php

class Database_connection
{
	function connect()
	{
		$conn = new PDO("mysql:host=localhost; dbname=petconnect", "root", "");

		return $conn;
	}
}

?>