<?php
include 'include/db_functions.php';
include "Include/Init.php";

session_unset(); // Détruit toutes les variables de session
session_destroy(); // Détruit la session (mais pas le cookie)
header("Location: index.php");
exit();
?>