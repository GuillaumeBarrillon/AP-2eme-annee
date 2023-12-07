<?php
include "../Include/db_functions.php";

$dbh = db_connect();

$sql = "SELECT * FROM commande WHERE id_etat = 0;";
try {
    $sth = $dbh->query($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die();
}

$json = json_encode($rows);
echo $json;
