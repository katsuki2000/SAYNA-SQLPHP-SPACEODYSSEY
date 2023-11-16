<?php
/**
 * Fichier APOD.php
 * 
 * Ce fichier contient le code PHP qui affiche l'image du jour de la NASA sur le dashboard.
 * Il utilise l'API de la NASA pour récupérer les informations sur l'image du jour, comme le titre, la description et le lien.
 * Il met en place un système de cache qui stocke les informations dans la base de données et qui évite d'appeler l'API à chaque fois que quelqu'un charge le dashboard.
 */

/**
 * Fonction qui affiche l'image du jour de la NASA
 * 
 * @param mysqli $conn L'objet mysqli représentant la connexion à la base de données
 * @return void
 */
function display_apod($conn) {
  // Requête SQL pour vérifier si l'image du jour est déjà en cache
  $sql = "SELECT * FROM apod WHERE date = CURDATE()";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // Si l'image du jour est en cache, on récupère les informations depuis la base de données
    $row = $result->fetch_assoc();
    $title = $row["title"];
    $explanation = $row["explanation"];
    $url = $row["url"];
  } else {
    // Sinon, on appelle l'API de la NASA avec la clé API et la date du jour
    $api_key = "DEMO_KEY"; // Remplacez par votre clé API personnelle
    $date = date("Y-m-d"); // Format de la date : YYYY-MM-DD
    $api_url = "https://api.nasa.gov/planetary/apod?api_key=$api_key&date=$date";
    $api_response = file_get_contents($api_url);
    $api_data = json_decode($api_response, true);
    // On récupère les informations depuis le JSON
    $title = $api_data["title"];
    $explanation = $api_data["explanation"];
    $url = $api_data["url"];
    // On insère les informations dans la base de données pour le cache
    // On prépare la requête SQL avec des paramètres
    $sql = "INSERT INTO apod (date, title, explanation, url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // On lie les paramètres aux variables avec les types de données
    $stmt->bind_param("ssss", $date, $title, $explanation, $url);

    // On exécute la requête préparée
    $stmt->execute();

    // On ferme le statement
    $stmt->close();
  }
  // On affiche l'image avec son titre et sa description
  echo "<h1>$title</h1>";
  echo "<img src='$url' alt='$title'>";
  echo "<p>$explanation</p>";
}
?>