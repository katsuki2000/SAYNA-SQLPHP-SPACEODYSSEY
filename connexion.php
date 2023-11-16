
<?php
// Définition des constantes de connexion à la base de données
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "stellar_tech");

// Connexion à la base de données
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

// Gestion de l'erreur de connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>