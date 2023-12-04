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
}
?>