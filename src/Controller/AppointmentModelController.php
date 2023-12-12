<?php
namespace MyApp\Controller;

use Dotenv\Dotenv;
use MyApp\Class\MakeEmail;
use MyApp\Model\Appointment;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
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
                    $userId,
                    "UPDATE",
                    "USER",
                    $key,
                    $userId,
                    $value,
                    $newData[$key]
                );
            }
        }

        $dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
        $dotenv->load();
        $root = $_ENV['ROOT_FOLDER'];

        $emailMaker = new MakeEmail();
        // make appointment
        $lastId =  $this->appointment->insert($appointmentData);
        $token = $appointmentData['token'];
        $link = $root . '/dist/user/appointment_success.php?token=' . $token . '&id=' . $lastId . '';
        //send email
        $currentUser = $user->get_user_data_by_id($userId);
        $recipient = $currentUser->email;
        $fullname = $currentUser->fname . ' ' . $currentUser->lname;
        $body = $emailMaker->make_body_email_verify($fullname, $link);

        $this->make_email($recipient, $fullname, "Appointment Confirmation", $body, false);

        $log->activity_log(
            $userId,
            "INSERT",
            "APPOINTMENT",
            "All",
            $userId,
            "None",
            "All"
        );
    }

    public function get_appointment_data_by_id($id){
        $appointment = $this->appointment;
        $appointment_data = $appointment->with('user')->find($id);
        return $appointment_data;
    }

    public function make_appointment_pending($id, $token){
        $data = $this->get_appointment_data_by_id($id);
        
        if ($data->status != "Disabled") {
            return "Appointment has been process already";
        }

        if ($data->token != $token) {
            return "Invalid Token";
        }
        $appointment = $this->appointment;
        $appointment->update($id, [
            "status" => "Pending"
        ]);

        return "Status turned into Pending";
    }


    private function make_email($recipient, $fullname, $title, $body, $withAttachment=false){
        $dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
        $dotenv->load();

        $email = $_ENV['EMAIL'];
        $password = $_ENV['EMAIL_PASSWORD'];
        
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $email;                     //SMTP username
            $mail->Password   = $password;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($email, 'Pet Connect');
            $mail->addAddress($recipient, $fullname);     //Add a recipient
        
            //Attachments
            if($withAttachment)
            {
                $mail->addAttachment('../../papers/Adoption-Paper.pdf', 'adoption_papers.pdf');    
                $mail->addAttachment('../../papers/Adoption-Paper-2.pdf', 'adoption_papers2.pdf');    
            }
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $title;
            $mail->Body = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update_appointment_admin($responsibleId,$id, $status){
        //get old and new data
        $oldData = $this->get_appointment_data_by_id($id);
        $newData = [
            "status" => $status
        ];
        //update appointment
        $this->appointment->update($id, $newData);
        //audit log
        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if(array_key_exists($key, $newData) && $value != $newData[$key]){
                $log->activity_log(
                    $responsibleId,
                    "UPDATE",
                    "APPOINTMENT",
                    $key,
                    $id,
                    $value,
                    $newData[$key]
                );
            }
        }
        $emailMaker = new MakeEmail();

        //send email to the user
        $fullname = $oldData->fname . ' ' . $oldData->lname;
        $appointment_data = $this->get_appointment_data_by_id($id);
        $type = $appointment_data->appointment_type;
        $date = $appointment_data->appointment_date;
        $timeslot = $appointment_data->time_slot;
        $title = "Appointment Status Update";
        if ($status == "Accepted"){
            $body = $emailMaker->make_body_email_accept($fullname, $type, $date, $timeslot);
        }
        if ($status == "Declined"){
            $body = $emailMaker->make_body_email_decline($fullname);
        }
        if ($status == "Cancelled"){
            $body = $emailMaker->make_body_email_cancel($fullname);
        }
        $this->make_email($oldData->email, $fullname, $title, $body);
        return true;
    }

    public function search($value, $columns, $userOperator=null){
        $appointment = $this->appointment;
        return $appointment->with("user")->search($value, $columns,$userOperator);
    }

    public function searchV2($value, $columns,$tablesArray, $userOperator=null){
        $appointment = $this->appointment;
        return $appointment->with("user")->searchV2($value, $columns, $tablesArray , $userOperator);
    }
}