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
        $body = $this->make_body_email($fullname, $link);

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


    private function make_body_email($name, $link){
        return '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Share your Story</title>
        </head>
        <body style = "background-color: #fdc161; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif;">
            <div style="padding: 5vw;
                color:#127475;
                ">
                <div style="border: none; border-bottom: 1px solid rgba(242, 84, 45, 0.7); padding: 1rem 0;">
                    <img src="https://i.ibb.co/b6GMMSM/logo.png" alt="Pet Connect Logo" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1; margin-left: 5vw;">
                </div>
                <h2 style="text-align: center;">
                    <img src="https://i.ibb.co/1LzZbWH/Ok.png" alt="Image" style="border-radius: 50%;
                    aspect-ratio: 1/1; height: 10vw; width: 12vw;">
                    <br>
                    The PetConnect Team is asking for your story
                </h2>
                <br>
                <div style="padding: 5vw;">
                    <p>
                        Dear <span style="font-weight: bold;">'.$name.'</span>,
                    </p>
                    <br><br>
                    <p>
                        We are striving everyday to encourage people to meet their pets.
                        And now Pet Connect is asking for your story to help us find the owners of our pets.
                    </p>
                    <a href="'.$link.'" style="background-color: #f5dfbb;
                     padding: 10px;
                     border-radius: 30px;
                     border: 2px solid #ffb845;
                     text-decoration: none;
                     display: inline-block;
                     color: black;">
                        Click the link to visit the page
                    </a>
                    <br>
                    <p style="font-style: italic; font-size: 0.8rem;">
                        PetConnect values data confidentially. Your information will be only used in appointment purposes.
                    </p>
                    <br>
                    <p style=" font-size: 0.8rem;">
                        If there is something wrong with your details please message us at our website <span style="text-decoration: underline;
                        font-weight: bold; font-style: italic;">PetConnect.com</span>
                    </p>
                    <br>
                    <p>
                        Sincerely,
                    </p>
                    <p style="font-weight: bold;">
                        PetConnect
                    </p>
                </div>
            </div>
        </body>
        </html>
        ';
    }
}

?>