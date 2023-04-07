<?php

namespace Controllers;

session_start();

require_once __DIR__ . '/src/Services/AuthServices.php';
require_once __DIR__ . '/src/Repositories/UserRepositories.php';

use Services\AuthServices;
use Repositories\UserRepositories;


class AuthController
{

    private static $user_repositories;
    private static $auth_services;


    public function __construct()
    {
        AuthController::$user_repositories = new UserRepositories();
        AuthController::$auth_services = new AuthServices();
    }

    public function registerUser()
    {

        // echo var_dump($_POST);
        $username = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL); // validate email format input
        $password = $_POST['password'];

        // check for any duplicate usernames in the database
        $count = AuthController::$user_repositories->getUserByEmail($username);

        // if there is a duplicate...
        if ($count > 0) {
            $_SESSION['error'] = 'Username already exists';
            header("Location: /auth/signup?notification=user-exists"); // navigate back to the signup page with an error message
            exit;
        }

        // if there is no duplicate...
        AuthController::$auth_services->addUser($username, $password);
    }

   

    public function loginUser()
    {

        // get the username and password from the form
        $username = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL); // validate email format input
        $password = $_POST['password'];

        // check if the username exists in the database
        $user = AuthController::$user_repositories->getUserByEmail($username);

        // if user doesn't exist in the database, redirect to signup page
        if ($user == 0) {
            header("Location: /auth/signup?notification=user-does-not-exist");
            exit;
        }

        // if user exists in the database, check if the password is correct
        AuthController::$auth_services->verifyUserLogin($user, $password);
        
    }

    public function logoutUser()
    {
        session_unset();
        session_destroy();
        header("Location: /auth/login");
    }
}
