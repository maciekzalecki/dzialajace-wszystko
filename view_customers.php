<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); // Przekieruj na stronę logowania
    exit();
}

require 'database.php'; // Połączenie z bazą danych

// Pobierz wszystkich klientów
$stmt = $pdo->query("SELECT * FROM users WHERE role = 'user'");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klienci</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">

    <header style="background-color: #283593; color: white; padding: 20px; text-align: center; font-size: 1.5em;">
        <h1 style="margin: 0;">Zarządzanie Klientami</h1>
    </header>

    <main style="padding: 30px;">
        <section style="background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); max-width: 900px; margin: 0 auto;">
            <h2 style="text-align: center; font-size: 1.8em; color: #283593; margin-bottom: 20px;">Lista Klientów</h2>
            <?php if (isset($_GET['updated']) && $_GET['updated'] === 'success'): ?>
                <p style="color: green; text-align: center; font-size: 1.1em;">Dane klienta zostały pomyślnie zaktualizowane.</p>
            <?php endif; ?>
            
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr style="background-color: #283593; color: white;">
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Email</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Notatki</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr style="background-color: #f4f4f9;">
                        <td style="border: 1px solid #ddd; padding: 12px;"><?php echo htmlspecialchars($customer['email']); ?></td>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?php echo htmlspecialchars($customer['notes']); ?></td>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                            <a href="edit_customer.php?id=<?php echo $customer['id']; ?>" style="color: #283593; text-decoration: none; font-weight: bold;">Edytuj</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 20px;">
                <a href="admin_panel.php" style="background-color: #283593; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Powrót do panelu administratora</a>
            </div>
        </section>
    </main>

    <footer style="text-align: center; padding: 15px; background-color: #283593; color: white; position: fixed; bottom: 0; width: 100%;">
        <p style="margin: 0;">&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>

</body>
</html>
