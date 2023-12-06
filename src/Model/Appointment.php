<?php

namespace MyApp\Model;

use MyApp\Model\Model;

class Appointment extends Model
{
    protected $table = "appointment";
    protected $id = "appointment_id";

    protected function hasManyUser()
    {
        return "user_id";
    }

    public function makeAppointment($userId, $fname, $lname, ){

    }
}
?>