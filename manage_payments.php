<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

require 'database.php'; // Połączenie z bazą danych

// Dodawanie płatności
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_payment'])) {
    $userId = $_POST['user_id'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    // Zapisz płatność do bazy danych
    $stmt = $pdo->prepare("INSERT INTO payments (user_id, amount, status, date) VALUES (:user_id, :amount, :status, :date)");
    $stmt->execute([
        'user_id' => $userId,
        'amount' => $amount,
        'status' => $status,
        'date' => $date
    ]);
    header('Location: manage_payments.php?added=success');
    exit();
}

// Pobierz wszystkie płatności
$stmt = $pdo->query("SELECT payments.id, payments.user_id, payments.amount, payments.status, payments.date, users.email 
                     FROM payments
                     JOIN users ON payments.user_id = users.id");
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sprawdź, czy formularz aktualizacji/usuwania został przesłany
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_payment'])) {
        // Aktualizacja statusu płatności
        $paymentId = $_POST['payment_id'];
        $status = $_POST['status'];
        $updateStmt = $pdo->prepare("UPDATE payments SET status = :status WHERE id = :id");
        $updateStmt->execute(['status' => $status, 'id' => $paymentId]);
        header('Location: manage_payments.php?updated=success');
        exit();
    } elseif (isset($_POST['delete_payment'])) {
        // Usuwanie płatności
        $paymentId = $_POST['payment_id'];
        $deleteStmt = $pdo->prepare("DELETE FROM payments WHERE id = :id");
        $deleteStmt->execute(['id' => $paymentId]);
        header('Location: manage_payments.php?deleted=success');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj Płatnościami</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <header style="background-color: #333; color: white; padding: 15px; text-align: center;">
        <h1 style="margin: 0;">Zarządzaj Płatnościami</h1>
    </header>

    <main style="padding: 20px;">
        <section style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 1000px; margin: 20px auto;">
            <h2 style="text-align: center;">Lista Płatności</h2>

            <?php if (isset($_GET['added']) && $_GET['added'] === 'success'): ?>
                <p style="color: green;">Płatność została pomyślnie dodana.</p>
            <?php elseif (isset($_GET['updated']) && $_GET['updated'] === 'success'): ?>
                <p style="color: green;">Status płatności został pomyślnie zaktualizowany.</p>
            <?php elseif (isset($_GET['deleted']) && $_GET['deleted'] === 'success'): ?>
                <p style="color: red;">Płatność została pomyślnie usunięta.</p>
            <?php endif; ?>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">ID</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Email Użytkownika</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Kwota</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Status</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Data</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $payment['id']; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($payment['email']); ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo number_format($payment['amount'], 2); ?> PLN</td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $payment['status']; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $payment['date']; ?></td>
                            <td style="border: 1px solid #ddd; padding: 8px;">
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                    <select name="status" required>
                                        <option value="completed" <?php if ($payment['status'] == 'completed') echo 'selected'; ?>>Zakończono</option>
                                        <option value="pending" <?php if ($payment['status'] == 'pending') echo 'selected'; ?>>Oczekująca</option>
                                        <option value="failed" <?php if ($payment['status'] == 'failed') echo 'selected'; ?>>Niepowodzenie</option>
                                    </select>
                                    <button type="submit" name="update_payment" style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 5px;">Zapisz</button>
                                </form>
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                    <button type="submit" name="delete_payment" style="background-color: #f44336; color: white; padding: 5px 10px; border: none; border-radius: 5px;">Usuń</button>
                                </form>
                                <br>
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $payment['user_id']; ?>">
                                    <input type="hidden" name="amount" value="<?php echo $payment['amount']; ?>">
                                    <input type="hidden" name="status" value="<?php echo $payment['status']; ?>">
                                    <input type="hidden" name="date" value="<?php echo $payment['date']; ?>">
                                    <button type="submit" name="add_payment" style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 5px;">Dodaj</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2 style="text-align: center;">Dodaj Płatność</h2>
            <form method="POST" action="">
                <label for="user_id">ID Użytkownika:</label>
                <input type="number" id="user_id" name="user_id" required>
                <label for="amount">Kwota:</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="completed">Zakończono</option>
                    <option value="pending">Oczekująca</option>
                    <option value="failed">Niepowodzenie</option>
                </select>
                <label for="date">Data:</label>
                <input type="date" id="date" name="date" required>
                <button type="submit" name="add_payment" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Dodaj Płatność</button>
            </form>

            <a href="admin_panel.php" style="display: block; text-align: center; color: #333; text-decoration: none; padding: 10px 20px; background-color: #ddd; border-radius: 5px; max-width: 200px; margin: 20px auto;">Powrót do panelu administratora</a>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white;">
        <p>&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
