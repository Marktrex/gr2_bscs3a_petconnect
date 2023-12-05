<?php
namespace MyApp\Controller;

use MyApp\Model\Pet;


class PetModelController{
    private $pets;

    public function __construct()
    {
        $this->pets = new Pet();
    }


    public function get_pet_data_by_id($user_id)
    {
        $user = $this->user;
        $user_data = $user->find($user_id);
        return $user_data;
    }

    public function search(){
        $pets = $this->pets;
        return $pets->search($value, $columns);
    }

    public function get_four_latest_pet($pet_type){
        $pets = $this->pets;
        return $pets->search($pet_type, ['pet_type'], false, 1, 4);
    }
}
?>