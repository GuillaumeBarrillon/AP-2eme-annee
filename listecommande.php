<?php




include 'Include/db_functions.php';
// Connexion à la base
$dbh=db_connect();

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
            echo "<td> <input type='number'></td>"; 
       }
}
?>
    </table>


    <div>
         <a href="payer.php"><input type="button" value="Commander"></a></p>
    </div>



</body>
</html>