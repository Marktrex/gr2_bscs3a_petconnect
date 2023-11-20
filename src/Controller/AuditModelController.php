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

    public function activity_log($responsibleId, $type, $shortDescription)
    {
        $audit = $this->audit;
        $audit->insert(
            [
                "responsible_id" => $responsibleId,
                "type" => $type,
                "short_description" => $shortDescription
            ]
        );
    }

    public function find($number)
    {
        $audit = $this->audit;
        return $audit->with("user")->find($number);
    }
}
?>