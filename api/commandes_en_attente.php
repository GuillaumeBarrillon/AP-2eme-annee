<?php
include "Include/db_functions.php";
db_connect();

$tableau = array();

$sql = "Select * FROM commande;";
try {
    $sth = $dbh->query($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("<p>Erreur lors de la requête SQL : " . $ex->getMessage() . "</p>");
}

foreach($rows as $row){
    $tableau[ $row['id_commande'],$row['id_commande'],$row['id_commande'], $row['id_commande'], $row['id_commande'] ];
}
?>