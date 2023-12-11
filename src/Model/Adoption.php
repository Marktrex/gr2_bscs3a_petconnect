<?php

namespace MyApp\Model;

use MyApp\Model\Model;


class Adoption extends Model
{
    protected $table = "adoption";
    protected $id = "adoption_id";

    protected function hasManyUser()
    {
        return "user_id";
    }

    protected function hasManyPets()
    {
        return "pets_id";
    }
}
?>