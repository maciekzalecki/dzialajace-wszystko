<?php
session_start();


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php'); 
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $pdo = new PDO('mysql:host=mysql.ct8.pl;dbname=m50681_sklep', 'm50681_sklep', 'Maciekprojekt123');
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    $page_title = $_POST['title'];
    $page_content = $_POST['content'];

    
    $stmt = $pdo->prepare("INSERT INTO pages (title, content) VALUES (:title, :content)");
    $stmt->execute(['title' => $page_title, 'content' => $page_content]);

    
    echo "<script>alert('Podstrona została dodana!'); window.location.href='admin_panel.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Podstronę Informacyjną</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <header style="background-color: #333; color: white; padding: 15px; text-align: center;">
        <h1 style="margin: 0;">Dodaj Podstronę Informacyjną</h1>
    </header>

    <main style="padding: 20px;">
        <section style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 20px auto;">
            <form method="POST" action="add_page.php">
                <div style="margin-bottom: 15px;">
                    <label for="title" style="display: block; margin-bottom: 5px;">Tytuł Podstrony:</label>
                    <input type="text" id="title" name="title" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="content" style="display: block; margin-bottom: 5px;">Treść Podstrony:</label>
                    <textarea id="content" name="content" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; height: 200px;"></textarea>
                </div>
                <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px;">Dodaj Podstronę</button>
            </form>
            <br>
            <a href="admin_panel.php" style="text-decoration: none; background-color: #2196F3; color: white; padding: 10px 20px; border-radius: 4px;">Powrót do Panelu Administratora</a>
        </section>
    </main>

    <footer style="text-align: center; padding: 10px; background-color: #333; color: white; position: fixed; bottom: 0; width: 100%;">
        <p>&copy; 2024 Twój Sklep. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
