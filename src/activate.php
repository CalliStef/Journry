<?php 

require_once('./Controllers/DbController.php');

use \Controllers\DbController;

// get dotenv
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$conn = DbController::create_connection($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_PORT"]);

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

header("Location: /auth/login");


?>