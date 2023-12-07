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
    
    public function query($sql, $params = [], $returnObject = true)
    {
        $stmt = $this->pdo->prepare($sql);
        if (!empty($params)) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }
        if ($returnObject)
        {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function quote($value) {
        return $this->pdo->quote($value);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
?>