<?php 

namespace Services;

// require vendor autoload.php
// require_once '/SendGrid/sendgrid-php.php';

use \SendGrid\Mail\Mail;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

class MailServices{

    public function __construct(){
 
    }

    public function sendMail($to, $subject, $message){
       
        try {
            $mail = new Mail();
            $mail->setFrom("callistastefanie@gmail.com");
            $mail->setSubject($subject);
            $mail->addTo($to);
            $mail->addContent("text/plain", $message);
    
            $sendgrid = new \SendGrid($_ENV['SENDGRID_API_KEY']);
            
            $sendgrid->send($mail);
          
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }

}



?>