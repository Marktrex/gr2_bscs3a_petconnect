<?php

namespace MyApp\Controller;

use MyApp\Database\DBConnect;

class Audit
{
    private $short_description;
    private $responsible_id;
    private $type;

    private $db;

    public function __construct($responsible_id, $type, $short_description) {
        $this->responsible_id = $responsible_id;
        $this->type = $type;
        $this->short_description = $short_description;
        $this->db = new DBConnect();
    }


    protected function checkNullResponsible()
    {
        if(!$this->responsible_id)
        {
            try {
                $sql = "SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1;";
                
                $latestUserId = $this->db->query($sql);

                $this->responsible_id = $latestUserId;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function activity_log()
    {
        if(!$this->responsible_id)
        {
            $this->checkNullResponsible();
        }
        try {
            
    
            // Your SQL query with the table name concatenated
            $sql = "INSERT INTO audit_log (responsible_id, type, short_description) VALUES (:responsible_id, :type, :short_description)";
    
            $this->db->query($sql, [
                ':responsible_id' => $this->responsible_id,
                ':type' => $this->type,
                ':short_description' => $this->short_description
            ]);
    
    
            echo "Record inserted successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    
        // Close the connection
        $conn = null;
    }
    
    
}
?>