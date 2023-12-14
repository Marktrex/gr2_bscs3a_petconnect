<?php
namespace MyApp\Controller;

use MyApp\Model\Pet;
use MyApp\Controller\AuditModelController;


class PetModelController{
    private $pets;

    public function __construct()
    {
        $this->pets = new Pet();
    }


    public function get_pet_data_by_id($pet_id)
    {
        $pet = $this->pets;
        $pet_data = $pet->find($pet_id);
        return $pet_data;
    }

    public function search($value, $columns, $userOperator = null)
    {
        $pets = new Pet();

        // Append the isAdopted condition
        $columns[] = ['isAdopted'];
        $value[] = 0; // Assuming 0 means not adopted, adjust if needed
        $userOperator[] = true;

        return $pets->search($value, $columns, $userOperator);
    }


    public function get_four_latest_pet($pet_type){
        $pets = $this->pets;
        return $pets->search($pet_type, ['pet_type'], false, 1, 4);
    }

    public function updateProfileAdmin($responsibleId, $pet_id, $data){
        $pet = $this->pets;
        $oldData = $this->get_pet_data_by_id($pet_id);
        $newData = $data;
        $pet->update($pet_id, $data);

        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if(array_key_exists($key, $newData) && $value != $newData[$key]){
                $log->activity_log(
                    $responsibleId,
                    "UPDATE",
                    "PETS",
                    $key,
                    $pet_id,
                    $value,
                    $newData[$key]
                );
            }
        }
        return;
    }

    public function getAllPets(){
        $pets = $this->pets;
        return $pets->all();
    }
}
?>