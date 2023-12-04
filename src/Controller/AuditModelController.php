<?php
namespace MyApp\Controller;

use MyApp\Model\AuditLog;

class AuditModelController{
    private $audit;

    public function __construct()
    {
        $this->audit = new AuditLog();
    }

    public function getAuditLog()
    {
        $audit = $this->audit;
        return $audit->with("user")->all();
    }

    public function activity_log($responsibleId, $type, $table_affected, $column_affected, $id_affected, $old_value, $new_value)
    {
        $audit = $this->audit;
        $audit->insert(
            [
                "responsible_id" => $responsibleId,
                "type" => $type,
                "table_affected" => $table_affected,
                "column_affected" => $column_affected,
                "id_affected" => $id_affected,
                "old value" => $old_value,
                "new value" => $new_value,
            ]
        );
    }

    public function find($number)
    {
        $audit = $this->audit;
        return $audit->with("user")->find($number);
    }

    public function search($value, $columns)
    {
        $audit = $this->audit;
        return $audit->with("user")->search($value, $columns);
    }
}
?>