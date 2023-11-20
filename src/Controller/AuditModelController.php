<?php
namespace MyApp\Controller;

use MyApp\Model\AuditLog;

class AuditModelController{

    public function getAuditLog()
    {
        $audit = new AuditLog();
        return $audit->with("user")->all();
    }

    public function activity_log($responsibleId, $type, $shortDescription)
    {
        $audit = new AuditLog();
        $audit->insert(
            [
                "user_id" => $responsibleId,
                "type" => $type,
                "short_description" => $shortDescription
            ]
        );
    }
}
?>