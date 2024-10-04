<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
       
        echo "<script>
                window.open('user_panel.php', '_blank');
                window.location.href = 'index.html'; 
              </script>";
        exit();
    } else {
        echo 'Niepoprawne dane logowania.';
    }
}
?>
