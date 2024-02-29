<?php
include "../Include/db_functions.php";

$dbh = db_connect();

// Sélectionner les commandes avec leurs lignes associées
$stmt = $dbh->prepare("SELECT commande.*, ligne.*
FROM commande
INNER JOIN ligne ON commande.id_commande = ligne.id_commande
WHERE commande.id_etat = 0;");
$stmt->execute();

$commandes = $stmt->fetchAll();

// Organiser les commandes par leur ID pour regrouper les lignes
$commandesGrouped = [];
foreach ($commandes as $commande) {
    $commandeId = $commande['id_commande'];
    if (!isset($commandesGrouped[$commandeId])) {
        // Si la commande n'existe pas dans le tableau regroupé, l'ajouter
        $commandesGrouped[$commandeId] = [
            'id_commande' => $commande['id_commande'],
            'id_user' => $commande['id_user'],
            'id_etat' => $commande['id_etat'],
            'date' => $commande['date'],
            'total_commande' => $commande['total_commande'],
            'type_conso' => $commande['type_conso'],
            'lignes' => [] // Initialiser un tableau pour les lignes de commande
        ];
    }
    // Ajouter la ligne à la commande correspondante dans le tableau regroupé
    $commandesGrouped[$commandeId]['lignes'][] = [
        'id_ligne' => $commande['id_ligne'],
        'id_produit' => $commande['id_produit'],
        'qte' => $commande['qte'],
        'total_ligne_ht' => $commande['total_ligne_ht']
    ];
}

// Convertir le tableau regroupé en un tableau simple pour la réponse JSON
$commandesGrouped = array_values($commandesGrouped);

header("Content-Type: application/json");

echo json_encode([
    "success" => true,
    "nbCommandes" => count($commandesGrouped),
    "commandes" => $commandesGrouped
], JSON_PRETTY_PRINT);
header("Content-type: application/json; charset=utf-8"); 
