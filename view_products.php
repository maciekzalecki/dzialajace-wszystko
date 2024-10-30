<?php
// Połączenie z bazą danych
include 'database.php'; // Upewnij się, że ten plik zawiera poprawne połączenie PDO

// Zapytanie do bazy danych o wszystkie produkty
$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Produkty - Sklep FILMEX</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Zobacz Produkty</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Cena</th>
                    <th>Opis</th>
                    <th>Kategoria</th>
                    <th>Data dodania</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?> zł</td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Edytuj</a>
                                <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Usuń</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Brak produktów do wyświetlenia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <a href="add_product.php" class="btn btn-success">Dodaj Produkt</a>
        <a href="admin_panel.php" class="btn btn-secondary">Powrót do Panelu Administratora</a>
    </div>
</body>
</html>
