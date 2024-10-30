<?php
session_start();
require 'database.php';

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); // Przekieruj na stronę logowania
    exit();
}

// Obsługuje dodawanie dostawy
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_shipping'])) {
    $name = $_POST['name'];
    $cost = $_POST['cost'];

    $stmt = $pdo->prepare("INSERT INTO shipping (name, cost) VALUES (:name, :cost)");
    $stmt->execute(['name' => $name, 'cost' => $cost]);
}

// Pobierz dostawy z bazy danych
$stmt = $pdo->query("SELECT * FROM shipping");
$shippings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj Dostawami</title>
    <style>
        /* Ogólne style */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        header, footer {
            background-color: #333;
            color: #f4f4f9;
            padding: 15px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: #f4f4f9;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
        }

        /* Sekcja Zarządzaj Dostawami */
        section {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #333;
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: #f4f4f9;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #555;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button[type="submit"] {
            background-color: #333;
            color: #f4f4f9;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #555;
        }

        /* Tabela Dostaw */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: #f4f4f9;
            font-weight: bold;
        }
        td {
            background-color: #f9f9f9;
        }
        a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            color: #007bff;
            text-decoration: underline;
        }

        /* Stopka */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: #f4f4f9;
        }
    </style>
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
            <a href="admin_panel.php" class="back-button">Wróć do panelu admina</a>
            <h2>Zarządzaj Dostawami</h2>
            <form method="POST">
                <div>
                    <label for="name">Nazwa dostawy:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <label for="cost">Koszt:</label>
                    <input type="number" step="0.01" name="cost" id="cost" required>
                </div>
                <button type="submit" name="add_shipping">Dodaj dostawę</button>
            </form>

            <h3>Dostawy</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Koszt</th>
                    <th>Akcje</th>
                </tr>
                <?php foreach ($shippings as $shipping): ?>
                <tr>
                    <td><?php echo htmlspecialchars($shipping['id']); ?></td>
                    <td><?php echo htmlspecialchars($shipping['name']); ?></td>
                    <td><?php echo htmlspecialchars($shipping['cost']); ?> PLN</td>
                    <td>
                        <a href="edit_shipping.php?id=<?php echo $shipping['id']; ?>">Edytuj</a> |
                        <a href="delete_shipping.php?id=<?php echo $shipping['id']; ?>" onclick="return confirm('Czy na pewno chcesz usunąć tę dostawę?');">Usuń</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
