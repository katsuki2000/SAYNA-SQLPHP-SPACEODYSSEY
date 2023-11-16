
<?php
// Inclusion du fichier contenant la fonction connect_db
include("db.php");

// Appel de la fonction connect_db
$conn = connect_db();

// R�cup�ration de l'id de la plan�te � supprimer
$id = $_GET["id"];

// Requ�te SQL pour supprimer la plan�te
$sql_delete = "DELETE FROM planete WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bindParam(1, $id);
$stmt_delete->execute();

// Affichage d'un message de confirmation et redirection vers la liste des plan�tes
echo "<script>alert('Plan�te supprim�e avec succ�s.');</script>";
echo "<script>window.location.href = 'mission.php';</script>";
?>