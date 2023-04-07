<?php 

namespace Services;



use Repositories\UserRepositories;
use Services\MailServices;


class AuthServices{

    private static $user_repositories;
    private static $mail_services;

    public function __construct(){
        AuthServices::$user_repositories = new UserRepositories();
        AuthServices::$mail_services = new MailServices();
    }

    public function addUser($username, $password)
    {

        // session_start();
        $_SESSION['user'] = $username;

        // hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // generate activation token
        $token = bin2hex(random_bytes(32));

        // insert user credentials as well as the token into the database
        AuthServices::$user_repositories->addUser($username, $password, $token);

        // create the activation link
        $activation_link = "http://$_SERVER[HTTP_HOST]/src/activate.php?token=$token";


        // // send activation email
        $subject = 'Activate your account';
        $message = "
        Thanks for signing up! 🥳🙌✨
        Your account has been created, you can login by pressing the url below. 
        -----------------
        $activation_link
        -----------------
        ";

        $mailServices = new MailServices();
        $mailServices->sendMail($username, $subject, $message);


        header("Location: /auth/login?notification=email-sent");
        
    }

    public function verifyUserLogin($user, $password){

        echo "user: $user";
        echo "password: $password";

        // check if the password is the same as the one in the database
        if (password_verify($password, $user['password'])) {


            // if the user has not activated their account, redirect to login page
            if ($user['active'] == 0) {
                header("Location: /auth/login?notification=activation");
                exit;
            }

            $_SESSION['login_success'] = 1;
            $_SESSION['user'] = $user['username'];

            // Update the user's last activity time in the session
            $_SESSION['last_activity'] = time();

            header("Location: /home");
        } else {


            // if the user has failed 3 times, redirect to login page
            if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3) {
                header("Location: /auth/login?notification=locked-out");
                $this->forgotPassword();
                $_SESSION['login_attempts'] = 0;
                exit;
            }

            // if the user has failed less than 3 times, increment the login_attempts
            if (isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts']++;
            } else {
                $_SESSION['login_attempts'] = 1;
            }

            // if the user has failed less than 3 times, redirect to login page
            $_SESSION['error'] = 'Wrong username or password';
            header("Location: /auth/login?notification=wrong-input");
        }
        
    }

    public function forgotPassword(){
        $username = $_SESSION['user'] ?? $_POST['username'];

        // generate a new password
        $new_password = bin2hex(random_bytes(32));

        $hash_new_password = password_hash($new_password, PASSWORD_DEFAULT);

        // save password to database
        AuthServices::$user_repositories->updatePassword($hash_new_password, $username);

        // send email with a new password
        $subject = 'New password';
        $message = "
            Here's a new password for your account to log in with. 🤗✨
            -----------------
            $new_password
            -----------------

            Click the link below to log in with your new password. 🚀
            -----------------
            http://$_SERVER[HTTP_HOST]/auth/login
            -----------------
        ";

       
        $mailServices = new MailServices();
        $mailServices->sendMail($username, $subject, $message);
       
        header("Location: /auth/login?notification=password-reset");

    }

}



?>