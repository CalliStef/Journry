<?php 

require_once('./Controllers/DbController.php');

use \Controllers\DbController;
$conn = DbController::create_connection("localhost", "php_term_project", "root", "Griya_indah49");

// get the activation token from the URL
$token = $_GET['token'];

// find the user with the activation token in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE activation_token = :token");
$stmt->bindParam(':token', $token);
$stmt->execute();
$user = $stmt->fetch();

echo var_dump($user);


// if a user was found, activate their account
if ($user) {
  $stmt = $conn->prepare("UPDATE users SET active = 1, activation_token = NULL WHERE id = :id");
  $stmt->bindParam(':id', $user['id']);
  $stmt->execute();
  echo "Your account has been activated. You can now log in.";
} else {
  echo "Invalid activation token.";
}

// header("Location: /auth/login");


?>