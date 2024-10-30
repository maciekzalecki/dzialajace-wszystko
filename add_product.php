<?php
session_start();
require_once 'database.php'; // Upewnij się, że masz plik do połączenia z bazą danych

// Sprawdzenie, czy formularz został przesłany
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Odbieranie danych z formularza
    $name = $_POST['product-name'];
    $price = $_POST['product-price'];
    $description = $_POST['product-description'];
    $category = $_POST['product-category'];

    // Sprawdzenie, czy wszystkie dane są wypełnione
    if (empty($name) || empty($price) || empty($description) || empty($category)) {
        echo json_encode(['success' => false, 'message' => 'Wszystkie pola są wymagane.']);
        exit;
    }

    // Przygotowanie zapytania do dodania produktu
    $stmt = $pdo->prepare("INSERT INTO products (name, price, description, category) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $price, $description, $category])) {
        echo json_encode(['success' => true, 'message' => 'Produkt został dodany.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Błąd podczas dodawania produktu.']);
    }
    exit; // Zakończ skrypt po przetworzeniu formularza
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Dodaj Produkt - Panel Administratora</title>
</head>
<body>
    <div class="container">
        <a href="admin_panel.php" class="btn btn-secondary mt-4 mb-3">Wróć do panelu admina</a>

        <h1 class="text-center">Dodaj Produkt</h1>
        
        <!-- Formularz dodawania produktu -->
        <form id="addProductForm" class="p-4 bg-light mt-3">
            <div class="mb-3">
                <label for="product-name" class="form-label">Nazwa Produktu</label>
                <input type="text" class="form-control" id="product-name" required>
            </div>
            <div class="mb-3">
                <label for="product-price" class="form-label">Cena Produktu</label>
                <input type="number" class="form-control" id="product-price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="product-description" class="form-label">Opis Produktu</label>
                <textarea class="form-control" id="product-description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="product-category" class="form-label">Kategoria Produktu</label>
                <input type="text" class="form-control" id="product-category" required>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj Produkt</button>
            <div id="add-product-message" class="mt-3"></div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Obsługa dodawania produktu
        $("#addProductForm").submit(function (e) {
            e.preventDefault(); // Zapobiega domyślnej akcji formularza

            // Zbieranie danych z formularza
            var name = $('#product-name').val();
            var price = $('#product-price').val();
            var description = $('#product-description').val();
            var category = $('#product-category').val();

            $.ajax({
                type: 'POST',
                url: 'add_product.php', // Adres URL do skryptu dodawania produktu
                data: {
                    'product-name': name,
                    'product-price': price,
                    'product-description': description,
                    'product-category': category
                },
                success: function (response) {
                    response = JSON.parse(response); // Parsowanie odpowiedzi z serwera
                    $('#add-product-message').text(response.message); // Wyświetlenie komunikatu
                    if (response.success) {
                        // Wyczyść formularz, jeśli dodawanie było udane
                        $('#addProductForm')[0].reset();
                    }
                },
                error: function () {
                    $('#add-product-message').text('Wystąpił błąd przy dodawaniu produktu.');
                }
            });
        });
    </script>
</body>
</html> 
