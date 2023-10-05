<?php 
include "Include/db_functions.php";

//Se connecter a db_connect
$dbh = db_connect();

$message = "";  // Message d'erreur

// Récupère le contenu du formulaire
$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$submit = isset($_POST['submit']);

if ($submit) {
    
    try {
        // Vérifier la connexion à la base de données
        if (!$dbh) {
            die("<p>Erreur de connexion à la base de données</p>");
        }
        $sql = "select * from utilisateur where Login=:login and Mot_de_passe=:password";
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':login', $login);
        $sth->bindParam(':password', $password);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
    if (count($rows) != 0) {
        header("Location: listecommande.php");
        exit();
    } else {
        $message = "login et/ou password invalide";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <p><?= $message; ?></p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <p>Identifiant <input type="text" name="login" id="login"></p>
        <p>Mot de passe <input type="text" name="password" id="password"></p>
        <input type="submit" name="submit" value="Connexion">
        <input type="reset" value="Annuler">
    </form>
    <a href="index.php">Déconnexion</a>
    
</body>
</html>