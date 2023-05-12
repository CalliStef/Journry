<?php 

require_once('./Data/DbConnection.php');

use Data\DbConnection;

// get dotenv
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$conn = DbConnection::create_connection($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_PORT"]);

// get the activation token from the URL
$token = $_GET['token'];

// find the user with the activation token in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE activation_token = :token");
$stmt->bindParam(':token', $token);
$stmt->execute();
$user = $stmt->fetch();

// if a user was found, activate their account
if ($user) {
  $stmt = $conn->prepare("UPDATE users SET active = 1, activation_token = NULL WHERE id = :id");
  $stmt->bindParam(':id', $user['id']);
  $stmt->execute();
} else {
  echo "Invalid activation token.";
}

header("Location: /auth/login");


?>