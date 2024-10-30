<?php
session_start();
require 'database.php';

// Sprawdzenie, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php'); // Przekierowanie do logowania
    exit();
}

// Pobierz podstrony
$stmt = $pdo->query("SELECT * FROM pages");
$pages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzaj Podstronami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Zarządzaj Podstronami</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tytuł</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page): ?>
                <tr>
                    <td><?= htmlspecialchars($page['id']) ?></td>
                    <td><?= htmlspecialchars($page['title']) ?></td>
                    <td>
                        <a href="edit_page.php?id=<?= $page['id'] ?>" class="btn btn-warning">Edytuj</a>
                        <a href="delete_page.php?id=<?= $page['id'] ?>" class="btn btn-danger">Usuń</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
