<?php
namespace MyApp\Controller\Adoption;

use MyApp\Model\Adoption;

class AdoptionUser {
    private $adoption;

    public function __construct()
    {
        $this->adoption = new Adoption();
    }
}

?>