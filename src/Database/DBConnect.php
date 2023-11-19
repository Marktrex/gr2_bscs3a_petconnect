<?php

namespace MyApp\Database;

use PDO;

class DBConnect
{
    private $dsn = "localhost";
    private $dbname = "petconnect";
    private $username = "root";
    private $password = "";


    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='. $this->dsn .';dbname='.$this->dbname, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>