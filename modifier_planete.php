<?php
// Inclusion du fichier contenant la fonction connect_db
include("db.php");

// Appel de la fonction connect_db
$conn = connect_db();

// Récupération de l'id de la planète à modifier
$id = $_GET["id"];

// Requête SQL pour récupérer les informations de la planète
$sql = "SELECT * FROM planete WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $id);
$stmt->execute();
$row = $stmt->fetch();

// Récupération des données de la planète
$nom = $row["nom"];
$circonference = $row["circonference"];
$distance = $row["distance"];
$documentation = $row["documentation"];

// Traitement du formulaire de modification
if (isset($_POST["modifier"])) {
  // Récupération des données du formulaire
  $nom = $_POST["nom"];
  $circonference = $_POST["circonference"];
  $distance = $_POST["distance"];
  $documentation = $_POST["documentation"];

  // Validation des données
  $erreurs = [];
  if (empty($nom)) {
    $erreurs[] = "Le nom est obligatoire.";
  }
  if (empty($circonference) || !is_numeric($circonference)) {
    $erreurs[] = "La circonférence doit être un nombre.";
  }
  if (empty($distance) || !is_numeric($distance)) {
    $erreurs[] = "La distance doit être un nombre.";
  }
  if (empty($documentation)) {
    $erreurs[] = "La documentation est obligatoire.";
  }

  // Si pas d'erreurs, on exécute la requête SQL UPDATE
  if (empty($erreurs)) {
    $sql_update = "UPDATE planete SET nom = ?, circonference = ?, distance = ?, documentation = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(1, $nom);
    $stmt_update->bindParam(2, $circonference);
    $stmt_update->bindParam(3, $distance);
    $stmt_update->bindParam(4, $documentation);
    $stmt_update->bindParam(5, $id);
    $stmt_update->execute();

    // On affiche un message de confirmation et on redirige vers la liste des planètes
    echo "<script>alert('Planète modifiée avec succès.');</script>";
    echo "<script>window.location.href = 'planete.php';</script>";
  }
}

// Début du code HTML
?>
<!-- Contenu principal -->
<div class="content-wrapper">
  <!-- Entête du contenu -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Modifier une planète</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin de l'entête du contenu -->

  <!-- Contenu -->
  <section class="content">
    <div class="container-fluid">
      <!-- Formulaire de modification -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Saisir les informations de la planète</h3>
        </div>
        <form method="post" action="">
          <div class="card-body">
            <!-- Affichage des erreurs éventuelles -->
            <?php
            if (!empty($erreurs)) {
              echo "<div class='alert alert-danger'>";
              echo "<ul>";
              foreach ($erreurs as $erreur) {
                echo "<li>$erreur</li>";
              }
              echo "</ul>";
              echo "</div>";
            }
            ?>
            <!-- Champ nom -->
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>">
            </div>
            <!-- Champ circonférence -->
            <div class="form-group">
              <label for="circonference">Circonférence (km)</label>
              <input type="number" class="form-control" id="circonference" name="circonference" value="<?php echo $circonference; ?>">
            </div>
            <!-- Champ distance -->
            <div class="form-group">
              <label for="distance">Distance à la Terre (km)</label>
              <input type="number" class="form-control" id="distance" name="distance" value="<?php echo $distance; ?>">
            </div>
            <!-- Champ documentation -->
            <div class="form-group">
              <label for="documentation">Documentation</label>
              <textarea class="form-control" id="documentation" name="documentation"><?php echo $documentation; ?></textarea>
            </div>
          </div>
          <div class="card-footer">
            <!-- Bouton pour modifier la planète -->
            <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
          </div>
        </form>
      </div>
      <!-- Fin du formulaire de modification -->
    </div>
  </section>
  <!-- Fin du contenu -->
</div>
<!-- Fin du contenu principal -->
<?php
// Inclusion du fichier footer.php
include("footer.php");
?>