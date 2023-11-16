
<?php
// Inclusion du fichier contenant la fonction connect_db
include("db.php");

// Appel de la fonction connect_db
$conn = connect_db();

// Récupération de l'id de la planète à supprimer
$id = $_GET["id"];

// Requête SQL pour supprimer la planète
$sql_delete = "DELETE FROM planete WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bindParam(1, $id);
$stmt_delete->execute();

// Affichage d'un message de confirmation et redirection vers la liste des planètes
echo "<script>alert('Planète supprimée avec succès.');</script>";
echo "<script>window.location.href = 'mission.php';</script>";
?>