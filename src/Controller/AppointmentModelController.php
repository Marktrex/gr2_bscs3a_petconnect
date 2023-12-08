<?php
namespace MyApp\Controller;

use Dotenv\Dotenv;
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

        // make appointment
        $lastId =  $this->appointment->insert($appointmentData);
        $token = $appointmentData['token'];
        //send email
        $currentUser = $user->get_user_data_by_id($userId);
        $recipient = $currentUser->email;
        $fullname = $currentUser->fname . ' ' . $currentUser->lname;
        $body = '
            <h1>Appointment Confirmation</h1>
            <p>Dear ' . $fullname . ',</p>
            <p>Thank you for making an appointment with Pet Connect. To confirm your email address and enable your account, please click the link below:</p>
            <p><a href="http://localhost/repos/gr2_bscs3a_petconnect/dist/user/appointment_success.php?token=' . $token . '&id=' . $lastId . '">Confirm Email</a></p>
            <p>If you did not make this appointment, please ignore this email.</p>
            <p>Best regards,</p>
            <p>Pet Connect Team</p>
        ';

        $this->make_email($recipient, $fullname, "Appointment Confirmation", $body, true);

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
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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
                $mail->addAttachment('../papers/Adoption-Paper.pdf', 'adoption_papers.pdf');    
                $mail->addAttachment('../papers/Adoption-Paper-2.pdf', 'adoption_papers2.pdf');    
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
        //send email to the user
        $title = "Appointment Status Update";
        $body = "Your appointment has been " . $status;
        $this->make_email($oldData->email, $oldData->fname . ' ' . $oldData->lname, $title, $body);
        return true;
    }

    public function search($value, $columns, $userOperator=null){
        $appointment = $this->appointment;
        return $appointment->with("user")->search($value, $columns,$userOperator);
    }
}