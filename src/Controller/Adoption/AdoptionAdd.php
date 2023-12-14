<?php
namespace MyApp\Controller\Adoption;

use MyApp\Model\Adoption;
use MyApp\Controller\PetModelController;
use MyApp\Controller\AuditModelController;

class AdoptionAdd {
    private $adoption;

    public function __construct()
    {
        $this->adoption = new Adoption();
    }


    public function addAdoption($responsibleId,$data)
    {   
        if ($this->isAdopted($data['pets_id'])) {
            return "Pet Already Adopted";
        }
        $lastId = $this->adoption->insert($data);

        $log = new AuditModelController();
        $log->activity_log($responsibleId,
         "INSERT",
         "ADOPTION",
         "ALL",
         $lastId,
         null,
         null);

        $pets = new PetModelController();
        $pets->updateProfileAdmin($responsibleId, $data['pets_id'], ['isAdopted' => 1]);

        return "Successfully Addded";
    }

    private function isAdopted($petsId){
        $pets = new PetModelController();
        $findPet = $pets->get_pet_data_by_id($petsId);

        if($findPet->isAdopted == 1){
            return true;
        }
        return false;
    }

}

?>