<?php 
    require_once 'database.php'; 

    
    $stmt = $pdo->query("UPDATE filmy
    SET
        tytul = '".$_GET["tytul"]."',
        rokProd = '".$_GET["rok"]."',
        rezyser = '".$_GET["rezyser"]."',
        nosniki = '".$_GET["kopie"]."',
        czas = '".$_GET["czas"]."'
    WHERE
        tytul = '".$_GET["stary"]."'
    ");
?>
