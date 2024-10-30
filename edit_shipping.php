<?php
session_start();
require 'database.php';

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); // Przekieruj na stronę logowania
    exit();
}

// Sprawdź, czy ID dostawy jest przekazywane
if (!isset($_GET['id'])) {
    header('Location: manage_shipping.php');
    exit();
}

$id = $_GET['id'];

// Pobierz dane dostawy z bazy danych
$stmt = $pdo->prepare("SELECT * FROM shipping WHERE id = :id");
$stmt->execute(['id' => $id]);
$shipping = $stmt->fetch(PDO::FETCH_ASSOC);

// Sprawdź, czy dostawa istnieje
if (!$shipping) {
    header('Location: manage_shipping.php');
    exit();
}

// Obsługa formularza edytowania dostawy
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $cost = $_POST['cost'];

    // Aktualizuj dane dostawy w bazie danych
    $stmt = $pdo->prepare("UPDATE shipping SET name = :name, cost = :cost WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'cost' => $cost,
        'id' => $id
    ]);

    // Przekieruj po zapisaniu
    header('Location: manage_shipping.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Dostawę</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Panel Administratora</h1>
        <nav>
            <ul>
                <li><a href="index.html">Strona główna</a></li>
                <li><a href="logout.php">Wyloguj się</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Edytuj Dostawę</h2>
            <form method="POST">
                <div>
                    <label for="name">Nazwa dostawy:</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($shipping['name']); ?>" required>
                </div>
                <div>
                    <label for="cost">Koszt:</label>
                    <input type="number" step="0.01" name="cost" id="cost" value="<?php echo htmlspecialchars($shipping['cost']); ?>" required>
                </div>
                <button type="submit">Zapisz zmiany</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
