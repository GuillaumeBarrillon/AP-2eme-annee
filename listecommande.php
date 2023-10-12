<?php
include 'Include/db_functions.php';

// Connexion à la base
$dbh=db_connect();

$submit = isset($_POST['submit']);

if ($submit) {

        $quantites = [];
        foreach ($_POST as $key => $value) {
            $exploded = explode("_", $key);
            if ($exploded[0] == "qte") {
                var_dump($exploded);
                if ((int)($value) > 0) {
                    $quantites[$exploded[1]] = (int)$value;
                }
            }
        }

    if (count($quantites) > 0) {

    }

    $type = $_POST['typeCommande'];

    // Récupère le contenu des checkbox
    if ($type == "place"){
        $_SESSION['typeCommande'] = "sur place";
        //header("Location: payer.php");
        //exit();
    }

    if ($type == "emporter") {
        $_SESSION['typeCommande'] = "à emporter";
        //header("Location: payer.php");
        //exit();
    }
}

// Select table produit
 {
    $sql="Select * FROM produit;";
    try {
        $sth = $dbh->query($sql);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die( "<p>Erreur lors de la requête SQL : " . $ex->getMessage() . "</p>");
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
<form method="POST">
    <table>
        <th>Nom du plat</th>
        <th>Prix</th>
        <th>Quantité</th>


<?php
if (count($rows)>0) {
    foreach ($rows as $row)
        { 
            echo "<tr>";
            echo "<td>". $row["Libelle"]."</td>";
            echo "<td><p>". $row["Prix"]."€</p></td>";
            echo "<td> <input type='number' name='qte_{$row['ID_Produit']}' id='number'> </td>";
            echo "</tr>";
       }
}

?>
    </table>



 
  <h3>Veuillez choisir:</h3>

        <input type="radio" id="surPlace" name="typeCommande" value="place" checked/> Sur place <br>
        <input type="radio" id="aEmporter" name="typeCommande" value="emporter" /> A emporter<br>
        <input type="submit" name="submit" value="Payer">
    </form>








</body>
</html>