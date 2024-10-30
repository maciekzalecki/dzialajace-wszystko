<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

require 'database.php'; // Połączenie z bazą danych

// Dodawanie zamówienia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_order'])) {
    $userId = $_POST['user_id'];
    $status = $_POST['status'];
    $orderDate = date('Y-m-d H:i:s'); // Ustawiamy datę na aktualny czas

    $insertStmt = $pdo->prepare("INSERT INTO orders (user_id, order_date, status) VALUES (:user_id, :order_date, :status)");
    $insertStmt->execute([
        'user_id' => $userId,
        'order_date' => $orderDate,
        'status' => $status
    ]);

    header('Location: view_orders.php?added=success');
    exit();
}

// Pobierz zamówienia z bazy danych
$stmt = $pdo->query("SELECT orders.id, orders.user_id, orders.order_date, orders.status, users.email 
                     FROM orders
                     JOIN users ON orders.user_id = users.id");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyświetl Zamówienia</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <header style="background-color: #333; color: white; padding: 15px; text-align: center;">
        <h1 style="margin: 0;">Wyświetl Zamówienia</h1>
    </header>

    <main style="padding: 20px;">
        <section style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 1000px; margin: 20px auto;">
            <h2 style="text-align: center;">Lista Zamówień</h2>

            <?php if (isset($_GET['added']) && $_GET['added'] === 'success'): ?>
                <p style="color: green;">Zamówienie zostało pomyślnie dodane.</p>
            <?php endif; ?>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">ID</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Email Użytkownika</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Data Zamówienia</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $order['id']; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($order['email']); ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $order['order_date']; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($order['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Dodaj Zamówienie</h3>
            <form method="POST" action="">
                <div>
                    <label for="user_id">ID Użytkownika:</label>
                    <input type="number" id="user_id" name="user_id" required>
                </div>
                <div>
                    <label for="status">Status:</label>
                    <select name="status" id="status" required>
                        <option value="pending">Oczekujące</option>
                        <option value="completed">Zakończone</option>
                        <option value="failed">Niepowodzenie</option>
                    </select>
                </div>
                <button type="submit" name="add_order" style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 5px;">Dodaj Zamówienie</button>
            </form>

            <a href="admin_panel.php" style="display: block; text-align: center; color: #333; text-decoration: none; padding: 10px 20px; background-color: #ddd; border-radius: 5px; max-width: 200px; margin: 20px auto;">Powrót do panelu administratora</a>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white;">
        <p>&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
