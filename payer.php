<?php
include "Include/db_functions.php";

if (!isset($_SESSION["commande"])) {
  header("Location: listecommande.php");
  die();
}

// Connexion à la base
$dbh = db_connect();

$typeCommande = $_SESSION['typeCommande'];
$message = array();

$nb_cb = isset($_POST['nb_cb']) ? $_POST['nb_cb'] : '';
$dt_expiration = isset($_POST['dt_expiration']) ? $_POST['dt_expiration'] : '';
$cvc = isset($_POST['cvc']) ? $_POST['cvc'] : '';
$submit = isset($_POST['submit']) ?? false;

$numCommande = $_SESSION["commande"]["id"];
try {
  // Vérifier la connexion à la base de données
  if (!$dbh) {
    die("<p>Erreur de connexion à la base de données</p>");
  }
  $id = $_SESSION['user_id'];
  $sql = "SELECT id_commande, total_commande FROM commande WHERE id_commande = :idcmd";
  $sth = $dbh->prepare($sql);
  $sth->bindParam(':idcmd', $numCommande);
  $sth->execute();
  $rows = $sth->fetch(PDO::FETCH_ASSOC);
  $prixCommande = $rows['total_commande'];
} catch (PDOException $ex) {
  die("Erreur lors de la requête SQL : " . $ex->getMessage());
}

if ($submit) {
  if (empty($nb_cb)) {
    $message[] = "Ajouter le numéro de la carte bancaire";
  }

  if (!mb_strlen($nb_cb) == 16) {
    $message[] = "Le numéro de la carte bancaire est de 16 caracthère";
  }

  if (empty($dt_expiration)) {
    $message[] = "La date d'expiration est obligatoir";
  }
  if (empty($cvc)) {
    $message[] = "Ajouter le numéro CVC";
  }

  if (!mb_strlen($nb_cb) == 3) {
    $message[] = "Le numéro du CVC est de 3";
  }

  if (count($message) == 0) {
    header("Location: info.php");
  }
}

?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Payer</title>
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <h1>Payer</h1>
  <?php echo "Vous avez commandé ";
  if ($typeCommande == 2) 
  {
    echo "sur place";
  } else
  {
    echo "à emporter";
  }
  ?><br>
  <?= "Commande n° {$numCommande} pour un montant de {$prixCommande}€"; ?>

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
    <button><a href="listecommande.php">Retour</a></button>
  </form>



</body>

</html>