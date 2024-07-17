<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//$servername = getenv('DDBB_SERVERNAME'); // Or $_ENV['DDBB_SERVERNAME']
$servername = $_ENV['DDBB_SERVERNAME'];
$username = $_ENV['DDBB_USERNAME'];
$password = $_ENV['DDBB_PASSWORD'];
$dbname = $_ENV['DDBB_DBNAME'];

/*
var_dump($servername);
var_dump($username);
var_dump($password);
var_dump($dbname);
die();
*/
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
