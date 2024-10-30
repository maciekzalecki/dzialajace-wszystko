<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Sprawdzenie roli
        if ($user['role'] === 'admin') {
            $_SESSION['admin_logged_in'] = true; // Zalogowanie administratora
            echo "<script>
                    window.open('admin_panel.php', '_blank');
                    window.location.href = 'admin_panel.php'; 
                  </script>";
        } else {
            // Użytkownik normalny
            echo "<script>
                    window.open('user_panel.php', '_blank');
                    window.location.href = 'index.html'; 
                  </script>";
        }
        exit();
    } else {
        echo 'Niepoprawne dane logowania.';
    }
}
?>
