<?php 

// Database controller

namespace Data;

class DbConnection{
    private static $db_connection;

    public function __construct(){

    }

    public static function create_connection($host, $db, $user, $pass, $port)
    {

        try {
            DbConnection::$db_connection = new \PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
            return DbConnection::$db_connection;
        } catch(\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

    }

    public static function get_connection(){
        return DbConnection::$db_connection;
    }

   
}
