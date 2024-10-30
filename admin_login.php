<?php
session_start();
require 'database.php'; // Połączenie z bazą danych

// Sprawdzenie, czy użytkownik jest już zalogowany
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: admin_panel.php'); // Przekieruj na panel administratora
    exit();
}

// Obsługa logowania
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sprawdzenie, czy dane logowania są poprawne
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Sprawdzenie poprawności hasła i roli użytkownika
    if ($user && password_verify($password, $user['password']) && $user['role'] === 'admin') {
        // Zaloguj użytkownika
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: admin_panel.php'); // Przekierowanie na panel administratora
        exit();
    } else {
        $error_message = 'Nieprawidłowe dane logowania.';
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie Administratora</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 400px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center;">Logowanie Administratora</h2>
        <?php if (isset($error_message)): ?>
            <p style="color: red; text-align: center;"><?= $error_message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>
            <button type="submit" style="width: 100%; padding: 10px; border: none; background-color: #5cb85c; color: white; border-radius: 4px;">Zaloguj się</button>
        </form>
    </div>
</body>
</html>
