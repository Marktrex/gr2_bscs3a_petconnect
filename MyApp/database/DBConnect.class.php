<?php
class DBConnect
{
    private $dsn = "localhost";
    private $dbname = "petconnect";
    private $username = "root";
    private $password = "";

    public function connection()
    {
        try {
        $conn = new PDO('mysql:host=' . $this->dsn . '; dbname=' . $this->dbname, $this->username, $this->password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
        } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>