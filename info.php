<?php
include "Include/db_functions.php";

// Connexion à la base
$dbh = db_connect();

$typeCommande = $_SESSION['typeCommande'];

try {
    // Vérifier la connexion à la base de données
    if (!$dbh) {
      die("<p>Erreur de connexion à la base de données</p>");
    }
    $id = $_SESSION['user_id'];
    $sql = "SELECT id_commande, total_commande FROM commande WHERE id_user = :id_user";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(':id_user', $id);
    $sth->execute();
    $rows = $sth->fetch(PDO::FETCH_ASSOC);
    $numCommande = $rows['id_commande'];
    $prixCommande = $rows['total_commande'];
  } catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= "Votre commande n° {$numCommande} pour un prix de {$prixCommande}"; ?>
    <p>Vous resevrez mail dés que votre commande sera prête</p>
    <a href="listecommande.php">Acceuil</a>
    

  
    
</body>
</html>