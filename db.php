<?php
// Fonction pour se connecter à la base de données
function connect_db() {
  // Paramètres de connexion
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "agence_spatiale";

  // Création de la connexion
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Activation du mode d'erreur PDOException
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }
}
include("header.php");
include("menuGauche.php");
?>