<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        
        $resetToken = bin2hex(random_bytes(50)); 
        

        echo "Na Twój email został wysłany link do resetu hasła.";
    } else {
        echo "Użytkownik z podanym adresem email nie istnieje.";
    }
}
?>
