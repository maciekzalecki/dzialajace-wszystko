<?php

$host = 'localhost';
$dbname = 'wypozyczalnia';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
    $pdo->query('SET NAMES utf8');
} catch (PDOException $e) {
    echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    exit();
}


$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        reset_token VARCHAR(255) DEFAULT NULL,
        reset_token_expiry DATETIME DEFAULT NULL
    );
");

?>
