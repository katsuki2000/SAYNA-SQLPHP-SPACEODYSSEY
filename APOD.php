<?php
/**
 * Fichier APOD.php
 * 
 * Ce fichier contient le code PHP qui affiche l'image du jour de la NASA sur le dashboard.
 * Il utilise l'API de la NASA pour r�cup�rer les informations sur l'image du jour, comme le titre, la description et le lien.
 * Il met en place un syst�me de cache qui stocke les informations dans la base de donn�es et qui �vite d'appeler l'API � chaque fois que quelqu'un charge le dashboard.
 */

/**
 * Fonction qui affiche l'image du jour de la NASA
 * 
 * @param mysqli $conn L'objet mysqli repr�sentant la connexion � la base de donn�es
 * @return void
 */
function display_apod($conn) {
  // Requ�te SQL pour v�rifier si l'image du jour est d�j� en cache
  $sql = "SELECT * FROM apod WHERE date = CURDATE()";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // Si l'image du jour est en cache, on r�cup�re les informations depuis la base de donn�es
    $row = $result->fetch_assoc();
    $title = $row["title"];
    $explanation = $row["explanation"];
    $url = $row["url"];
  } else {
    // Sinon, on appelle l'API de la NASA avec la cl� API et la date du jour
    $api_key = "DEMO_KEY"; // Remplacez par votre cl� API personnelle
    $date = date("Y-m-d"); // Format de la date : YYYY-MM-DD
    $api_url = "https://api.nasa.gov/planetary/apod?api_key=$api_key&date=$date";
    $api_response = file_get_contents($api_url);
    $api_data = json_decode($api_response, true);
    // On r�cup�re les informations depuis le JSON
    $title = $api_data["title"];
    $explanation = $api_data["explanation"];
    $url = $api_data["url"];
    // On ins�re les informations dans la base de donn�es pour le cache
    // On pr�pare la requ�te SQL avec des param�tres
    $sql = "INSERT INTO apod (date, title, explanation, url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // On lie les param�tres aux variables avec les types de donn�es
    $stmt->bind_param("ssss", $date, $title, $explanation, $url);

    // On ex�cute la requ�te pr�par�e
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