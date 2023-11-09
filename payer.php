<?php
include "Include/db_functions.php";

// Connexion à la base
$dbh = db_connect();

$typeCommande = $_SESSION['typeCommande'];
$message = array();

$nb_cb = isset($_POST['nb_cb']) ? $_POST['nb_cb'] : '';
$dt_expiration = isset($_POST['dt_expiration']) ? $_POST['dt_expiration'] : '';
$cvc = isset($_POST['cvc']) ? $_POST['cvc'] : '';
$submit = isset($_POST['submit']) ?? false;

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

if ($submit) {
  if(empty($nb_cb)){
    $message[] = "Ajouter le numéro de la carte bancaire";
  }
  if(empty($dt_expiration)){
    $message[] = "La date d'expiration est obligatoir";
  }
  if(empty($cvc)){
    $message[] = "Ajouter le numéro CVC";
  }if (count($message) == 0) {
    header("Location: info.php");
  }
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
  <?= "Vous avez commandé {$typeCommande} "; ?><br>
  <?= "Commande n° {$numCommande} pour un montant de {$prixCommande}"; ?>
  
  <?php
    if (count($message) > 0) {
      echo "<ul>";
      foreach ($message as $messages) {
        echo "<li>" . $messages . "</li>";
      }
      echo "</ul>";
    }
  ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <p>Numéro de carte bancaire <br> <input type="text" name="nb_cb" id="nb_cb"></p>
    <p>Date d'expiration <br> <input type="date" name="dt_expiration" id="dt_expiration"></p>
    <p>CVC <br> <input type="text" name="cvc" id="cvc"></p>
    <input type="submit" value="Payer" name="submit">
    <a href="listecommande.php">Retour</a>
  </form>

  
  
</body>

</html>