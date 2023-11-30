<?php

include "Include/HorizontalTopBar.php";

session_start();
//
// Connexion à la base de données
//
function db_connect() {
  $dsn = 'mysql:host=localhost;dbname=ap3';  // contient le nom du serveur et de la base
  $user = 'root';
  $password = '';
  try {
    $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
    //die("Erreur lors de la connexion SQL : " . $ex->getMessage());
    die();
  }
  return $dbh;
}
?>