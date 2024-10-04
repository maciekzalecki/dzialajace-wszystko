<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo 'Użytkownik już istnieje.';
    } else {
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        if ($stmt->execute([$email, $hashedPassword])) {
            echo 'Rejestracja zakończona sukcesem!';
        } else {
            echo 'Wystąpił błąd podczas rejestracji.';
        }
    }
}
?>
