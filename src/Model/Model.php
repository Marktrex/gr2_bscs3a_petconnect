<?php

namespace MyApp\Model;

use MyApp\Database\DBConnect;

class Model
{
    protected $table = null;
    private $db;
    private $joins = [];
    protected $id;

    public function __construct()
    {
        if (!$this->table) {
            $this->table = basename(str_replace('\\', '/', get_class($this)));
        }
        if(!$this->id)
        {
            $this->id = $this->getIdColumn();
        }
        $this->db = new DBConnect();
    }

    public function find($id)
    {
        $table = $this->table;
        $colId= $this->id;
        $joins = implode(' ', $this->joins);

        $sql = "SELECT * FROM {$table} {$joins} WHERE {$colId} = :id;";
        try {
            $result = $this->db->query($sql, [':id' => $id]);
            if ($result) {
                return $result[0]; // Return the first object in the array
            }
            return null; // Return null if the query didn't return any results
        } catch (PDOException $e) {
            // Output detailed error information for debugging
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function insert($data)
    {
        $table = $this->table;

        $keys = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$placeholders});";
        try {
            $this->db->query($sql, $data);
            return;
        } catch (PDOException $e) {
            // Output detailed error information for debugging
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update($id, $data)
    {
        $table = $this->table;
        $colId= $this->id;

        $sql = "UPDATE {$table} SET ";
        foreach ($data as $key => $value) {
            $sql .= "{$key} = '{$value}', ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= " WHERE $colId = {$id};";

        try {
            return $this->db->query($sql);
        } catch (PDOException $e) {
            // Output detailed error information for debugging
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function with($table2, $id1 = null, $id2 = null)
    {
        $table1 = $this->table;
        if (!$id1) {
            $id1 = $table2 . '_id';
            $method = 'hasMany' . ucfirst(strtolower($table2));
            if (method_exists($this, $method)) {
                $id1 = $this->$method();
            }
        }
        if (!$id2) {
            $id2 = $table2 . '_id';
        }
        $joinStatement = "LEFT JOIN {$table2} ON {$table1}.{$id1} = {$table2}.{$id2}";
        if (!in_array($joinStatement, $this->joins)) {
            $this->joins[] = $joinStatement;
        }
        return $this;
    }

    public function all()
    {
        $table = $this->table;
        $joins = implode(' ', $this->joins);

        $sql = "SELECT * FROM {$table} {$joins};";

        try {
            return $this->db->query($sql);
        } catch (PDOException $e) {
            // Output detailed error information for debugging
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function getIdColumn()
    {
        return $this->table . '_id';
    }

    public function search($searchWordsArray, $columnsArray, $isAscending = true, $page = 1, $itemsPerPage = 10) {
        $searchSqlArray = [];
    
        foreach ($searchWordsArray as $index => $searchWords) {
            $searchWords = $this->db->quote('%' . $searchWords . '%');
    
            $searchConditions = [];
            foreach ($columnsArray[$index] as $column) {
                $searchConditions[] = "{$column} LIKE {$searchWords}";
            }
    
            $searchSqlArray[] = '(' . implode(' OR ', $searchConditions) . ')';
        }
    
        $searchSql = implode(' AND ', $searchSqlArray);
    
        $joins = implode(' ', $this->joins);
        $table = $this->table;
        $id = $this->id;
        $order = $isAscending ? 'ASC' : 'DESC';
        $offset = ($page - 1) * $itemsPerPage;
        $sql = "SELECT * FROM {$table} {$joins} WHERE {$searchSql} ORDER BY {$id} {$order} LIMIT {$offset}, {$itemsPerPage};";
    
        try {
            return $this->db->query($sql);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete ($id){
        $table = $this->table;
        $colId= $this->id;
        $sql = "DELETE FROM {$table} WHERE {$colId} = :id;";
        try {
            $this->db->query($sql, [':id' => $id]);
            return;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>