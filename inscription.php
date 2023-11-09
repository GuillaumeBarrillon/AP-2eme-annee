<?php
include 'include/db_functions.php';
// Connexion à la base
$dbh = db_connect();
// Liste des personnes
$submit = isset($_POST['submit']);
$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
if ($submit and !empty($login) and !empty($password) and !empty($email)) {
    // Vérifier si l'utilisateur existe déjà
    $checkUserQuery = "SELECT * FROM user WHERE Login = :login OR Email = :email";
    $checkUserStmt = $dbh->prepare($checkUserQuery);
    $checkUserStmt->execute(array(":login" => $login, ":email" => $email));
    $existingUser = $checkUserStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $message = "L'utilisateur existe déjà.";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (Login, password, Email) VALUES (:login, :password, :email)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(array(":login" => $login, ":password" => $hashed_password, ":email" => $email));
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
        $message = "Personne(s) créée(s)";
        header("location: listecommande.php");
    }
} else {
    $message = "Veuillez saisir une personne SVP";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>inscription</title>
</head>

<body>
    <h1>Page d'inscription</h1>
    <?= $message ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <p>Login<br><input type="text" name="login" id="login"></p>
        <p>Mot de passe<br><input type="password" name="password" id="password"></p>
        <p>Email<br><input type="mail" name="email" id="email"></p>
        <input type="submit" name="submit" value="Envoyer">
        <input type="reset" name="Réinitialiser" value="Réinitialiser">
        <button><a href="index.php">Retour</a></button>
    </form>
</body>

</html>