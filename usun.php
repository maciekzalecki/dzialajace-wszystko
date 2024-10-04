<?php 
    require_once 'database.php'; 

  
    $stmt = $pdo->query("DELETE FROM filmy WHERE tytul='".$_GET['tytul']."'");
?>