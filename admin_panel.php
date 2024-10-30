<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); // Przekieruj na stronę logowania
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administratora</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

    <header style="background-color: #333; color: white; padding: 15px; text-align: center;">
        <h1 style="margin: 0;">Panel Administratora</h1>
        <nav>
            <ul style="list-style: none; padding: 0; margin: 0; text-align: center;">
                <li style="display: inline; margin-right: 10px;">
                    <a href="index.html" style="color: white; text-decoration: none; padding: 8px 16px; background-color: #555; border-radius: 4px;">Strona główna</a>
                </li>
                <li style="display: inline;">
                    <a href="logout.php" style="color: white; text-decoration: none; padding: 8px 16px; background-color: #d9534f; border-radius: 4px;">Wyloguj się</a>
                </li>
            </ul>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 20px auto;">
            <h2 style="text-align: center;">Witamy w panelu administratora</h2>
            <p style="text-align: center;">Zarządzaj swoimi zasobami.</p>

            <!-- Zarządzanie produktami -->
            <div style="border: 1px solid #ccc; border-radius: 5px; margin: 10px 0; padding: 15px;">
                <h3 style="text-align: center;">Zarządzanie Produktami</h3>
                <ul style="list-style: none; padding: 0; text-align: center;">
                    <li>
                        <a href="add_product.php" style="display: inline-block; text-decoration: none; background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Dodaj produkt</a>
                    </li>
                    <li>
                        <a href="view_products.php" style="display: inline-block; text-decoration: none; background-color: #008CBA; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Zobacz produkty</a>
                    </li>
                </ul>
            </div>

            <!-- Zarządzanie klientami -->
            <div style="border: 1px solid #ccc; border-radius: 5px; margin: 10px 0; padding: 15px;">
                <h3 style="text-align: center;">Zarządzanie Klientami</h3>
                <ul style="list-style: none; padding: 0; text-align: center;">
                    <li>
                        <a href="view_customers.php" style="display: inline-block; text-decoration: none; background-color: #f44336; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Zobacz i edytuj klientów</a>
                    </li>
                </ul>
            </div>

            <!-- Zarządzanie zamówieniami -->
            <div style="border: 1px solid #ccc; border-radius: 5px; margin: 10px 0; padding: 15px;">
                <h3 style="text-align: center;">Zarządzanie Zamówieniami</h3>
                <ul style="list-style: none; padding: 0; text-align: center;">
                    <li>
                        <a href="view_orders.php" style="display: inline-block; text-decoration: none; background-color: #673AB7; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Zobacz zamówienia</a>
                    </li>
                </ul>
            </div>

            <!-- Zarządzanie dostawami i płatnościami -->
            <div style="border: 1px solid #ccc; border-radius: 5px; margin: 10px 0; padding: 15px;">
                <h3 style="text-align: center;">Zarządzanie Dostawami i Płatnościami</h3>
                <ul style="list-style: none; padding: 0; text-align: center;">
                    <li>
                        <a href="manage_shipping.php" style="display: inline-block; text-decoration: none; background-color: #2196F3; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Zarządzaj dostawami</a>
                    </li>
                    <li>
                        <a href="manage_payments.php" style="display: inline-block; text-decoration: none; background-color: #FFC107; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Zarządzaj płatnościami</a>
                    </li>
                </ul>
            </div>

            <!-- Zarządzanie podstronami -->
            <div style="border: 1px solid #ccc; border-radius: 5px; margin: 10px 0; padding: 15px;">
                <h3 style="text-align: center;">Zarządzanie Podstronami</h3>
                <ul style="list-style: none; padding: 0; text-align: center;">
                    <li>
                        <a href="add_page.php" style="display: inline-block; text-decoration: none; background-color: #9C27B0; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Dodaj podstronę informacyjną</a>
                    </li>
                    <li>
                        <a href="edit_pages.php" style="display: inline-block; text-decoration: none; background-color: #FF5722; color: white; padding: 10px 20px; border-radius: 4px; margin: 5px;">Edytuj istniejące podstrony</a>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: fixed; bottom: 0; width: 100%;">
        <p>&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>
    
</body>
</html>
