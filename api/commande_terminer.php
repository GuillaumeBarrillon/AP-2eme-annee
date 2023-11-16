<?php

include "../Include/db_functions.php";

if(!isset($_GET["id_commande"])){
    $erreur = [
        "success" => false,
        "erreur" => "L'id de commande n'est pas fourni"
    ];
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
if($row == NULL){
    $erreur = [
        "success" => false,
        "erreur" => "La commande $idCommande n'existe pas !"
    ];
    echo json_encode($erreur);
    die(); 
}

$stmt = $dbh->prepare("UPDATE commande SET id_etat = 2 WHERE id_commande = :idCmd;");
$stmt->execute([
    ":idCmd" => $idCommande
]);
$erreur = [
    "success" => true,
    "message" => "La commande $idCommande est maintenant acceptee !"
];
echo json_encode($erreur);