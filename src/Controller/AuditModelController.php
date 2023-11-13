<?php
namespace MyApp\Controller;

use MyApp\Model\AuditLog;

class AuditModelController{

    public function getAuditLog()
    {
        $audit = new AuditLog();
        return $audit->all();
    }
}
?>