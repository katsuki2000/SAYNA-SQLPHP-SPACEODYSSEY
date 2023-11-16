<?php
// Inclusion du fichier contenant la fonction connect_db
include("db.php");

// Appel de la fonction connect_db
$conn = connect_db();

// Récupération de l'id de la mission à supprimer
$id = $_GET["id"];

// Requête SQL pour supprimer les affectations de la mission
$sql_delete = "DELETE FROM affectation WHERE mission_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();

// Requête SQL pour supprimer la mission
$sql_delete = "DELETE FROM mission WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();

// Affichage d'un message de confirmation et redirection vers la liste des missions
echo "<script>alert('Mission supprimée avec succès.');</script>";
echo "<script>window.location.href = 'mission.php';</script>";
?>