<?php 

// Database controller

namespace Controllers;

class DbController{
    private static $db_connection;

    public function __construct(){

    }

    public static function create_connection($host, $db, $user, $pass)
    {

        try {
            DbController::$db_connection = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);
            return DbController::$db_connection;
        } catch(\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

    }

    public static function get_connection(){
        return DbController::$db_connection;
    }

   
}
