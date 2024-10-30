<?php

$host = 'mysql.ct8.pl';
$dbname = 'm50681_sklep'; 
$user = 'm50681_sklep'; 
$pass = 'Maciekprojekt123'; 

try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
    $pdo->query('SET NAMES utf8');
} catch (PDOException $e) {
    echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
    exit();
}

// Upewnij się, że tabele istnieją
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            reset_token VARCHAR(255) DEFAULT NULL,
            reset_token_expiry DATETIME DEFAULT NULL,
            role ENUM('user', 'admin') DEFAULT 'user',
            notes TEXT DEFAULT NULL  -- Nowa kolumna do przechowywania notatek
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            year INT NOT NULL,
            director VARCHAR(255),
            media VARCHAR(255),
            duration INT,
            categories VARCHAR(255)
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            order_date DATETIME,
            status VARCHAR(50),
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS shipping (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            cost DECIMAL(10, 2)
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255)
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS pages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
            content TEXT
        );
    ");
} catch (PDOException $e) {
    echo "Błąd podczas tworzenia tabeli: " . $e->getMessage();
}

?>
