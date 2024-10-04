<?php 
    require_once 'database.php'; 
    
    if(isset($_GET['szukaj'])){ 
        $stmt = $pdo->prepare("SELECT * FROM filmy WHERE tytul LIKE :tytul OR rezyser LIKE :rezyser");
        $stmt -> bindValue(':tytul', '%'.$_GET['szukaj'].'%', PDO::PARAM_STR);
        $stmt -> bindValue(':rezyser', '%'.$_GET['szukaj'].'%', PDO::PARAM_STR);
        $stmt->execute();
    }else{
        $stmt = $pdo->query('SELECT * FROM filmy');
    }
?>

<table class="table">
    <thead>
    <tr>
        <th>TYTUŁ</th>
        <th>ROK PRODUKCJI</th>
        <th>REŻYSER</th>
        <th>CZAS TRWANIA</th>
        <th>LICZBA KOPII</th>
        <th>EDYTUJ</th>
        <th>USUŃ</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($stmt as $row){    
        echo '<tr>';
        echo '<td>'.$row['tytul'].'</td>';
        echo '<td>'.$row['rokProd'].'</td>';
        echo '<td>'.$row['rezyser'].'</td>';
        echo '<td>'.$row['czas'].'min</td>';    
        echo '<td>'.$row['nosniki'].'</td>';    
        echo '<td><button class="tblbtn" value="'.$row['tytul'].'" onclick="edytuj_btnclick(this.value,'.$row['rokProd'].",'".$row['rezyser']."',".$row['czas'].','.$row['nosniki'].')">EDYTUJ</button></td>';
        echo '<td><button class="tblbtn" value="'.$row['tytul'].'" onclick="usun(this.value)">USUŃ</button></td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>