<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); // Przekieruj na stronę logowania
    exit();
}

require 'database.php'; // Połączenie z bazą danych

// Sprawdź, czy ID klienta jest przekazywane przez URL
if (!isset($_GET['id'])) {
    header('Location: view_customers.php'); // Przekieruj, jeśli brak ID klienta
    exit();
}

$customerId = intval($_GET['id']);

// Pobierz dane klienta
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $customerId]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// Sprawdź, czy klient istnieje
if (!$customer) {
    header('Location: view_customers.php'); // Przekieruj, jeśli klient nie istnieje
    exit();
}

// Aktualizacja danych klienta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $notes = $_POST['notes'];

    // Zaktualizuj dane klienta w bazie
    $updateStmt = $pdo->prepare("UPDATE users SET email = :email, notes = :notes WHERE id = :id");
    $updateStmt->execute([
        'email' => $email,
        'notes' => $notes,
        'id' => $customerId
    ]);

    // Przekieruj po zapisaniu zmian
    header('Location: view_customers.php?updated=success');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Klienta</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f0f2f5; margin: 0; padding: 0; color: #333;">

    <header style="background-color: #3b5998; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0; font-size: 1.8em;">Edytuj Klienta</h1>
    </header>

    <main style="padding: 20px;">
        <section style="background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 30px auto;">
            <h2 style="text-align: center; font-size: 1.5em; color: #3b5998;">Edytuj informacje o kliencie</h2>
            <form method="POST" action="" style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <label for="notes" style="display: block; font-weight: bold; margin-bottom: 5px;">Notatki:</label>
                    <textarea id="notes" name="notes" rows="4" 
                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"><?php echo htmlspecialchars($customer['notes']); ?></textarea>
                </div>
                <button type="submit" 
                        style="background-color: #3b5998; color: white; padding: 10px; border: none; border-radius: 5px; font-size: 1em; cursor: pointer;">
                    Zapisz zmiany
                </button>
            </form>
            <div style="text-align: center; margin-top: 20px;">
                <a href="view_customers.php" 
                   style="color: #3b5998; text-decoration: none; padding: 10px 20px; border: 1px solid #3b5998; border-radius: 5px; display: inline-block; font-weight: bold;">
                    Powrót do listy klientów
                </a>
            </div>
        </section>
    </main>

    <footer style="text-align: center; padding: 15px; background-color: #3b5998; color: white; position: fixed; bottom: 0; width: 100%;">
        <p style="margin: 0;">&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>

</body>
</html>
