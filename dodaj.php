<?php 
    require_once 'database.php'; 

    
    $stmt = $pdo->query("INSERT INTO filmy(tytul, rokProd, rezyser, nosniki, czas) 
    VALUES('".
        $_GET["tytul"]."','".
        $_GET["rok"]."','".
        $_GET["rezyser"]."','".
        $_GET["kopie"]."','".
        $_GET["czas"].
    "')");
?>