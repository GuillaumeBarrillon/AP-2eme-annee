<?php
include "Include/db_functions.php";

// Connexion à la base
$dbh = db_connect();

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

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Payer</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>
  <h1>Payer</h1>
  <?= "Commande n° {$numCommande} pour un montant de {$prixCommande}"; ?>
  <p>Numéro de carte bancaire<br><input type="text" name="" id=""></p>
  <p>Date d'expiration</p>
  <select name="mois">
    <option value="Janvier">mois</option>
    <option value="Janvier">Janvier</option>
    <option value="Février">Février</option>
    <option value="Mars">Mars</option>
    <option value="Avril">Avril</option>
    <option value="Mai">Mai</option>
    <option value="Juin">Juin</option>
    <option value="Juillet">Juillet</option>
    <option value="Août">Août</option>
    <option value="Septembre">Septembre</option>
    <option value="Octobre">Octobre</option>
    <option value="Novembre">Novembre</option>
    <option value="Décembre">Décembre</option>
  </select>
  <select name="année">
    <option value="2023">année</option>
    <option value="2023">2023</option>
    <option value="2024">2024</option>
    <option value="2025">2025</option>
    <option value="2026">2026</option>
    <option value="2027">2027</option>
    <option value="2028">2028</option>
    <option value="2029">2029</option>
    <option value="2030">2030</option>
    <option value="2031">2031</option>
    <option value="2032">2032</option>
    <option value="2033">2033</option>
    <option value="2034">2034</option>
    <option value="2034">2034</option>
  </select>

  <p>CVC<br><input type="text" name="" id=""></p>
  <input type="button" value="Valider">
  <a href="listecommande.php">Retour</a>
</body>

</html>