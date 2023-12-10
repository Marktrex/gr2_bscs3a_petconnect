<?php
namespace MyApp\Controller\Adoption;

use MyApp\Model\Adoption;

class AdoptionManage {
    private $adoption;

    public function __construct()
    {
        $this->adoption = new Adoption();
    }

    
}

?>