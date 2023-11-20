<?php

namespace MyApp\Model;

use MyApp\Model\Model;

class AuditLog extends Model
{
    protected $table = "audit_log";
    protected $id = "audit_log_id";

    protected function hasManyUser()
    {
        return "responsible_id";
    }
}
?>