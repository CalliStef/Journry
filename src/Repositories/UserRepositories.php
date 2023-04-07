<?php 
namespace Repositories;


use Controllers\DbController;

class UserRepositories {

    private static $conn;

    public function __construct(){
        UserRepositories::$conn = DbController::get_connection();
    }

    public function getUserById($id){
        $stmt = UserRepositories::$conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user;
    }

    public function getUserByEmail($email){
        $stmt = UserRepositories::$conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user;
    }

    public function getUserIdByEmail($email){
        $stmt = UserRepositories::$conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$email]);
        $user_id = $stmt->fetchColumn();
        return $user_id;
    }

    public function addUser($username, $password, $token){
        $stmt = UserRepositories::$conn->prepare("INSERT INTO users(username, password, activation_token, created) VALUES(?, ?, ?, NOW())");
        $stmt->execute([$username, $password, $token]);
    }

    public function deleteUserById($id){
        $stmt = UserRepositories::$conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function updateUserById($id, $email, $password){
        $stmt = UserRepositories::$conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->execute([$email, $password, $id]);
    }

    public function updatePassword($hash_new_password, $username){
        $stmt = UserRepositories::$conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hash_new_password, $username]);
    }




}

?>