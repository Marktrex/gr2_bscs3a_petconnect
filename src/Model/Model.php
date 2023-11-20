<?php

namespace MyApp\Model;

use MyApp\Database\DBConnect;

class Model
{
    protected $table = null;
    private $db;

    public function __construct()
    {
        if (!$this->table)
        {
            $this->table = basename(str_replace('\\', '/', get_class($this)));
        }
        $this->db = new DBConnect();
    }

    public function all()
    {
        $table = $this->table;
        
        $sql = "SELECT * FROM {$table};";
        try {
            return $this->db->query($sql);
        } catch (PDOException $e) {
            // Output detailed error information for debugging
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>