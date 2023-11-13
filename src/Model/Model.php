<?php

namespace MyApp\Model;

use PDO;
use MyApp\Database\DBConnect;

class Model
{
    protected $table = null;

    public function __construct()
    {
        if (!$this->table)
        {
            $this->table = basename(str_replace('\\', '/', get_class($this)));
        }
    }

    public function all()
    {
        $table = $this->table;
        $db = new DBConnect();
        $conn = $db->connection();
        

        $sql = "SELECT * FROM $table;";
        $stmt = $conn->prepare($sql);
        try {
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } else {
                // Handle error if the query fails
                return false;
            }
        } catch (PDOException $e) {
            // Output detailed error information for debugging
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>