<?php
// Inclusion du fichier contenant la fonction connect_db
include("db.php");

// Appel de la fonction connect_db
$conn = connect_db();

// R�cup�ration de l'id de la mission � supprimer
$id = $_GET["id"];

// Requ�te SQL pour supprimer les affectations de la mission
$sql_delete = "DELETE FROM affectation WHERE mission_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();

// Requ�te SQL pour supprimer la mission
$sql_delete = "DELETE FROM mission WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();

// Affichage d'un message de confirmation et redirection vers la liste des missions
echo "<script>alert('Mission supprim�e avec succ�s.');</script>";
echo "<script>window.location.href = 'mission.php';</script>";
?>