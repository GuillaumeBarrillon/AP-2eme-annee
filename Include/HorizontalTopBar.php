<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>SideBar</title>
</head>

<nav>
<ul>
  <p>User : <?php echo $_SESSION['user_name'];?></p>
  <a href="deconnexion.php">Déconnexion</a>
</ul> 
</nav>

<body>
    
</body>
</html>