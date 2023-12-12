<?php
namespace MyApp\Controller\Adoption;

use MyApp\Model\Adoption;

class AdoptionUser {
    private $adoption;

    public function __construct()
    {
        $this->adoption = new Adoption();
    }

    public function getAllAdoption()
    {
        return $this->adoption->with('user')->with('pets')->all();
    }

    public function get_adoption_data($adoptionId)
    {
        return $this->adoption->with('pets')->with('user')->find($adoptionId);
    }
}

?>