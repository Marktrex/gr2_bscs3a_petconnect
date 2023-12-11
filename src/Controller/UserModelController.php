<?php
namespace MyApp\Controller;

use MyApp\Model\User;




class UserModelController{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function updateProfile($user_id, $data)
    {
        $user = $this->user;
        $user->update($user_id, $data);
    }

    public function get_user_data_by_id($user_id)
    {
        $user = $this->user;
        $user_data = $user->find($user_id);
        return $user_data;
    }

    public function deleteUser($user_id)
    {
        $user = $this->user;
        $user->delete($user_id);
    }

    public function getAllUsers(){
        $user = $this->user;
        return $user->all();
    }
}
?>