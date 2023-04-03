<?php 
namespace Services;

use \Controllers\DbController;

class UserServices {

    private static $conn;

    public function __construct(){
        UserServices::$conn = DbController::get_connection();
    }

    public function getUserById($id){
        $stmt = UserServices::$conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user;
    }

    public function getUserByEmail($email){
        $stmt = UserServices::$conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user;
    }

    public function getUserIdByEmail($email){
        $stmt = UserServices::$conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$email]);
        $user_id = $stmt->fetchColumn();
        return $user_id;
    }

    public function addUser($email, $password){
        $stmt = UserServices::$conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$email, $password]);
    }

    public function deleteUserById($id){
        $stmt = UserServices::$conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function updateUserById($id, $email, $password){
        $stmt = UserServices::$conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->execute([$email, $password, $id]);
    }




}

?>