<?php

namespace MyApp\controller;

require_once "../database/DBConnect.class.php";


class audit
{
    private $short_description;
    private $responsible_id;
    private $type;

    public function __construct($responsible_id, $type, $short_description) {
        $this->responsible_id = $responsible_id;
        $this->type = $type;
        $this->short_description = $short_description;
    }

    public function activity_log()
    {
        checkNullResponsible();
        try {
            // Initialize PDO connection
            $conn = new DBConnect();
    
            // Your SQL query with the table name concatenated
            $sql = "INSERT INTO audit_log (responsible_id, type, short_description) VALUES (:responsible_id, :type, :short_description)";
    
            // Prepare the statement
            $stmt = $conn->prepare($sql);
    
            // Bind parameters
            $stmt->bindParam(':responsible_id', $this->responsible_id);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':short_description', $this->short_description);
    
            // Execute the statement
            $stmt->execute();
    
            echo "Record inserted successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    
        // Close the connection
        $conn = null;
    }

    private function checkNullResponsible()
    {
        if(!$this->responsible_id)
        {
            try {
                $conn = new DBConnect();
                $sql = "SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1;";

                $stmt = $conn->prepare($sql);
                
                $stmt->execute();

                $latestUserId = $stmt->fetchColumn();

                $this->responsible_id = $latestUserId;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            

            $conn = null;
        }
    }
    
}
?>