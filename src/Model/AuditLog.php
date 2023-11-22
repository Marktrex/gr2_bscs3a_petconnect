<?php

namespace MyApp\Model;

use MyApp\Model\Model;

class AuditLog extends Model
{
    protected $table = "audit_log";
    protected $id = "id";

    protected function hasManyUser()
    {
        return "responsible_id";
    }
}
?>