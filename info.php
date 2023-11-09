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
    $sql = "select ID_Commande, Total_TTC from commande where id_utilisateur = :id_utilisateur";
    $sth = $dbh->prepare($sql);
    $sth->bindParam(':id_utilisateur', $id);
    $sth->execute();
    $rows = $sth->fetch(PDO::FETCH_ASSOC);
    $numCommande = $rows['ID_Commande'];
    $prixCommande = $rows['Total_TTC'];
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