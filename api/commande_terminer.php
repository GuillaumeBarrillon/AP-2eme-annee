<?php

include "../Include/db_functions.php";
include "../class/Reponse.php";

if (!isset($_GET["id_commande"])) {
    Reponse::reponseJsonEtDie([
        "success" => false,
        "erreur" => "L'id de commande n'est pas fourni"
    ]);
    echo json_encode($erreur);
    die();
}
$idCommande = $_GET["id_commande"];

$dbh = db_connect();
$stmt = $dbh->prepare("SELECT * FROM commande WHERE id_commande = :idCmd;");
$stmt->execute([
    ":idCmd" => $idCommande
]);
$row = $stmt->fetch();
if ($row == NULL) {
    Reponse::reponseJsonEtDie([
        "success" => false,
        "erreur" => "La commande $idCommande n'existe pas !"
    ]);
}

$stmt = $dbh->prepare("UPDATE commande SET id_etat = 2 WHERE id_commande = :idCmd;");
$stmt->execute([
    ":idCmd" => $idCommande
]);
Reponse::reponseJsonSansDie([
    "success" => true,
    "message" => "La commande $idCommande est maintenant acceptee !"
]);
