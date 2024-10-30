<?php
session_start();


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); 
    exit();
}


$host = 'mysql.ct8.pl'; 
$dbname = 'm50681_sklep'; 
$user = 'm50681_sklep'; 
$pass = 'Maciekprojekt123'; 

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    
    $stmt = $pdo->prepare("UPDATE pages SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $content, $id]);

    
    header('Location: edit_pages.php?success=1');
    exit();
}


$pages = $pdo->query("SELECT * FROM pages")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Podstrony</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <header style="text-align: center;">
        <h1>Edytuj Podstrony</h1>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">Podstrona została zaktualizowana pomyślnie!</p>
        <?php endif; ?>
        
        <a href="admin_panel.php" style="display: inline-block; background-color: #2196F3; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-top: 10px;">Powrót do Panelu Administratora</a>
    </header>

    <main style="max-width: 800px; margin: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ccc; padding: 10px;">ID</th>
                    <th style="border: 1px solid #ccc; padding: 10px;">Tytuł</th>
                    <th style="border: 1px solid #ccc; padding: 10px;">Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 10px;"><?php echo $page['id']; ?></td>
                        <td style="border: 1px solid #ccc; padding: 10px;"><?php echo htmlspecialchars($page['title']); ?></td>
                        <td style="border: 1px solid #ccc; padding: 10px;">
                            <form action="edit_pages.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $page['id']; ?>">
                                <input type="hidden" name="title" value="<?php echo htmlspecialchars($page['title']); ?>">
                                <input type="hidden" name="content" value="<?php echo htmlspecialchars($page['content']); ?>">
                                <button type="submit" name="edit" style="background-color: #2196F3; color: white; padding: 5px 10px; border: none; border-radius: 4px;">Edytuj</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($_POST['edit'])): ?>
            <h2>Edytuj Podstronę</h2>
            <form action="edit_pages.php" method="post">
                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
                <label for="title">Tytuł:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($_POST['title']); ?>" required>
                <label for="content">Treść:</label>
                <textarea name="content" id="content" rows="5" required><?php echo htmlspecialchars($_POST['content']); ?></textarea>
                <button type="submit" name="update" style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 4px;">Zaktualizuj</button>
            </form>
        <?php endif; ?>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: fixed; bottom: 0; width: 100%;">
        <p>&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
