<?php 

namespace Controllers;

require './vendor/autoload.php';

session_start();

// require_once '/PHPMailer/src/PHPMailer.php';
// require_once '/path/to/PHPMailer/src/SMTP.php';
// require_once '/path/to/PHPMailer/src/Exception.php';

use \Controllers\DbController;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class AuthController{

    private static $conn; 
    private static $mail;

    public function __construct(){
       AuthController::$conn = DbController::get_connection();
       AuthController::$mail = new PHPMailer(true);
    }

    public function registerUser(){
        
        // echo var_dump($_POST);
        $username = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL); // validate email format input
        $password = $_POST['password'];

        // check for any duplicate usernames in the database
        $stmt = AuthController::$conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();

        // if there is a duplicate...
        if ($count > 0) {
            $_SESSION['error'] = 'Username already exists';
            header("Location: /auth/signup?notification=user-exists"); // navigate back to the signup page with an error message
            exit;
        }

        // if there is no duplicate...
        $this->adduser($username, $password);

    }

    public function addUser($username, $password){

        // session_start();
        $_SESSION['user'] = $username;

        // hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // generate activation token
        $token = bin2hex(random_bytes(32));

        // insert user credentials as well as the token into the database
        $stmt = AuthController::$conn->prepare("INSERT INTO users(username, password, activation_token, created) VALUES(?, ?, ?, NOW())");
        $stmt->execute([$username, $password, $token]);

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

        $headers = 'no-reply@example.com';

        AuthController::$mail->From = $headers;
        AuthController::$mail->FromName = 'no-reply';
        AuthController::$mail->addAddress($username);
        AuthController::$mail->Subject = $subject;
        AuthController::$mail->Body = $message;
        AuthController::$mail->send();
        
        header("Location: /auth/login?notification=email-sent");
        
    }

    public function loginUser(){

        // // Check session for user login attempts
        // session_start();

        // get the username and password from the form
        $username = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL); // validate email format input
        $password = $_POST['password'];

        // check if the username exists in the database
        $stmt = AuthController::$conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();

        // if user doesn't exist in the database, redirect to signup page
        if ($count == 0) {
            header("Location: /auth/signup?notification=user-does-not-exist");
            exit;
        }

        // check with database to see if the password is the same
        $stmt = AuthController::$conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        echo "password: " . $password . "<br>";
        echo "user password: " . $user['password'] . "<br>";

        // check if the password is the same as the one in the database
        if (password_verify($password, $user['password'])) {


            // if the user has not activated their account, redirect to login page
            if ($user['active'] == 0) {
                header("Location: /auth/login?notification=activation");
                exit;
            }

            $_SESSION['login_success'] = 1;
            $_SESSION['user'] = $username;

             // Update the user's last activity time in the session
             $_SESSION['last_activity'] = time();
            
            header("Location: /home");

        } else {


            // if the user has failed 3 times, redirect to login page
            if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3) {
                header("Location: /auth/login?notification=locked-out");
                $this->forgotPassword();
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
        $stmt = AuthController::$conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hash_new_password, $username]);

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
        $headers = "no-reply@example.com";                        

        AuthController::$mail->From = $headers;
        AuthController::$mail->FromName = 'no-reply';
        AuthController::$mail->addAddress($username);
        AuthController::$mail->Subject = $subject;
        AuthController::$mail->Body = $message;
        AuthController::$mail->send();
    
        
        header("Location: /auth/login?notification=password-reset");

    }

    public function logoutUser(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: /auth/login");
    }

}
