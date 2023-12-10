<?php
namespace MyApp\Controller\Adoption;

use Dotenv\Dotenv;
use MyApp\Model\Adoption;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use MyApp\Controller\UserModelController;
use MyApp\Controller\AuditModelController;

class AdoptionManage {
    private $adoption;

    public function __construct()
    {
        $this->adoption = new Adoption();
    }

    public function getAllAdoption()
    {
        return $this->adoption->with('user')->with('pets')->all();
    }

    public function deleteData($responsibleId, $id)
    {
        $this->adoption->delete($id);

        $log = new AuditModelController();
        $log->activity_log(
            $responsibleId,
            "delete",
            "adoption",
            "All",
            $id,
            'All',
            'All'
        );
        
        return 'Deleted Successfully';
    }

    public function askStory($responsibleId,$adoptionId, $userId){
        $dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\..\\');
        $dotenv->load();
        $root = $_ENV['ROOT_FOLDER'];

        //get token and update the database
        $token = bin2hex(random_bytes(50));
        $this->updateAdoption($responsibleId, $adoptionId, ['token' => $token]);

        //get email
        $user = new UserModelController();
        $userData = $user->get_user_data_by_id($userId);
        $recipient = $userData->email;
        $fullname = $userData->fname . " " . $userData->lname;
        $title = "Story Request";
        $link = $root . "dist/user/add-adoption-story.php?token=" . $token . "&adoptionId=" . $adoptionId;
        $body = '
            <h1>Pet Connect Story Request</h1>
            <p>Our team is eager to know your experience to our pet</p>
            <p>Please share your story to us</p>
            <p>Click the link below to redirect to the page</p>
            <a href="' . $link . '">Click Here</a>
        ';

        $this->make_email($recipient, $fullname, $title, $body);

        return "Email Sent";
    }

    private function updateAdoption($responsibleId, $adoptionId, $data){
        $adoption = $this->adoption;
        $oldData = $this->get_adoption_data_by_id($adoptionId);
        $newData = $data;
        $adoption->update($adoptionId, $data);

        $log = new AuditModelController();
        foreach ($oldData as $key => $value)  {
            if(array_key_exists($key, $newData) && $value != $newData[$key]){
                $log->activity_log(
                    $responsibleId,
                    "UPDATE",
                    "ADOPTION",
                    $key,
                    $adoptionId,
                    $value,
                    $newData[$key]
                );
            }
        }
        return;
    }

    public function get_adoption_data_by_id($adoptionId)
    {
        $adoption = $this->adoption;
        $adoption_data = $adoption->with('user')->with('pets')->find($adoptionId);
        return $adoption_data;
    }

    private function make_email($recipient, $fullname, $title, $body){
        $dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\..\\');
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
}

?>