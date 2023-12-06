<?php
namespace MyApp\Controller;

use MyApp\Model\Appointment;
use MyApp\Controller\UserModelController;
use MyApp\Controller\AuditModelController;


class AppointmentModelController{
    private $appointment;

    public function __construct()
    {
        $this->appointment = new Appointment();
    }
    
    public function makeAppointment($userId, $userData, $appointmentData){
        // update profile
        $user = new UserModelController();
        $oldData = $user->get_user_data_by_id($userId);
        $newData = $userData;
       

        $user->updateProfile($userId, $userData);

        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if(array_key_exists($key, $newData) && $value != $newData[$key]){
                $log->activity_log(
                    $_SESSION['auth_user']['id'],
                    "UPDATE",
                    "USER",
                    $key,
                    $userId,
                    $value,
                    $newData[$key]
                );
            }
        }

        // make appointment
        return $this->appointment->insert($appointmentData);
    }
}