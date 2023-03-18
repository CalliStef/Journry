<?php
// set the database credentials
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_database_username';
$password = 'your_database_password';

// create a PDO instance
try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

?>