<?php
session_start();
require 'database.php';

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); // Przekieruj na stronę logowania
    exit();
}

// Sprawdź, czy ID dostawy jest przekazywane
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Usuń dostawę z bazy danych
    $stmt = $pdo->prepare("DELETE FROM shipping WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Przekieruj do zarządzania dostawami
header('Location: manage_shipping.php');
exit();
?>
