<?php
include 'Include/db_functions.php';
include "Include/Init.php";

// Connexion à la base
$dbh = db_connect();

$submit = isset($_POST['submit']);
if ($submit) {
    $quantites = [];
    foreach ($_POST as $key => $value) {
        $exploded = explode("_", $key);
        if ($exploded[0] == "qte") {
            if ((int)($value) > 0) {
                $quantites[$exploded[1]] = (int)$value;
            }
        }
    }

    $type = $_POST['typeCommande'];

    // Récupère le contenu des checkbox
    if ($type == "place") {
        $_SESSION['typeCommande'] = 2;
    }

    if ($type == "emporter") {
        $_SESSION['typeCommande'] = 1;
    }

    if (count($quantites) > 0) {
        // Inserer une nouvelle commande
        $sql = "INSERT INTO commande(id_user, id_etat, date, total_commande, type_conso) VALUES (:id_user, :id_etat, SYSDATE(), :total_commande, :type_conso)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            ":id_user" => $_SESSION['user_id'],
            ":id_etat" => 0,
            ":total_commande" => 0,
            ":type_conso" => $_SESSION['typeCommande'],
        ]);

        $idCommandeInseree = $dbh->lastInsertId();
        $_SESSION["commande"] = [
            "id" => $idCommandeInseree
        ];
        foreach ($quantites as $identifiantPlat => $quantite) {
            // Etape 1. Insert dans ligne commande
            $sql = "INSERT INTO ligne(id_commande, id_produit, qte, total_ligne_ht) VALUES(:id_commande, :idproduit, :qte, :total_ligne_ht)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                ":id_commande" => $idCommandeInseree,
                ":idproduit" => $identifiantPlat,
                ":qte" => $quantite,
                ":total_ligne_ht" => 0,
            ]);
        }
    }
   
    header("Location: payer.php");
}

// Select table produit
{
    $sql = "Select * FROM produit;";
    try {
        $sth = $dbh->query($sql);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("<p>Erreur lors de la requête SQL : " . $ex->getMessage() . "</p>");
    }
}
?>




<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Liste Commande</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form method="POST">
        <div class="product-list">
            <?php
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    echo "<div class='product-card'>";
                    echo "<div class='product-image'>";
                    echo "<img src='img/{$row['Image']}' alt='Image Produit'>";
                    echo "</div>"; // fermeture div .product-image
                    echo "<div class='product-details'>";
                    echo "<div class='text-details'>";
                    echo "<div class='product-name'>" . $row["libelle"] . "</div>";
                    echo "<div class='product-price'>" . $row["prix_ht"] . "€</div>";
                    echo "</div>"; // fermeture div .text-details
                    echo "<div class='quantity'>";
                    echo "<label for='qte_{$row['id_produit']}'>Quantité: </label>";
                    echo "<input class='quantity-input' type='number' name='qte_{$row['id_produit']}' id='qte_{$row['id_produit']}' />";
                    echo "</div>"; // fermeture div .quantity
                    echo "</div>"; // fermeture div .product-details
                    echo "</div>"; // fermeture div .product-card
                }
            }
            ?>
        </div>

        <h3>Veuillez choisir:</h3>
        <input type="radio" id="surPlace" name="typeCommande" value="place" checked /> Sur place <br>
        <input type="radio" id="aEmporter" name="typeCommande" value="emporter" /> A emporter<br>
        <input type="submit" name="submit" value="Payer">
    </form>
</body>

</html>